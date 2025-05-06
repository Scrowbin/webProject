<?php

require_once('helper.php');


$image = $mangaInfo['CoverLink'];
$pubStatus = $mangaInfo['PublicationStatus'];
$pubYear = $mangaInfo['PublicationYear'];
$mangaNameOG = $mangaInfo['MangaNameOG'];
$mangaNameEN = $mangaInfo['MangaNameEN'];
$mangaDesc= $mangaInfo['MangaDiscription'];
$priorityTags = [];
$normalTags = [];

foreach ($tags as $tagName) {
    if (in_array(strtolower($tagName), ['gore', 'sexual violence'])) {
        $priorityTags[] = $tagName;
    } else {
        $normalTags[] = $tagName;
    }
}
$mangaAuthors = combineAuthorsAndArtists($authorsRaw,$artistsRaw)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/mangaInfo.css">
    <title><?=$mangaNameOG?> - Mangadax</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <!-- Background Image Div (Moved Here) -->
    <div class="bg-image">
        <style>
            .bg-image{
                position: absolute; /* Keep absolute positioning */
                top: 0;             /* Align to top */
                left: 0;            /* Align to left */
                width: 100%;        /* Full width */
                height: 400px;       /* Specific height (adjust as needed) */
                z-index: -1;        /* Behind content */

                background: linear-gradient(to right,
                rgba(0, 0, 0, 0.7) 10%,
                rgba(0, 0, 0, 0.45) 50%,   /* Midpoint transition */
                rgba(0, 0, 0, 0) 90%),   /* Fully transparent near the right */
                url("../IMG/<?=$mangaID?>/<?=$image?>");  /* Background image - KEEP DYNAMIC */
                background-position: center 20%;
                background-repeat: no-repeat;
                background-size: cover;
                filter: blur(2.5px);
            }
        </style>
    </div>

    <div class="container mt-3 main-manga-info-container"> <!-- Added class for targeting -->
        <div class = "manga-container">
            <div class="manga-card">
                <!-- Left: Cover Image -->
                <div class="manga-cover">
                        <img src="../IMG/<?=$mangaID?>/<?=$image?>" alt="Manga Cover">
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
                    <div class="mt-2 d-flex align-items-center manga-data">
                        <span class="text-warning"><i class="bi bi-star-fill"></i> <?=$avgRating?></span>
                        <span class="ms-3"><i class="bi bi-bookmark"></i> <?=$follows?></span>
                        <span class="ms-3"><i class="bi bi-chat-dots"></i> <?=$totalCom?></span>
                        <span class="ms-3"><i class="bi bi-eye"></i> N/A</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Buttons -->
    <div class="container mt-3 ">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="btn-wrapper">
                <form method="POST" action="../controller/addToLibrary.php"
                    class="m-0" id="add-form"
                    data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>"
                    data-bookmarked="<?= $isBookmarked ? 'true' : 'false' ?>">
                    <input type="hidden" name="mangaID" value="<?= $mangaID ?>">
                    <button type="submit" class="btn btn-orange d-flex align-items-center">
                        <?php if ($isBookmarked): ?>
                            <i class="bi bi-check2 me-2"></i>
                            <span class="d-none d-md-inline">Added to Library</span>
                        <?php else: ?>
                            <i class="bi bi-bookmark me-2"></i>
                            <span class="d-none d-md-inline">Add To Library</span>
                        <?php endif; ?>
                    </button>
                </form>
            </div>
            <div class="btn-wrapper">
                <form method="POST" action="../controller/submitRating.php"
                    id="rating-form" class="m-0"
                    data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <input type="hidden" name="rating" id="rating-input" value="">
                    <input type="hidden" name="mangaID" value="<?= $mangaID ?>">

                    <div class="dropdown">
                        <button class="btn btn-orange d-flex align-items-center justify-content-center no-caret"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-star me-2"></i>
                            <span class="d-none d-md-inline">
                                <?= $userRating === 0 ? "Rate" : "($userRating)" ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            $ratings = [
                                10 => "Masterpiece", 9 => "Great", 8 => "Very Good", 7 => "Good",
                                6 => "Fine", 5 => "Average", 4 => "Bad", 3 => "Very Bad",
                                2 => "Horrible", 1 => "Appalling"
                            ];

                            foreach ($ratings as $val => $label) {
                                echo "<li><a class='dropdown-item' href='#' data-value='$val'>($val) $label</a></li>";
                            }

                            if ($userRating != 0) {
                                echo "<li><a class='dropdown-item' href='#' data-value='0'>Remove Rating</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </form>
            </div>

            <!-- Report -->
            <button class="btn btn-outline-secondary d-flex align-items-center" id = "report-btn">
                <i class="bi bi-flag me-2"></i>
                <span class="d-none d-md-inline">Report</span>
            </button>

            <!-- Upload Chapter -->
            <?php
                if ($role==="admin"){
            ?>
                <button class="btn btn-outline-secondary d-flex align-items-center" onclick="window.location.href='upload_controller.php?MangaID=<?=$mangaID?>'">
                    <i class="bi bi-upload me-2"></i>
                    <span class="d-none d-md-inline">Upload Chapter</span>
                </button>
                <button class="btn btn-outline-secondary d-flex align-items-center" onclick="window.location.href='delete_controller.php?MangaID=<?=$mangaID?>'">
                    <i class="bi bi-trash me-2"></i>
                    <span class="d-none d-md-inline">Delete Chapter</span>
                </button>
                <button class="btn btn-outline-secondary d-flex align-items-center" onclick="window.location.href='edit_manga.php?MangaID=<?=$mangaID?>'">
                    <i class="bi bi-pencil-square me-2"></i>
                    <span class="d-none d-md-inline">Edit Manga</span>
                </button>

            <?php  
                }
            ?>
    </div>





        <!-- tags -->
        <div class="mt-2">
            <?php
                if ($mangaInfo["ContentRating"]=="Suggestive"){
                    ?>
                        <span class="badge mb-1" style="background-color: #da7500"><?=strtoupper($mangaInfo["ContentRating"])?></span>
                    <?php
                }
                if ($mangaInfo["ContentRating"]=="Erotica" ){
                    ?>
                        <span class="badge mb-1" style="background-color: #ff4040"><?=strtoupper($mangaInfo["ContentRating"])?></span>
                    <?php
                }
                foreach ($priorityTags as $tagName) {
                    ?>
                    <span class="badge bg-danger mb-1" style="background-color: #ff4040"><?= strtoupper($tagName) ?></span>
                    <?php
                }
                
                foreach ($normalTags as $tagName) {
                    ?>
                    <span class="badge mb-1"><?= strtoupper($tagName) ?></span>
                    <?php
                }
            ?>
        </div>

        <div class="mt-2">
            <?php
                echo renderPublicationStatus($pubStatus, $pubYear);
            ?>
        </div>
    </div>

    <div class = "manga-disc container mt-3 mb-3 d-flex flex-column">
        <div class="manga-description">
            <p class="description-text"><?=$mangaDesc?></p>
        </div>
        <button class="see-more-btn">See More</button>
    </div>




    <!-- chapters part -->

    <div class="volumes-and-chapters container">
    <?php

        foreach ($grouped as $group) {
            $volume = truncateNumber($group[0]['Volume']);
            $firstChapter = truncateNumber($group[0]['ChapterNumber']);
            $lastChapter = truncateNumber($group[count($group) - 1]['ChapterNumber']);
            $chapterCount = count($group);

            echo '
                <div class = "volumes mb-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col text-start">Volume ' . $volume . '</div>
                            <div class="col text-center">' . $lastChapter . ' - ' . $firstChapter . '</div>
                            <div class="col text-end">' . $chapterCount . '</div>
                        </div>
                    </div>
            ';
            foreach($group as $chapters){
                $chapterNum = truncateNumber($chapters['ChapterNumber']);

                ?>
                <div class="chapter-container mt-1 "onclick="window.location.href='../controller/mangaRead_controller.php?chapterID=<?=$chapters['ChapterID']?>'">
                    <div class="chapter-info p-2">
                        <div class="info-left">
                            <div>
                                <img class="icon" src="../IMG/eye.svg">

                                <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                                <span class="chapter-title">
                                    <strong>Ch. <?=$chapterNum?> – <?=$chapters['ChapterName']?></strong>
                                </span>
                            </div>

                            <a href="#" class="scan-group">
                                <img src="../IMG/avatar.svg" alt="" class="icon">
                                <?=$chapters['ScangroupName']?>
                            </a>
                        </div>

                        <div class="info-middle">
                            <span class="time">
                                <img src="../IMG/clock.svg" class="icon">

                                <?=timeAgo($chapters['UploadTime'])?>
                            </span>
                            <span class="uploader">
                                <img src="../IMG/avatar.svg" alt="" class="icon">
                                <a href="#"><?=$chapters['UploaderName']?></a>
                            </span>
                        </div>

                        <div class="info-right">
                            <span class="views">
                                <img class="icon" src="../IMG/eye.svg">
                                <strong>N/A</strong>
                            </span>
                            <a href="../controller/comments_controller.php?commentsID=<?=$chapters['CommentSectionID']?>" class="comments">
                                <img src="../IMG/comment.svg" alt="">
                                <strong><?=$chapters['NumOfComments']?></strong>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';

        }
    ?>

    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script> <!-- JS for Navbar/Sidebar -->
    <script src="../JS/search.js"></script> <!-- JS for Search -->
    <script src="../JS/mangaInfo.js"></script>

</body>
</html>