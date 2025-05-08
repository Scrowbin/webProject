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
    <title>Delete Manga Chapters - MangaDax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>

    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/mangaInfo.css">
    <style>
        body {
            padding-top: 0;
        }
    </style>
</head>
<body class="bg-light">
<?php
    // Set the path prefix for the navbar
    $pathPrefix = '../';
    include 'includes/navbar_minimal.php';
?>
    <div class = "manga-container">
        <a href="../controller/mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
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
            <div class="alert alert-warning mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Warning:</strong> Deleting chapters will permanently remove them and all associated comments. This action cannot be undone.
            </div>

            <form action="../controller/deleteChapter.php" method="POST">
            <input type="hidden" name="MangaID" value="<?= $mangaID ?>">
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

                <div class="d-flex justify-content-between mt-3">
                    <a href="../controller/mangaInfo_Controller.php?MangaID=<?=$mangaID?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Manga
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete Selected Chapters
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    // Check if the 'status' GET parameter exists and is set to 'success'
    if (isset($_GET['status'])) {
        // Optional: You might want to get the ID too for a more specific message
        if($_GET['status'] === 'success')
            $message = "Deleted successfully."; // Default message
        else
            $message = "Delete failed."; // Default message
    ?>

        <div id="deleteSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i> <?php echo $message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <script>
        // Use DOMContentLoaded to ensure the element exists and Bootstrap JS is ready
        document.addEventListener('DOMContentLoaded', function() {
            const toastElement = document.getElementById('deleteSuccessToast');
            if (toastElement) { // Check if the element exists
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        });
        </script>

    <?php
    } // End of the PHP if statement
    ?>
</div>
</body>
</html>
