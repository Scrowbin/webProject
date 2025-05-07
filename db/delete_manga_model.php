<?php
require_once('pdo.php');
require_once('delete_model.php');
function mangaExist($mangaID):bool{
    $sql = "SELECT 1 FROM manga WHERE MangaID = ?";
    $result = pdo_query($sql,$mangaID);
    return !empty($result); // true if there is a row, false if empty
}

function getChapters($mangaID){
    $sql = "SELECT ChapterID FROM chapter WHERE MangaID = ?";
    $result = pdo_query($sql,$mangaID);
    return $result;
}

function unmapAuthor($mangaID){
    $sql = "DELETE FROM manga_author WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}

function unmapArtist($mangaID){
    $sql = "DELETE FROM manga_artist WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}
function unmapTag($mangaID){
    $sql = "DELETE FROM manga_tag WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}
function deleteManga($mangaID){
    $sql = "DELETE FROM manga WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}

function resetMangaAutoIncrement(){
    try {
        // Get a direct connection to execute the SQL directly
        $conn = pdo_get_connection();

        // Count the number of manga records
        $stmt = $conn->query("SELECT COUNT(*) as count FROM manga");
        $count = $stmt->fetchColumn();

        // If there are no records, set to 1, otherwise set to count+1
        $nextID = ($count > 0) ? $count + 1 : 1;

        // Force the auto-increment to the next sequential ID
        // This is a direct SQL command that should work in MySQL
        $stmt = $conn->prepare("ALTER TABLE manga AUTO_INCREMENT = ?");
        $success = $stmt->execute([$nextID]);

        if ($success) {
            // Log the new auto-increment value
            error_log("Auto-increment reset to: " . $nextID);
        } else {
            error_log("Failed to reset auto-increment");
        }

        return $success;
    } catch (PDOException $e) {
        error_log("Error resetting auto-increment: " . $e->getMessage());
        return false;
    }
}

/**
 * Force reset the auto-increment to a specific value (6 in this case)
 * This is a direct fix for the current issue
 */
function forceResetAutoIncrement($value = 6) {
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare("ALTER TABLE manga AUTO_INCREMENT = ?");
        $success = $stmt->execute([$value]);

        if ($success) {
            error_log("Auto-increment forced to: " . $value);
        } else {
            error_log("Failed to force auto-increment");
        }

        return $success;
    } catch (PDOException $e) {
        error_log("Error forcing auto-increment: " . $e->getMessage());
        return false;
    }
}