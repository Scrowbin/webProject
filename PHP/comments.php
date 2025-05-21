<?php
require_once('helper.php');
$mangaNameOG = $mangaInfo['MangaNameOG'];
$mangaNameEN = $mangaInfo['MangaNameEN'];
$mangaCover = $mangaInfo['CoverLink'];
$authors = implode(', ', array_column($authorsRaw, 'AuthorName'));
$artists = implode(', ', array_column($artistsRaw, 'ArtistName'));
$mangaAuthors = $authors . ($authors && $artists ? ' | ' : '') . $artists;

$chapterNumber = truncateNumber($chapterNumber);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/CSS/comments.css">
</head>
<body class="p-4">

<div class="container" id="comment-section">
    <div class = "manga-container">
        <?php
            $chapterSlug = "/read/" . $mangaSlug . "/chapter-" . str_replace(".","-",$chapterNumber);
        ?>
        <a href = "<?=$chapterSlug?>">
            <div class="bg-image">
                <style>
                    .bg-image{
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        z-index: -1;

                        background: linear-gradient(to right,  
                        rgba(0, 0, 0, 0.7) 10%, 
                        rgba(0, 0, 0, 0.45) 50%,   
                        rgba(0, 0, 0, 0) 90%),   
                        url("/IMG/<?=$mangaID?>/<?=$mangaCover?>");  
                        background-position: center 20%; 
                        background-repeat: no-repeat;
                        background-size: cover;
                        filter: blur(2.5px);
                    }
                </style>
            </div>
            <div class="manga-card">
                <!-- Left: Cover Image -->
                <div class="manga-cover">
                        <img src="/IMG/<?=$mangaID?>/<?=$mangaCover?>" alt="Manga Cover">
                </div>
        
                <!-- Right: Details -->
                <div class="manga-details">
                    <div class="manga-header">
                        <div class="manga-title"><strong><?=$mangaNameOG?></strong></div>
                        <div class = "manga-title-english"><?=$mangaNameEN?></div>
                    </div>
                    <div class="artist-name">
                        <?=$mangaAuthors?>
                    </div>
                    <div class="chapter">
                        <strong>Ch. <?=$chapterNumber?> – <?=$chapterName?></strong>
                    </div>
                
                </div>
            </div>
        </a>
    </div>
    <div id="comments-container">
        
    </div >
    
    <!-- Comment Form -->
    <div class="comment rounded p-3">
        <form method="POST" 
            id = "comment-form"
            data-section-id="<?= $commentsID ?>"
            data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>"
            data-url="/controller/addComment_controller.php">
            <div class="mb-3" id = "post-comment">
                <label for="commentText" class="form-label fw-bold text-light">Write a comment</label>
                <div id="reply-preview" class="mb-2"></div>
                

                <input type="hidden" name="CommentSectionID" value="<?= $commentsID ?>">
                <input type="hidden" name="replyID" id="replyID" value ="0">
                <textarea class="form-control" id="commentText" name="commentText" rows="4" placeholder="Write your comment here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-orange"><i class="bi bi-send me-1"></i>Post Comment</button>
        </form>
    </div>

    <div id="pagination" class = "d-flex align-items-center justify-content-center"></div>
        
    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
        <div id="loginToast" class="toast align-items-center text-bg-danger border-0" 
            role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="3000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    You must be logged in to do this.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const commentsID = <?=json_encode($commentsID)?>;
</script>
<script src="/JS/comments.JS"></script>
</body>
</html>
