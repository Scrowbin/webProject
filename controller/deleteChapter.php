<?php
    require_once('../db/delete_model.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mangaID = $_POST['MangaID'];
        $chapterIDs = $_POST["chapterIds[]"];

        $hasError = false;

        foreach ($chapterIDs as $chapterID){
            $commentSectionID = getCommentSectionID($chapterID);
            try{
                deleteChapterPages($chapterID);
                deleteComments($commentSectionID);
                deleteCommentSection($commentSectionID);
                deleteChapter($chapterID);
            }
            catch (Exception $e){
                $hasError = true;
                $errorMessage = $e->getMessage(); // Capture the specific error message
                break;
            }
        }
        if ($hasError) {
            // Redirect with error message
            header("Location: delete_controller.php?MangaID=$mangaID&status=fail&message=" . urlencode($errorMessage));
        } else {
            // Redirect with success message
            header("Location: mangaInfo_controller.php?MangaID=$mangaID&status=success&message=" . urlencode('Chapters deleted successfully.'));
        }
        exit;
    }
?>  