<?php
require_once('../db/delete_manga_model.php');
require_once('../db/account_db.php');
require_once('../db/pdo.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
$isLoggedIn = isset($userID, $username);
$role = $isLoggedIn ? get_role($userID) : null;

if (!$isLoggedIn || $role !== "admin") {
    exit("You must be logged in as an admin");
}

$mangaID = $_POST["MangaID"] ?? "";
if (empty($mangaID)) {
    exit('Missing manga ID');
}

if (!mangaExist($mangaID)) {
    exit('No manga found to delete');
}

$chapterIDs = getChapters($mangaID);

try {
    // Delete each chapter and its related content
    foreach ($chapterIDs as $chapterID) {
        $commentSectionID = getCommentSectionID($chapterID);
        deleteChapterPages($chapterID);
        deleteComments($commentSectionID);
        deleteCommentSection($commentSectionID);
        deleteChapter($chapterID);
    }

    // Unmap relations and delete the manga itself
    unmapAuthor($mangaID);
    unmapArtist($mangaID);
    unmapTag($mangaID);
    deleteManga($mangaID);

    // Delete the manga's image folder
    $mangaImageDir = "../IMG/" . $mangaID . "/";
    $folderDeleted = true;

    if (file_exists($mangaImageDir) && is_dir($mangaImageDir)) {
        // Recursive function to delete directory and its contents
        function deleteDirectory($dir) {
            if (!file_exists($dir)) return true;
            if (!is_dir($dir)) return unlink($dir);

            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') continue;
                if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
            }

            return rmdir($dir);
        }

        $folderDeleted = deleteDirectory($mangaImageDir);
        if (!$folderDeleted) {
            error_log("Failed to delete manga folder: " . $mangaImageDir);
        }
    }

    // Reset auto-increment counter using the direct method
    // Count existing manga to determine the next ID
    $conn = pdo_get_connection();
    $stmt = $conn->query("SELECT COUNT(*) FROM manga");
    $count = $stmt->fetchColumn();
    $nextID = $count + 1;

    // Force reset the auto-increment to the next sequential ID
    $resetSuccess = forceResetAutoIncrement($nextID);
    if (!$resetSuccess) {
        error_log("Failed to reset manga auto-increment counter");
    }

    // Log the current state for debugging
    $stmt = $conn->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'manga' AND TABLE_NAME = 'manga'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("Current manga auto-increment value: " . ($result['AUTO_INCREMENT'] ?? 'unknown'));

    // Redirect to homepage after successful deletion
    header("Location: ../index.php");
    exit;
} catch (Exception $e) {
    header("Location: ../PHP/deleteManga.php?success=0&message=" . urlencode($e->getMessage()));
    exit;
}