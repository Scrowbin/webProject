<?php
session_start();
require_once('../db/mangaInfoPdo.php');
if (!isset($_SESSION['userID'])) {
    die("User not logged in");
}

$userID = $_SESSION['userID'];
$mangaID = $_POST['mangaID'] ?? null;

if ($mangaID) {
    // addToLibrary($userID, $mangaID);
    header("Location: mangaInfo.php?MangaID=$mangaID");
    exit;
} else {
    die("Invalid request");
}

?>
