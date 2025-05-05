<?php
    require_once('../db/delete_model.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mangaID = $_POST['MangaID'];
        $chapterIDs = $_POST["chapterIds"];
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
            $safeMessage = rawurlencode($errorMessage); // handles special characters, including line breaks
            header("Location: delete_controller.php?MangaID=$mangaID&status=fail&message=$safeMessage");
        } else {
            $successMessage = rawurlencode('Chapters deleted successfully.');
            header("Location: mangaInfo_controller.php?MangaID=$mangaID&status=success&message=$successMessage");
        }
        
        exit;
    }
?>  