<?php
session_start();
require_once('../db/LibraryAndRating.php');
if (!isset($_SESSION['userID'])) {
    $userID = getUserID($_SESSION['username']);
    if (!$userID)
        die("User not logged in");    
    $_SESSION['userID'] = $userID;
    
}

$userID = $_SESSION['userID'];
$mangaID = $_POST['mangaID'] ?? null;

if ($mangaID) {
    if (!isBookmarked($mangaID,$userID))
        addToLibrary($mangaID,$userID);
    else    
        removeBookmark($mangaID,$userID);
    header("Location: ../controller/mangaInfo_Controller.php?MangaID=$mangaID");
    exit;
} else {
    die("Invalid request");
}

?>
