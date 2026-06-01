<?php

require_once __DIR__ . '/../config/bootstrap.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    header("Location: ../controllers/comments_controller.php?commentsID=$commentSectionID");
    require __DIR__ . '/../models/commentsPdo.php';
    require __DIR__ . '/../models/LibraryAndRating.php';


    if (!isset($_SESSION['userID'])) {
        http_response_code(401);
        exit("You must be logged in to comment.");
    }

    $userID = $_SESSION['userID'];
    $comment = $_POST['commentText'];
    $commentSectionID = $_POST['CommentSectionID'];
    $replyID = $_POST['replyID'] ?? 0; // Optional, defaults to 0 if not set

    // var_dump($userID,$comment,$commentSectionID,$replyID);
    $success = addComment($commentSectionID, $comment, $userID, $replyID);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to add comment.']);
    }
    exit;
?>
