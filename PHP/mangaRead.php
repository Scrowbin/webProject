<?php
    require_once('helper.php');
    //Chapter info
    $chapterID = $_GET['chapterID'] ?? null;
    $chapterName = $chapterInfo['ChapterName'];
    $chapterVolume = truncateNumber($chapterInfo['Volume']);
    $chapterNumber = truncateNumber($chapterInfo['ChapterNumber']);
    $chapterScangroup = $chapterInfo['ScangroupName'];
    $chapterUploader = $chapterInfo['UploaderName'];
    $mangaName = $mangaInfo['MangaNameOG'];
    $mangaID = $mangaInfo['MangaID'];



    $lastPageNumber = $pages[count($pages)-1]["PageNumber"];

    $chapterDropdownValues = [];
    foreach($chapters as $chapter){
        $chapterDropdownValues[] = truncateNumber($chapter['ChapterNumber']);
    }

    function displayTitle($name,$number){
        if ($name === '' || $name === null){
            return "<title>Mangadax Ch. $number</title>";
        }
        else return "<title>Mangadax Ch. $number - $name</title>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo displayTitle($chapterName,$chapterNumber)?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/mangaRead.css">
</head>

<body>
    <?php
    // Define path prefix for includes
    $pathPrefix = '../';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';
    ?>
    <div class="layout">
        <header class="d-none">
            <!-- Hidden header -->
        </header>
        <button type="button" class="btn sticky hidden" id="menu-sticky" onclick="toggleRightSidebar()"><i class="bi bi-list"></i></button>

        <main>
            <div id="topReadBar" class="top-read-bar">
                <?php echo displayNameOrChapter($chapterName,$chapterNumber)?>
                <div>
                    <a class="mangaInfo" href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
                        <strong><?=$mangaName?></strong>
                    </a>
                </div>

                <div class="info-row">
                    <div class="info-cell">
                        <span>Vol. <?=$chapterVolume?>, Ch. <?=$chapterNumber?></span>
                    </div>
                    <div class="info-cell">
                        <span>Pg. 1/<?=$lastPageNumber?></span>
                    </div>
                    <div class="info-cell">
                        <button onclick='toggleSidebar()' class="menu-button" name="menu">Menu</button>
                    </div>
                </div>
            </div>

            <div class="" id="page-container">
                    <?php

                    for($i=0;$i<count($pages);$i++){
                        ?>
                        <img src="../IMG/<?=$mangaID?>/<?=$chapterNumber?>/<?=$pageLinks[$i]?>" class="img-fit-width" id="page-<?=$i+1?>" alt="Page <?=$i+1?>">
                        <?php
                    }
                    ?>
            </div>

            <nav id = "progress-bar" class="">
                <div class="p-bar-number hidden" id = "p-bar-number-low">1</div>
                <?php
                    foreach($pageValues as $pageValue){
                        ?>
                            <div class ="progressBarButton"><div class="color-part"></div><div class="floating-number"><?=$pageValue?></div></div>
                        <?php
                    }
                ?>
                <div class="p-bar-number hidden" id = 'p-bar-number-high'><?=$lastPageNumber?></div>
            </nav>
            <?php
                if ($nextChapterID) {
                    echo "<button id='next-chapter' onclick=\"location.href='mangaRead_Controller.php?chapterID=$nextChapterID'\">Next Chapter</button>";
                } else {
                    echo "<button id='next-chapter' onclick=\"location.href='mangaInfo_Controller.php?MangaID=$mangaID'\">Back to Info</button>";
                }
            ?>

        </main>
        <!-- class = "" -->
        <aside id="rightSidebar" class="sticky close">
            <div class="rightSidebar-header">
                <button type="button" class="btn" id="close-btn" ><i class ="bi bi-x"></i></button>
                <button type="button" class="btn" id="pin-btn"><i class="bi bi-pin"></i></button>
            </div>
            <div class="rightSidebar-body">
                <div class="inline-info">
                    <div class="right-manga-info">
                        <i class="bi bi-book"></i>
                        <span class="right-manga">
                            <a href="mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
                                <strong><?=$mangaName?></strong>
                            </a>
                        </span>
                    </div>

                    <div class="right-chapter">
                        <i class="bi bi-file-earmark"></i>
                        <span><?=$chapterName?></span>
                    </div>
                </div>
                <hr>
                <!-- Page Selector -->
                <div class="page-selector">
                    <button class="btn nav-button" id = "prevPageBtn"><i class="bi bi-chevron-left "></i></button>
                    <div class="dropdown-container">
                        <label class="page-label" id ="page-label">Page</label>
                        <select class="dropdown" name="page" id ="page-dropdown">
                        <?php
                            foreach($pageValues as $pageValue){
                                ?>
                                    <option value="<?=$pageValue?>"><?=$pageValue?></option>
                                    <div class ="progressBarButton"><div class="color-part"></div><div class="floating-number"><?=$pageValue?></div></div>
                                <?php
                            }
                                ?>
                        </select>
                    </div>
                    <button class="btn nav-button" id = "nextPageBtn"><i class="bi bi-chevron-right"></i></button>
                </div>

                <!-- Chapter Selector -->
                <div class="chapter-selector">
                    <button class='btn btn-page' id='prevCh-btn'><i class='bi bi-chevron-left'></i></button>
                    <div class="dropdown-container">
                        <label class="page-label" id="chapter-label">Chapter</label>
                        <select class="dropdown" name="chapter" id="chapter-dropdown">
                            <?php
                            foreach ($chapters as $chapter) {
                                $val = $chapter['ChapterID'];
                                $display = truncateNumber($chapter['ChapterNumber']);
                                $selected = ($val == $chapterID) ? 'selected' : '';
                                echo "<option value=\"$val\" $selected>Chapter $display</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button class='btn btn-page' id='nextCh-btn'><i class='bi bi-chevron-right'></i></button>

                </div>



                <!-- Report Chapter -->
                <button class="btn"id = "report-btn">Report Chapter</button>

                <hr>

                <!-- Comments -->
                <a href="comments_controller.php?commentsID=<?=$commentSection['CommentSectionID']?>">
                    <button class="btn" id = "comment-btn">
                        <i class="bi bi-chat-left"></i> <?=$commentSection['NumOfComments']?> Comments
                    </button>
                </a>


                <!-- Uploaded By -->
                <div class="mb-3" id = "uploader-info">
                    <p class="mb-1">Uploaded By</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person"></i>
                        <span class="ms-2"><?=$chapterScangroup?></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person"></i>
                        <a href="#" class="ms-2 text-primary"><?=$chapterUploader?></a>
                    </div>
                </div>

                <hr>

                <!-- Reader Settings -->
                <div id = "reader-settings">
                    <button class="btn reader-btn" id = "readMethod"><i class = "bi bi-files"></i> Long Strip</button>
                    <button  id="toggleFit" class="btn reader-btn"><i class="bi bi-arrows-fullscreen"></i> Fit Width</button>
                    <!-- <button class="btn reader-btn"><i class="bi bi-eye-slash"></i> Header Hidden</button> -->
                    <button class="btn reader-btn" id = "progress-setting"><i class="bi bi-list"></i> Normal Progress</button>
                    <!-- <button class="btn reader-btn"><i class="bi bi-gear"></i> Reader Settings</button> -->

                </div>

            </div>
        </aside>
    </div>

</body>
<script>
    const mangaID = <?= json_encode($mangaID) ?>;
    const prevChapterID = <?= json_encode($prevChapterID) ?>;
    const nextChapterID = <?= json_encode($nextChapterID) ?>;
</script>
<script src="../JS/navbar.js"></script>
<script src="../JS/search.js"></script>
<script src="../JS/mangaRead.js"></script>
</html>