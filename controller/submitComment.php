<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require('../db/commentsPdo.php');
    require('../db/LibraryAndRating.php');
    
    if (!isset($_SESSION['userID'])) {
        $userID = getUserID($_SESSION['username']);
        if ($userID==null){
            http_response_code(401);
            exit("You must be logged in to rate.");
        }
        
        $_SESSION['userID'] = $userID;        
    }

    $comment = $_POST['commentText'];
    $commentSectionID = $_POST['CommentSectionID'];
    $replyID = $_POST['replyID'] ?? 0; // Optional, defaults to 0 if not set

    // var_dump($userID,$comment,$commentSectionID,$replyID);
    addComment($commentSectionID,$comment,$userID,$replyID);
    header("Location: ../controller/comments_controller.php?commentsID=$commentSectionID");
?>
