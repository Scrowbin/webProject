<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once("../db/latestUpdates_model.php");

    $page = $_GET['page'] ?? 1;
    $limit = 20; // Hiển thị 20 chapter mới nhất trên mỗi trang
    $offset = ($page - 1) * $limit;

    // Lấy tất cả các chapter mới nhất, không lọc theo manga
    $chapters = getAllLatestChapters(1000, 0);

    $isLatestUpdates = true;
    $pathPrefix = '../'; // Define path prefix for includes relative to controller directory

    // Thêm thông tin comment cho mỗi chapter
    foreach ($chapters as &$chapter) {
        $commentOfChapter = getComments($chapter['ChapterID']);
        $chapter['NumOfComments'] = $commentOfChapter["NumOfComments"] ?? 0;
        $chapter['CommentSectionID'] = $commentOfChapter["CommentSectionID"] ?? 0;
    }

    // Tính toán phân trang
    $totalChapters = count($chapters);
    $totalPages = ceil($totalChapters / $limit);
    $currentPage = $page;

    // Lấy các chapter cho trang hiện tại
    $chapters = array_slice($chapters, $offset, $limit);

    // Hiển thị trang latestUpdates với danh sách các chapter mới nhất
    include("../PHP/latestUpdates.php");
?>