<?php
/**
 * Random Manga Controller
 * Redirects to a random manga page
 */

require_once "../db/pdo.php";
require_once "../db/mangaInfoPdo.php";

// Get a random manga ID from the database
function getRandomMangaID() {
    $sql = "SELECT MangaID FROM manga ORDER BY RAND() LIMIT 1";
    $result = pdo_query($sql);
    
    if (!empty($result)) {
        return $result[0]['MangaID'];
    }
    
    // Fallback to ID 1 if no manga found
    return 1;
}

// Get a random manga ID
$randomMangaID = getRandomMangaID();

// Redirect to the manga info page
header("Location: mangaInfo_Controller.php?MangaID=" . $randomMangaID);
exit;
?>
