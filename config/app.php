<?php

/**
 * Public site URL (no trailing slash). Set APP_URL in .env on production.
 */
function app_url(string $path = ''): string
{
    $base = env('APP_URL');

    if ($base === null || $base === '') {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = $scheme . '://' . $host;
    }

    $base = rtrim($base, '/');
    $path = '/' . ltrim($path, '/');

    return $path === '/' ? $base . '/' : $base . $path;
}

function site_title(): string
{
    return env('SITE_TITLE', 'Manga Reading Website');
}

function site_name(): string
{
    return env('SITE_NAME', 'MangaDax');
}

function site_subtitle(): string
{
    return env('SITE_SUBTITLE', 'Non-commercial student project for learning web development and database systems');
}

function site_author(): string
{
    return env('SITE_AUTHOR', 'scrowbin');
}

/** Use /manga/slug style URLs. Set PRETTY_URLS=1 only if root .htaccess works on your host. */
function use_pretty_urls(): bool
{
    return filter_var(env('PRETTY_URLS', '0'), FILTER_VALIDATE_BOOLEAN);
}

/** Chapter value for ?chapter= query (e.g. 3.0 → "3", 1.5 → "1.5"). */
function chapter_query_value($chapterNumber)
{
    if ($chapterNumber === null || $chapterNumber === '') {
        return '0';
    }
    $n = ($chapterNumber == floor($chapterNumber)) ? (int) $chapterNumber : $chapterNumber;

    return (string) $n;
}

/** Chapter number for pretty URL segment (e.g. 3.5 → "3-5"). */
function chapter_number_slug($chapterNumber): string
{
    return str_replace('.', '-', chapter_query_value($chapterNumber));
}

function manga_url(string $slug): string
{
    if (use_pretty_urls()) {
        return '/manga/' . $slug;
    }

    return '/controllers/mangaInfo_Controller.php?slug=' . rawurlencode($slug);
}

function chapter_read_url(string $slug, $chapterNumber): string
{
    if (use_pretty_urls()) {
        return '/read/' . $slug . '/chapter-' . chapter_number_slug($chapterNumber);
    }

    return '/controllers/mangaRead_Controller.php?slug=' . rawurlencode($slug)
        . '&chapter=' . rawurlencode(chapter_query_value($chapterNumber));
}

function comments_url(string $slug, $chapterNumber): string
{
    if (use_pretty_urls()) {
        return '/comments/' . $slug . '/chapter-' . chapter_number_slug($chapterNumber);
    }

    return '/controllers/comments_controller.php?slug=' . rawurlencode($slug)
        . '&chapter=' . rawurlencode(chapter_query_value($chapterNumber));
}

/** Sidebar and static pages. */
function page_url(string $page): string
{
    $controllers = [
        'library' => '/controllers/library_controller.php',
        'reading-history' => '/controllers/readingHistory_controller.php',
        'latest-updates' => '/controllers/latestUpdates_controller.php',
        'recently-added' => '/controllers/recently_added_controller.php',
        'advanced-search' => '/controllers/advanced_search_controller.php',
        'search' => '/controllers/advanced_search_controller.php',
        'my-follows' => '/controllers/follows_controller.php',
        'random' => '/controllers/random_manga_controller.php',
        'about' => '/controllers/about_controller.php',
        'login' => '/controllers/auth_controller.php?action=login',
        'register' => '/controllers/auth_controller.php?action=register',
    ];

    if (use_pretty_urls()) {
        return '/' . $page;
    }

    return $controllers[$page] ?? '/';
}
