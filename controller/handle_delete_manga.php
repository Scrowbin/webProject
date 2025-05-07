<?php
require_once('../db/delete_manga_model.php');
require_once('../db/account_db.php');

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

    header("Location: ../PHP/deleteManga.php?success=1");
    exit;
} catch (Exception $e) {
    header("Location: ../PHP/deleteManga.php?success=0&message=" . urlencode($e->getMessage()));
    exit;
}