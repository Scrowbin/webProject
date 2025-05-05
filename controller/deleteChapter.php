<?php
// Ensure no output or extra whitespace before this line
require_once('../db/delete_model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST
    
    $mangaID = trim($_POST['MangaID']);
    $chapterIDs = $_POST['chapterIds'];  // Ensure 'chapterIds' is sent properly from form
    $hasError = false;
    if (empty($mangaID) || !is_array($chapterIDs) || empty($chapterIDs)) {
        header("Location: delete_controller.php?MangaID=" . urlencode($mangaID) . "&status=fail");
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
    if ($hasError) {
        header("Location: delete_controller.php?MangaID=" . urlencode($mangaID) . "&status=fail");
    } else {
        header("Location: delete_controller.php?MangaID=" . urlencode($mangaID) . "&status=success");
    }

    exit; 
}
?>
