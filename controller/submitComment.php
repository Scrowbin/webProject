<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('../db/commentsPdo.php');
    require('../db/LibraryAndRating.php');
    
    $userID = $_SESSION['userID'] ?? 0;
    if ($userID==0){
        $userID= getUserID($_SESSION['username'])??0;
        if ($userID== 0)
            exit('You must be logged in to comment');
    }
    $comment = $_POST['commentText'];
    $commentSectionID = $_POST['CommentSectionID'];
    $replyID = $_POST['replyID'] ?? 0; // Optional, defaults to 0 if not set

    // var_dump($userID,$comment,$commentSectionID,$replyID);
    addComment($commentSectionID,$comment,$userID,$replyID);
    header("Location: ../controller/comments_controller.php?commentsID=$commentSectionID");
?>
