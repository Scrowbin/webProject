<?php
require_once('helper.php');

$image = $mangaInfo['CoverLink'];
$pubStatus = $mangaInfo['PublicationStatus'];
$pubYear = $mangaInfo['PublicationYear'];
$mangaNameOG = $mangaInfo['MangaNameOG'];
$mangaNameEN = $mangaInfo['MangaNameEN'];
$mangaDesc= $mangaInfo['MangaDiscription'];

$authors = implode(', ', array_column($authorsRaw, 'AuthorName'));
$artists = implode(', ', array_column($artistsRaw, 'ArtistName'));

$mangaAuthors = $authors . ($authors && $artists ? ' | ' : '') . $artists;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <!-- Swiper CSS (Nếu cần cho trang này) -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/> -->
    <link rel="stylesheet" href="../CSS/navbar.css"> <!-- CSS for Navbar/Sidebar -->
    <link rel="stylesheet" href="../CSS/mangaInfo.css"> <!-- CSS riêng của trang -->
    <title><?=$mangaNameOG?> - Mangadax</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container mt-3 ">
        <div class = "manga-container">
            <div class="bg-image">
            </div>
            <div class="manga-card">
                <!-- Left: Cover Image -->
                <div class="manga-cover">
                        <img src="../IMG/<?=$image?>" alt="Manga Cover">
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
                        <span class="text-warning"><i class="bi bi-star-fill"></i> 9.13</span>
                        <span class="ms-3"><i class="bi bi-bookmark"></i> 14k</span>
                        <span class="ms-3"><i class="bi bi-chat-dots"></i> 27</span>
                        <span class="ms-3"><i class="bi bi-eye"></i> N/A</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Buttons -->
    <div class="container mt-3 ">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Add to Library -->
            <div class="btn-wrapper">
                <form method="POST" action="addToLibrary.php" class="m-0">
                    <input type="hidden" name="mangaID" value="<?=$mangaID?>">
                    <button type="submit" class="btn btn-orange d-flex align-items-center">
                        <i class="bi bi-bookmark me-2"></i>
                        <span class="d-none d-md-inline">Add To Library</span>
                    </button>
                </form>
            </div>

            <!-- Rate -->
            <div class="btn-wrapper">
                <form action="../controller/submitRating.php" method="POST" id="rating-form" class="m-0" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <input type="hidden" name="rating" id="rating-input" value="">
                    <input type="hidden" name="mangaID" value="<?=$mangaID?>">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-star me-2"></i>
                            <span class="d-none d-md-inline">Rate</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-value="10">(10) Masterpiece</a></li>
                            <li><a class="dropdown-item" href="#" data-value="9">(9) Great</a></li>
                            <li><a class="dropdown-item" href="#" data-value="8">(8) Very Good</a></li>
                            <li><a class="dropdown-item" href="#" data-value="7">(7) Good</a></li>
                            <li><a class="dropdown-item" href="#" data-value="6">(6) Fine</a></li>
                            <li><a class="dropdown-item" href="#" data-value="5">(5) Average</a></li>
                            <li><a class="dropdown-item" href="#" data-value="4">(4) Bad</a></li>
                            <li><a class="dropdown-item" href="#" data-value="3">(3) Very Bad</a></li>
                            <li><a class="dropdown-item" href="#" data-value="2">(2) Horrible</a></li>
                            <li><a class="dropdown-item" href="#" data-value="1">(1) Appalling</a></li>
                        </ul>
                    </div>
                </form>
            </div>

            <!-- Report -->
            <button class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-flag me-2"></i>
                <span class="d-none d-md-inline">Report</span>
            </button>

            <!-- Upload Chapter -->
            <button class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-upload me-2"></i>
                <span class="d-none d-md-inline">Upload Chapter</span>
            </button>
    </div>



      
       
    
        <div class="mt-2">
            <?php
                foreach($tags as $Tagname){
                    ?>
                        <span class="badge mb-1"><?=strtoupper($Tagname)?></span>
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
                <div class="chapter-container mt-1 "onclick="window.location.href='mangaRead_Controller.php?chapterID=<?=$chapters['ChapterID']?>'">   
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
                            <!--<a href="commentSection.php?=<?=$chapters['CommentSectionID']?>" class="comments">  -->
                            <a href="#" class="comments">
                                <img src="../IMG/comment.svg" alt="">
                                <!-- <strong></strong> -->
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
                    You must be logged in to rate.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script> <!-- JS for Navbar/Sidebar -->

    <script>
        document.querySelectorAll('.chapter-container a').forEach(link => {
            link.addEventListener('click', e => e.stopPropagation());
        });
        window.onload = function() {
        const descriptionText = document.querySelector('.description-text');
        const seeMoreBtn = document.querySelector('.see-more-btn');

        // Check if the description is overflowing
        if (descriptionText.scrollHeight > descriptionText.clientHeight) {
            descriptionText.parentElement.classList.add('overflow');
        }

        // Toggle full description on "See More" button click
        seeMoreBtn.addEventListener('click', function() {
            if (descriptionText.style.webkitLineClamp === "3") {
                descriptionText.style.webkitLineClamp = "unset"; // Show full text
                seeMoreBtn.innerText = "See Less"; // Change button text
            } else {
                descriptionText.style.webkitLineClamp = "3"; // Truncate text
                seeMoreBtn.innerText = "See More"; // Change button text back
            }
        });
        }
        document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('rating-form');
        const isLoggedIn = form.dataset.loggedIn === "true";
        const toastElement = document.getElementById('loginToast');
        const toast = new bootstrap.Toast(toastElement);

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();

                if (!isLoggedIn) {
                    toast.show(); // Show toast if not logged in
                    return;
                }

                // Set rating value in hidden input
                const ratingValue = this.dataset.value;
                document.getElementById('rating-input').value = ratingValue;

                // Optional: update button text (UI feedback)
                const label = this.textContent.trim();
                document.querySelector('.dropdown button span').textContent = label;

                form.submit();
            });
        });

        // Redundant, but safe fallback in case the form is submitted some other way
        form.addEventListener('submit', function (e) {
            if (!isLoggedIn) {
                e.preventDefault();
                toast.show();
            }
            });
        });

    </script>

</body>
</html>