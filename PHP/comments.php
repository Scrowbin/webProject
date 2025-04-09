<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/comments.css">
</head>
<body class="p-4">

<div class="container">
    <div class = "manga-container">
        <div class="bg-image">
        </div>
        <div class="manga-card">
            <!-- Left: Cover Image -->
            <div class="manga-cover">
                    <img src="../IMG/1/m1.jpg" alt="Manga Cover">
            </div>
    
            <!-- Right: Details -->
            <div class="manga-details">
                <div class="manga-header">
                    <div class="manga-title"><strong>Zeikin de Katta Hon</strong></div>
                    <div class = "manga-title-english">Books Bought With Taxes</div>
                </div>
                <div class="artist-name">
                    Zuino, Keiyama Kei
                </div>
            
            </div>
        </div>
    </div>
    <!-- One Comment -->
    <div class="comment rounded p-3 mb-4">
        <div class="d-flex align-items-start mb-2">
            <img src="https://via.placeholder.com/50" alt="User Avatar" class="rounded-circle me-3" width="50" height="50">
            <div class="user-info flex-grow-1">
                <div class="fw-bold text-warning">Floou</div>
            </div>
            <div class="text-end text-muted small">
                <div>May 20, 2023</div>
                <div>#2</div>
            </div>
        </div>

        <!-- Comment Body -->
        <div class="comment-body mb-3">
            Wow, this is a really solid work. Enticing characters, good paneling, and entertaining dialog. It's not like this is the best comedy, but I'm probably going to read it all and enjoy it.
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="#" class="text-danger small">⚠️ Report</a>
            <div>
                <a href="#" class="me-3 text-danger"><i class="bi bi-hand-thumbs-up me-1"></i>Like</a>
                <a href="#" class="text-danger"><i class="bi bi-reply me-1"></i>Reply</a>
            </div>
        </div>

        <!-- Reaction Bar -->
    </div>
    <!-- One Reply Comment -->
    <div class="comment rounded p-3 mb-4">
        <div class="d-flex align-items-start mb-2">
            <img src="https://via.placeholder.com/50x75" alt="User Avatar" class="rounded me-3" width="50" height="75">
            <div class="user-info flex-grow-1">
                <div class="fw-bold text-warning">pab101</div>
            </div>
            <div class="text-end text-muted small">
                <div>May 5, 2024</div>
                <div>#8</div>
            </div>
        </div>

       
       
        <!-- Comment Body -->
        <div class="comment-body mb-3">
            the manga wouldve been good if the plot wasn't VERY FORCED, i mean really? she remembered him from his first name even after he changed his last name? took her a minute to find what he owed from 10 years ago? mc just changes moods from joking to serious and the others go along with it at a moment's notice, and how tf did the buff guy know mc wanna know something from literally ZERO CLUE
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="#" class="text-danger small">⚠️ Report</a>
            <div>
                <a href="#" class="me-3 text-danger"><i class="bi bi-hand-thumbs-up me-1"></i>Like</a>
                <a href="#" class="text-danger"><i class="bi bi-reply me-1"></i>Reply</a>
            </div>
        </div>
    </div>
     <!-- One Reply Comment -->
     <div class="comment rounded p-3 mb-4">
        <div class="d-flex align-items-start mb-2">
            <img src="https://via.placeholder.com/50x75" alt="User Avatar" class="rounded me-3" width="50" height="75">
            <div class="user-info flex-grow-1">
                <div class="fw-bold text-warning">dzeef</div>
            </div>
            <div class="text-end text-muted small">
                <div>May 5, 2024</div>
                <div>#8</div>
            </div>
        </div>

        <!-- Quoted Message -->
        <div class="quote">
            <div class="quote-author">pab001 said:</div>
            <div>she remembered him from his first name even after he changed his last name?
            </div>
        </div>
        <!-- Comment Body -->
        <div class="comment-body mb-3">
            It's in the computer, she look it up in the computer. You can see that she's even confused when she sees someone with the same first name.
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="#" class="text-danger small">⚠️ Report</a>
            <div>
                <a href="#" class="me-3 text-danger"><i class="bi bi-hand-thumbs-up me-1"></i>Like</a>
                <a href="#" class="text-danger"><i class="bi bi-reply me-1"></i>Reply</a>
            </div>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="comment rounded p-3">
        <form method="POST" action="submitComment.php">
            <div class="mb-3">
                <label for="commentText" class="form-label fw-bold text-light">Post a Reply</label>
                <textarea class="form-control" id="commentText" name="commentText" rows="4" placeholder="Write your reply here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-orange"><i class="bi bi-send me-1"></i>Post Comment</button>
        </form>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
