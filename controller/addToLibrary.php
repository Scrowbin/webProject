<?php
require_once('../db/mangaRead.php');

$mangaID = $_POST['mangaID'] ?? null;
$userID = $_POST['userID'] ?? null;

if ($mangaID && $userID) {
    addToLibrary($userID, $mangaID); 
    header("Location: mangaInfo.php?MangaID=$mangaID"); 
    exit;
} else {
    die("Invalid request");
}
?>
