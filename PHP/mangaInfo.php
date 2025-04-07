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
    <title>mangaInfo</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class = "manga-container">
        <div class="bg-image">
        </div>
        <div class="manga-card">
            <!-- Left: Cover Image -->
            <div class="manga-cover">
                    <img src="../IMG/m1.jpg" alt="Manga Cover">
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
                <div class="mt-2 d-flex align-items-center manga-data">
                    <span class="text-warning"><i class="bi bi-star-fill"></i> 9.13</span>
                    <span class="ms-3"><i class="bi bi-bookmark"></i> 14k</span>
                    <span class="ms-3"><i class="bi bi-chat-dots"></i> 27</span>
                    <span class="ms-3"><i class="bi bi-eye"></i> N/A</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="container mt-3 ">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 buttons">
            <button class="btn btn-orange flex-grow-1">
                <i class="bi bi-bookmark"></i> 
                <span class="d-none d-md-inline">Add To Library</span>
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
                <i class="bi bi-star"></i>
                <span class="d-none d-md-inline">Rate</span>
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
                <i class="bi bi-list"></i> 
                <span class="d-none d-md-inline">Add to MDList</span>
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
                <i class="bi bi-book"></i> 
                <span class="d-none d-md-inline">Continue Reading</span>
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
                <i class="bi bi-flag"></i> 
                <span class="d-none d-md-inline">Report</span>
            </button>
            <button class="btn btn-outline-secondary flex-grow-1">
                <i class="bi bi-upload"></i> 
                <span class="d-none d-md-inline">Upload Chapter</span>
            </button>
        </div>
      
       
    
        <div class="mt-2">
            <span class="badge">COMEDY</span>
            <span class="badge">DRAMA</span>
            <span class="badge">DELINQUENTS</span>
            <span class="badge">SLICE OF LIFE</span>
        </div>
    
        <div class="mt-2">
            <span class="text-success"><strong>● PUBLICATION: 2021, ONGOING</strong></span>
        </div>
    </div>

    <div class = "manga-disc container mt-3 mb-3 d-flex flex-column">
        <div class="manga-description">
            <p class="description-text">Ishidaira is a delinquent who visited the library for the first time since elementary school. But then, he was pointed out by Hayasemaru and Shirai, who works at the library, that he has not returned a book that he borrowed ten years ago. A manga about how Ishidaira went from trying to borrow a book from a library to working there instead.</p>
        </div>
        <button class="see-more-btn">See More</button>
    </div>




    <!-- chapters part -->
   
    <div class="volumes-and-chapters container">
        <div class = "volumes mb-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col text-start">Volume 10</div>
                    <div class="col text-center">68-71</div>
                    <div class="col text-end">4</div>
                </div>
            </div>
                        
            <div class="chapter-container mt-1" onclick="window.location.href='mangaRead.html'">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">

                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="index.html" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>

                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>

                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">

                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>

                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>

                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">

                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>

                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>

                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">

                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>

                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>

                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
        </div>

        <div class = "volumes mb-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col text-start">Volume 9</div>
                    <div class="col text-center">64-67</div>
                    <div class="col text-end">4</div>
                </div>
            </div>
                        
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">
    
                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">
    
                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>
    
                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>
    
                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">
    
                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">
    
                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>
    
                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>
    
                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">
    
                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">
    
                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>
    
                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>
    
                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
            <div class="chapter-container mt-1 ">   
                <div class="chapter-info p-2">
                    <div class="info-left">
                        <div>
                            <img class="icon" src="../IMG/eye.svg">
    
                            <img class="flag" src="https://mangadex.org/img/flags/gb.svg">
    
                            <span class="chapter-title">
                                <strong>Vol. 9 Ch. 70.5 – Vol. 9 Extras</strong>
                            </span>
                        </div>
                        
                        <a href="#" class="scan-group">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            Baking Translations
                        </a>
                    </div>
    
                    <div class="info-middle">
                        <span class="time">
                            <img src="../IMG/clock.svg" class="icon">
                            10 minutes ago
                        </span>
                        <span class="uploader">
                            <img src="../IMG/avatar.svg" alt="" class="icon">
                            <a href="#">RhyeBread_</a>
                        </span>
                    </div>
    
                    <div class="info-right">
                        <span class="views">
                            <img class="icon" src="../IMG/eye.svg">
                            <strong>N/A</strong>
                        </span>
                        <a href="#" class="comments">
                            <img src="../IMG/comment.svg" alt="">
                            <strong></strong>
                        </a>
                    </div>
                </div>    
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS (Nếu cần) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->
    <script src="../JS/navbar.js"></script> <!-- JS for Navbar/Sidebar -->
    <!-- JS riêng của trang (nếu có) -->
    <script>
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
    </script>
    <!-- <script src="../JS/mangaInfo.js"></script> -->

</body>
</html>