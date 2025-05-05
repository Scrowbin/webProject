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
    <title>Delete Manga Chapters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/mangaInfo.css">
</head>
<body class="bg-light">
    <div class = "manga-container">
        <a href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
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
                </div>
            </div>
        </a>
    </div>
    <div class="container py-5">
        <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Delete Manga Chapters</h4>
        </div>
        <div class="card-body">
            <form action="../controller/deleteChapter.php" method="POST">
            <input type="hidden" name="MangaID" value="<?= $MangaID ?>">
            <label for="chapterSelect" class="form-label">Select Chapter(s):</label>
                <select name="chapterIds[]" id="chapterSelect" class="form-select" multiple size="10">
                    <?php foreach ($grouped as $group): 
                        $volume = truncateNumber($group[0]['Volume']); ?>
                        
                        <optgroup label="Volume <?= $volume ?>">
                        <?php foreach ($group as $chapter):
                            $chapterNum = truncateNumber($chapter['ChapterNumber']);
                            $title = "Ch. $chapterNum – " . htmlspecialchars($chapter['ChapterName']); ?>
                            <option value="<?= $chapter['ChapterID'] ?>">
                                <?= $title ?>
                            </option>
                        <?php endforeach; ?>
                        </optgroup>

                    <?php endforeach; ?>
                </select>
                <div class="form-text">Hold Ctrl (Windows) or Command (Mac) to select multiple chapters.</div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        </div>
    </div>

</body>
</html>
