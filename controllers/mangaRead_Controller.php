<?php

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../models/mangaReadPdo.php';
require_once __DIR__ . '/../models/account_db.php';

try {
    $mangaSlug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
    $chapterNumber = str_replace('-', '.', isset($_GET['chapter']) ? (string) $_GET['chapter'] : '');

    if ($mangaSlug === '' || $chapterNumber === '') {
        http_response_code(400);
        exit('Missing manga slug or chapter number.');
    }

    $chapterID = getChapterID($mangaSlug, $chapterNumber);

    if (!$chapterID) {
        http_response_code(404);
        exit('Chapter not found for this manga.');
    }

    $pages = getPages($chapterID);
    if (!$pages || count($pages) === 0) {
        http_response_code(404);
        exit('This chapter has no pages uploaded yet.');
    }

    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $role = get_role($userID);

    $nextChapterNumber = getNextChapter($chapterID);
    $prevChapterNumber = getPrevChapter($chapterID);
    $chapters = getChapters($chapterID);
    $mangaInfo = getMangaInfo($chapterID);
    $chapterInfo = getChapterInfo($chapterID);

    if (!$mangaInfo || !$chapterInfo) {
        http_response_code(404);
        exit('Manga or chapter data is missing.');
    }

    $commentSection = getCommentSection($chapterID);
    if (!$commentSection) {
        $commentSection = ['CommentSectionID' => 0, 'NumOfComments' => 0];
    }

    $pageValues = [];
    $pageLinks = [];
    $i = 1;
    foreach ($pages as $page) {
        $pageValues[] = $i;
        $pageLinks[] = $page['PageLink'];
        $i++;
    }

    include __DIR__ . '/../views/mangaRead.php';
} catch (Throwable $e) {
    error_log('mangaRead_Controller: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    http_response_code(500);
    if (env('APP_DEBUG', '0') === '1') {
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Error: ' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine();
    } else {
        echo 'Unable to load this chapter. Please try again later.';
    }
}
