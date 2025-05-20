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
                <a href="/my-follows">
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
            $mangaLanguage = $m["OriginalLanguage"];
            $mangaSlug = $m["Slug"];
    ?>
            <div class="manga-card">
                <div class="manga-cover">
                    <a href="../manga/<?=$mangaSlug?>">
                        <img src="../IMG/<?=$mangaID?>/<?=$CoverLink?>" alt="Manga Cover">
                    </a>
                </div>

                <!-- Right: Details -->
                <div class="manga-details">
                    <div class="manga-title-row">
                        <div class="flag-title">
                            <?php echo getFlag($mangaLanguage);?>
                            <a href="../manga/<?=$mangaSlug?>" class="manga-title-link"><strong><?=$mangaName?></strong></a>
                        </div>
                        <div class="manga-status">
                            <?php
                                switch ($pubStatus) {
                                    case "Ongoing":
                                        echo "<span class='status-badge status-ongoing'>● " . strtoupper($pubStatus) . "</span>";
                                        break;
                                    case "Completed":
                                        echo "<span class='status-badge status-completed'>● " . strtoupper($pubStatus) . "</span>";
                                        break;
                                    case "Hiatus":
                                        echo "<span class='status-badge status-hiatus'>● " . strtoupper($pubStatus) . "</span>";
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                    <div class="manga-stats-bar">
                        <?php if (isset($m['CommentSectionID']) && $m['CommentSectionID']): ?>
                            <div class="stat-item-link">
                                <span class="stat-item"><i class="bi bi-chat-fill"></i> <?= $m['CommentCount'] ?? 0 ?></span>
                            </div>
                        <?php else: ?>
                            <span class="stat-item"><i class="bi bi-chat-fill"></i> <?= $m['CommentCount'] ?? 0 ?></span>
                        <?php endif; ?>
                        <span class="stat-item"><i class="bi bi-bookmark-fill"></i> <?= $m['FollowCount'] ?? 0 ?></span>
                        <span class="stat-item"><i class="bi bi-star-fill"></i> <?= number_format($m['AvgRating'] ?? 0, 1) ?></span>
                    </div>
                    <div class="tag-container">
                        <?php
                            $tags = $m['tags'];
                            $displayTags = array_slice($tags, 0, 5);
                            $remainingTags = count($tags) - count($displayTags);

                            foreach($displayTags as $tag){
                                echo "<span class='tag-badge'>".strtoupper($tag)."</span>";
                            }

                            if($remainingTags > 0) {
                                echo "<span class='more-tags-btn'>MORE</span>";
                                echo "<div class='hidden-tags'>";
                                for($i = 5; $i < count($tags); $i++) {
                                    echo "<span class='tag-badge'>".strtoupper($tags[$i])."</span>";
                                }
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <div class="manga-description">
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
    <script src="../JS/sidebar.js"></script>
    <script src="../JS/search.js"></script>
    <script src="../JS/library.js"></script>
</body>
</html>