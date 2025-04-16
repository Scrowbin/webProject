<?php
    require_once('helper.php');

    function renderPagination($currentPage, $totalPages, $baseUrl = '?page=') {
        echo '<ul class="pagination">';
    
        // Previous button
        if ($currentPage > 1) {
            echo '<li class="page-item">
                    <a class="page-link" href="' . $baseUrl . ($currentPage - 1) . '">&laquo;</a>
                  </li>';
        }
    
        // Always show page 1
        echo '<li class="page-item ' . ($currentPage == 1 ? 'active orange' : '') . '">
                <a class="page-link" href="' . $baseUrl . '1">1</a>
              </li>';
    
        // Dots after 1
        if ($currentPage > 4) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    
        // Pages around current
        for ($i = max(2, $currentPage - 1); $i <= min($totalPages - 1, $currentPage + 1); $i++) {
            echo '<li class="page-item ' . ($currentPage == $i ? 'active orange' : '') . '">
                    <a class="page-link" href="' . $baseUrl . $i . '">' . $i . '</a>
                  </li>';
        }
    
        // Dots before last
        if ($currentPage < $totalPages - 3) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    
        // Last page
        if ($totalPages > 1) {
            echo '<li class="page-item ' . ($currentPage == $totalPages ? 'active orange' : '') . '">
                    <a class="page-link" href="' . $baseUrl . $totalPages . '">' . $totalPages . '</a>
                  </li>';
        }
    
        // Next button
        if ($currentPage < $totalPages) {
            echo '<li class="page-item">
                    <a class="page-link" href="' . $baseUrl . ($currentPage + 1) . '">&raquo;</a>
                  </li>';
        }
    
        echo '</ul>';
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Updates - MangaDax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href = "../CSS/latestUpdates.css">

</head>
<body>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="container-xxl pt-5 mt-4">


        <?php
        if ($isLoggedIn??false|| $isLatestUpdates??false){
            if ($isLatestUpdates??false){
                ?>
                    <h1 class="mb-4">Latest Updates</h1>
                <?php
            }else{
                ?>
                    <h1 class="mb-4">My Follows</h1>
                <?php
            }
        
            foreach($grouped as $manga){
                $mangaID = $manga[0]['MangaID'];
                $mangaCover =  $manga[0]['CoverLink'];
                $mangaName = $manga[0]['MangaNameOG'];
        ?>

            <div class="manga-card">
                <!-- Left: Cover Image -->
                <div class="manga-cover">
                    <a href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
                        <img src="../IMG/<?=$mangaID?>/<?=$mangaCover?>" alt="Manga Cover">
                    </a>
                </div>
        
                <!-- Right: Details -->
                <div class="manga-details">
                    <div class="manga-header">
                        <img class="flag" src="https://mangadex.org/img/flags/jp.svg">
                        <a href="#" class="manga-title"><strong><?=$mangaName?></strong></a>
                    </div>
                    <hr>
                    <?php
                        foreach($manga as $chapter){
                            $chapterNumber = truncateNumber($chapter['ChapterNumber']);
                            $chapterName = $chapter['ChapterName'];
                            $chapterID = $chapter['ChapterID'];
                            $chapterScangroup = $chapter['ScangroupName'];
                            $uploadTime = $chapter['UploadTime'];
                            $uploader = $chapter['UploaderName'];
                            $commentsID = $chapter['CommentSectionID'];
                            $NumOfComments = $chapter['NumOfComments'];
                    ?>
                        <div class="chapter-container mb-1"  onclick="window.location.href='mangaRead_Controller.php?chapterID=<?=$chapterID?>'">

                            <div class="chapter-info">
                                <div class="info-left">
                                    <div class="chapter-title">
                                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">
                                            <strong>Ch. <?=$chapterNumber?> - <?=$chapterName?></strong>
                                    </div>
                                    <div  class="scan-group">
                                        <a href="#">
                                        <img src="../IMG/avatar.svg" alt="" class="icon">
                                        <span><?=$chapterScangroup?></span>
                                        </a>
                                    </div>
                                </div>
                
                                <div class="info-middle">
                                    <div class="time">
                                        <img src="../IMG/clock.svg" class="icon">
                                        <strong><?=timeAgo($uploadTime)?></strong>
                                    </div>
                                    <div class="uploader">
                                        <img src="../IMG/avatar.svg" alt="" class="icon">
                                        <a href="#"><?=$uploader?></a>
                                    </div>
                                </div>
                
                                <div class="info-right">
                                    <div class="views">
                                        <img class="icon" src="../IMG/eye.svg">
                                        <strong>N/A</strong>
                                    </div>
                                    <div class="comments">
                                        <a href="comments_controller.php?commentsID=<?=$commentsID?>">
                                            <img src="../IMG/comment.svg" alt="" >
                                            <strong><?=$NumOfComments?></strong>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
    
                    <?php
                        }
                    ?>
                </div>
            </div>
        <?php
            }
        }
            else{
                ?>
                <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <button class="btn custom-signin">Sign In</button>
                </div>
                                
                <?php
            }
        
        ?>
        
    </div>

    <div class="d-flex justify-content-center mt-4">
    <?php renderPagination($currentPage, $totalPages); ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>

</body>
</html>
