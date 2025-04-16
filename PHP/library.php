<?php
    require('helper.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Mangadax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/library.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container-xxl pt-5 mt-4">

    <h1>Library</h1>
    <?php
        if ($isLoggedIn){
            foreach($manga as $m){
            $mangaID = $m["MangaID"];
            $mangaName = $m["MangaNameOG"];
            $CoverLink = $m["CoverLink"];
            $pubStatus = $m["PublicationStatus"];
            $mangaDesc = $m["MangaDiscription"];
    ?>
        <div class="container-fluid wid">
            <div class="manga-card">
                <div class="manga-cover">
                    <a href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
                        <img src="../IMG/<?=$mangaID?>/<?=$CoverLink?>" alt="Manga Cover">
                    </a>
                </div>
        
                <!-- Right: Details -->
                <div class="manga-details">
                    <div class="manga-header">
                        <div class="manga-title">
                            <img class="flag" src="https://mangadex.org/img/flags/jp.svg">
                            <a href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>" class=""><strong><?=$mangaName?></strong></a>
                        </div>
                        <?php
                            switch ($pubStatus) {
                                case "Ongoing":
                                    echo "<span class='text-success pub-status'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                    break;
                                case "Completed":
                                    echo "<span class='text-primary pub-status'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                    break;
                                case "Hiatus":
                                    echo "<span class='text-warning pub-status'><strong>● " . strtoupper($pubStatus) . "</strong></span>";
                                    break;
                            }
                            
                        ?>
                        
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
    <div class="d-flex justify-content-center mt-4">
    <?php renderPagination($currentPage, $totalPages); ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
</body>
</html>