<?php
    require 'helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$isLibrary ? "Library": "Recently Added" ?>- Mangadax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/library.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container-xxl pt-5 mt-4">
        <div class="library-header">
            <?php if ($isLibrary):?>
            <div class="back-button">
                <a href="../controller/follows_controller.php">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <?php endif; ?>
            <h1><?=$isLibrary ? "Library": "Recently Added" ?></h1>
        </div>
        <div class="library-controls">
            <div class="manga-count"><?= $totalMangaCount ?> Titles</div>
            <div class="view-controls">
                <button class="view-btn list-view active"><i class="bi bi-list"></i></button>
                <button class="view-btn grid-view"><i class="bi bi-grid-3x3-gap"></i></button>
                <button class="view-btn compact-view"><i class="bi bi-grid-3x3"></i></button>
            </div>
        </div>
    <?php
    if ($isLoggedIn||$isRecentlyAdded){
    ?>
        <div class="manga-container">
    <?php
            foreach($manga as $m){
            $mangaID = $m["MangaID"];
            $mangaName = $m["MangaNameOG"];
            $CoverLink = $m["CoverLink"];
            $pubStatus = $m["PublicationStatus"];
            $mangaDesc = $m["MangaDiscription"];
    ?>
            <div class="manga-card">
                <div class="manga-cover">
                    <a href="../controller/mangaInfo_controller.php?MangaID=<?=$mangaID?>">
                        <img src="../IMG/<?=$mangaID?>/<?=$CoverLink?>" alt="Manga Cover">
                    </a>
                </div>

                <!-- Right: Details -->
                <div class="manga-details">
                    <?php
                        switch ($pubStatus) {
                            case "Ongoing":
                                echo "<span class='grid-pub-status text-success'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                break;
                            case "Completed":
                                echo "<span class='grid-pub-status text-primary'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                break;
                            case "Hiatus":
                                echo "<span class='grid-pub-status text-warning'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                break;
                        }
                    ?>
                    <div class="manga-header">
                        <div class="manga-title">
                            <img class="flag" src="https://mangadex.org/img/flags/jp.svg">
                            <a href="../controller/mangaInfo_controller.php?MangaID=<?=$mangaID?>" class=""><strong><?=$mangaName?></strong></a>
                        </div>
                    </div>
                    <div class="badge-bar">
                        <?php
                            foreach($m['tags'] as $tag){
                                echo "<span class='badge'>".strtoupper($tag)."</span>";
                            }
                        ?>
                    </div>
                    <div class="manga-desc">
                        <?=$mangaDesc?>
                    </div>
                </div>
            </div>
    <?php
            }
    ?>
        </div>
    <?php
        }
        else{
            ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <button class="btn custom-signin">Sign In</button>
            </div>

            <?php
        }
   ?>
    <div class="d-flex justify-content-center mt-4">
    <?php renderPagination($currentPage, $totalPages); ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
    <script src="../JS/search.js"></script>
    <script src="../JS/library.js"></script>
</body>
</html>