<?php
// Ensure no output or extra whitespace before this line
require_once('../db/delete_model.php');
require_once('../db/account_db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
$isLoggedIn = false;
if ($userID !=null || $username!= null){
    $isLoggedIn =true;
}
$role = get_role($userID);
if (!$isLoggedIn||$role !== "admin"){
    exit("You must be logged in as an admin");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST

    $mangaID = trim($_POST['MangaID']);
    $chapterIDs = $_POST['chapterIds'];  // Ensure 'chapterIds' is sent properly from form
    $slug = getSlugFromMangaID($mangaID);

    $hasError = false;
    if (empty($mangaID) || !is_array($chapterIDs) || empty($chapterIDs)) {
        $slug = getSlugFromMangaID($mangaID);
        header("Location: /admin/delete-chapter/" . urlencode($slug) . "?status=fail");
        exit;
    }
    foreach ($chapterIDs as $chapterID) {
        $commentSectionID = getCommentSectionID($chapterID);
        try {
            deleteChapterPages($chapterID);
            deleteComments($commentSectionID);
            deleteCommentSection($commentSectionID);
            deleteChapter($chapterID);
        } catch (Exception $e) {
            $hasError = true;
            $errorMessage = $e->getMessage(); // Capture error message from the exception
            break;  // Exit the loop on error
        }
    }

    // If there was an error
    $slug = getSlugFromMangaID($mangaID);
    if ($hasError) {
        header("Location: /admin/delete-chapter/" . urlencode($slug) . "?status=fail");
    } else {
        header("Location: /admin/delete-chapter/" . urlencode($slug) . "?status=success");
    }

    exit;
}
?>
