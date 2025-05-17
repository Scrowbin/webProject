<?php
    require_once('helper.php');
    //Chapter info
    $chapterName = $chapterInfo['ChapterName'];
    $chapterVolume = truncateNumber($chapterInfo['Volume']);
    $chapterNumber = truncateNumber($chapterInfo['ChapterNumber']);
    $chapterScangroup = $chapterInfo['ScangroupName'];
    $chapterUploader = $chapterInfo['UploaderName'];
    $mangaName = $mangaInfo['MangaNameOG'];
    $mangaID = $mangaInfo['MangaID'];
    $mangaSlug = $mangaInfo['Slug'];


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
    <link rel="stylesheet" href="/CSS/navbar.css">
    <link rel="stylesheet" href="/CSS/mangaRead.css">
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
        <button type="button" class="btn sticky hidden" id="menu-sticky" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>

        <main>
            <div id="topReadBar" class="top-read-bar">
                <?php echo displayNameOrChapter($chapterName,$chapterNumber)?>
                <div>
                    <a class="mangaInfo" href="/manga/<?= $mangaSlug ?>">
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
                        <img src="/IMG/<?=$mangaID?>/<?=$chapterNumber?>/<?=$pageLinks[$i]?>" class="img-fit-width" id="page-<?=$i+1?>" alt="Page <?=$i+1?>">
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
                if ($nextChapterNumber) {
                    $nextChapterSlug = "/read/" . $mangaSlug . "/chapter-" . str_replace(".","-",truncateNumber($nextChapterNumber));
                    echo "<button id='next-chapter' onclick=\"location.href='$nextChapterSlug'\">Next Chapter</button>";
                } else {
                    echo "<button id='next-chapter' onclick=\"location.href='/manga/$mangaSlug'\">Back to Info</button>";
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
                            <a href="/manga/<?=$mangaSlug?>">
                                <strong><?=$mangaName?></strong>
                            </a>
                        </span>
                    </div>

                    <div class="right-chapter">
                        <i class="bi bi-file-earmark"></i>
                        <span><?=$chapterName?></span>
                    </div>
                    <?php if ($role == "admin"):?>
                        <?php
                            $chapterSlug ="/admin/edit-chapter/" . $mangaSlug . '/chapter-'. str_replace(".","-",$chapterNumber);
                        ?>
                        
                        <button class="btn reader-btn" id = "editBtn" onclick="window.location.href='<?=$chapterSlug?>'; return false;"><i class = "bi bi-pencil"></i>Edit Chapter</button>
                    <?php endif;?>

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
                                $display = truncateNumber($chapter['ChapterNumber']);
                                $chapterNumberSlug = str_replace('.', '-', $display); // Slug-friendly
                                $chapterSlugDropdown = "/read/{$mangaSlug}/chapter-{$chapterNumberSlug}";
                                $selected = ($display == $chapterNumber) ? 'selected' : '';

                                echo "<option value=\"$chapterSlugDropdown\" $selected>Chapter $display</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button class='btn btn-page' id='nextCh-btn'><i class='bi bi-chevron-right'></i></button>

                </div>



                <!-- Report Chapter -->
                <button class="btn"id = "report-btn" data-bs-toggle="modal" data-bs-target="#reportModal">Report Chapter</button>

                <hr>

                <!-- Comments -->
                <?php
                    $commmentSlug ="/comments/" . $mangaSlug . '/chapter-'.$chapterNumber;
                ?>
                <a href = "<?=$commmentSlug?>">
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
<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        
        <!-- Chapter Info -->
        <div class="chapter-info p-2">
            <div class="info-left">
                <div>
                    <img class="icon" src="/IMG/eye.svg">

                    <img class="flag" src="https://mangadex.org/img/flags/gb.svg">

                    <span class="chapter-title">
                        <strong>Ch. <?=$chapterNumber?> – <?=$chapterName?></strong>
                    </span>
                </div>

                <div class="scan-group">
                    <img src="/IMG/avatar.svg" alt="" class="icon">
                    <?=$chapterScangroup?>
                </div>
            </div>

            <div class="info-middle">
                <span class="time">
                    <img src="/IMG/clock.svg" class="icon">

                    <?=timeAgo($chapterInfo['UploadTime'])?>
                </span>
                <span class="uploader">
                    <img src="/IMG/avatar.svg" alt="" class="icon">
                    <div ><?=$chapterUploader?></div>
                </span>
            </div>

            <div class="info-right">
                <span class="views">
                    <img class="icon" src="/IMG/eye.svg">
                    <strong>N/A</strong>
                </span>
                <div class="comments">
                    <img src="/IMG/comment.svg" alt="">
                    <strong><?=$commentSection['NumOfComments']?></strong>
                </div>
            </div>
        </div>

        <!-- Report Reason -->
        <form id="reportForm">
            <div class="mb-3">
                <label for="reportReason" class="form-label">Reason</label>
                <select class="form-select dropdown-reason" id="reportReason" name="reason" required>
                    <option selected disabled value="">Choose a reason</option>
                    <option value="Credit page in the middle">Credit page in the middle of the chapter</option>
                    <option value="Duplicate upload">Duplicate upload from same user/group</option>
                    <option value="Offensive content">Extraneous political/race-baiting/offensive content</option>
                    <option value="Fake or Spam">Fake/Spam chapter</option>
                    <option value="Group lock evasion">Group lock evasion</option>
                    <option value="Images not loading">Images not loading</option>
                    <option value="Incorrect chapter number">Incorrect chapter number</option>
                    <option value="Incorrect group">Incorrect group</option>
                    <option value="Incorrect or duplicate pages">Incorrect or duplicate pages</option>
                    <option value="Incorrect or missing chapter title">Incorrect or missing chapter title</option>
                    <option value="Incorrect or missing volume number">Incorrect or missing volume number</option>
                    <option value="Missing pages">Missing pages</option>
                    <option value="Naming rules broken">Naming rules broken</option>
                    <option value="Official release/Raw">Official release/Raw</option>
                    <option value="Pages out of order">Pages out of order</option>
                    <option value="Released before raws">Released before raws released</option>
                    <option value="Wrong manga">Uploaded on wrong manga</option>
                    <option value="Watermarked">Watermarked images</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <input type="hidden" name="chapterID" id="hiddenChapterID">
            <!-- Additional Info -->
            <div class="mb-3">
                <label for="additionalInfo" class="form-label">Additional Information (Optional)</label>
                <textarea class="form-control" id="additionalInfo" name="details" rows="3" placeholder="Add any details that may help the moderators..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Report</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- toast log in -->
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

<!-- Recommended toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
  <div id="reportToast" class="toast text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
</body>

<script>
    const userID = <?=json_encode($userID) ?>;
    const chapterID = <?=json_encode($chapterID) ?>;
    const mangaID = <?= json_encode($mangaID) ?>;
    const prevChapterSlug = <?= ($prevChapterNumber === null) ? json_encode(null) : json_encode("/read/" . $mangaSlug . "/chapter-" . str_replace(".","-",truncateNumber($prevChapterNumber)))?>;
    const nextChapterSlug = <?= ($nextChapterNumber === null) ? json_encode(null) : json_encode("/read/" . $mangaSlug . "/chapter-" . str_replace(".","-",truncateNumber($nextChapterNumber))) ?>;
    const mangaSlug = <?= json_encode("/manga/$mangaSlug") ?>;
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/JS/navbar.js"></script>
<script src="/JS/search.js"></script>
<script src="/JS/mangaRead.js"></script>


</html>