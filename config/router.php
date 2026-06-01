<?php

/**
 * Central URL router — used when .htaccess sends unknown paths to index.php?route=...
 * Keeps one entry point instead of index.php stubs in every folder.
 */
function app_request_path(): string
{
    // Prefer the real URL path (InfinityFree often breaks ?route=foo/bar because of "/" in query strings).
    $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $uriPath = trim($uriPath ?? '', '/');

    if ($uriPath !== '' && $uriPath !== 'index.php') {
        return $uriPath;
    }

    if (isset($_GET['route']) && $_GET['route'] !== '') {
        return trim((string) $_GET['route'], '/');
    }

    return '';
}

function route_dispatch(string $path): bool
{
    if ($path === '') {
        return false;
    }

    $segments = explode('/', $path);
    $first = $segments[0];

    // read/{slug}/chapter-{number}
    if ($first === 'read'
        && isset($segments[1], $segments[2])
        && preg_match('/^chapter-([0-9\-]+)$/', $segments[2], $m)
    ) {
        $_GET['slug'] = $segments[1];
        $_GET['chapter'] = $m[1];
        require APP_ROOT . '/controllers/mangaRead_Controller.php';
        return true;
    }

    // manga/{slug} (letter-first; numeric paths are image folders)
    if ($first === 'manga'
        && isset($segments[1])
        && preg_match('/^[a-zA-Z][a-zA-Z0-9\-]*$/', $segments[1])
    ) {
        $_GET['slug'] = $segments[1];
        require APP_ROOT . '/controllers/mangaInfo_Controller.php';
        return true;
    }

    // comments/{slug}/chapter-{number}
    if ($first === 'comments'
        && isset($segments[1], $segments[2])
        && preg_match('/^chapter-([0-9\-]+)$/', $segments[2], $m)
    ) {
        $_GET['slug'] = $segments[1];
        $_GET['chapter'] = $m[1];
        require APP_ROOT . '/controllers/comments_controller.php';
        return true;
    }

    // upload/{slug}
    if ($first === 'upload' && isset($segments[1]) && count($segments) === 2) {
        $_GET['slug'] = $segments[1];
        require APP_ROOT . '/controllers/upload_controller.php';
        return true;
    }

    // admin/edit-chapter/{slug}/chapter-{number}
    if ($first === 'admin' && ($segments[1] ?? '') === 'edit-chapter'
        && isset($segments[2], $segments[3])
        && preg_match('/^chapter-([0-9\-]+)$/', $segments[3], $m)
    ) {
        $_GET['slug'] = $segments[2];
        $_GET['chapter'] = $m[1];
        require APP_ROOT . '/controllers/editChapter_controller.php';
        return true;
    }

    // admin/edit-manga/{slug}
    if ($first === 'admin' && ($segments[1] ?? '') === 'edit-manga' && isset($segments[2])) {
        $_GET['slug'] = $segments[2];
        require APP_ROOT . '/controllers/edit_manga.php';
        return true;
    }

    // admin/delete-chapter/{slug}
    if ($first === 'admin' && ($segments[1] ?? '') === 'delete-chapter' && isset($segments[2])) {
        $_GET['slug'] = $segments[2];
        require APP_ROOT . '/controllers/delete_chapter_controller.php';
        return true;
    }

    // reset-password/{token} or activate/{token}
    if (in_array($first, ['reset-password', 'activate'], true) && isset($segments[1])) {
        $_GET['action'] = $first === 'reset-password' ? 'resetPassword' : 'activate';
        $_GET['token'] = $segments[1];
        require APP_ROOT . '/controllers/auth_controller.php';
        return true;
    }

    $static = [
        'about' => '/controllers/about_controller.php',
        'library' => '/controllers/library_controller.php',
        'reading-history' => '/controllers/readingHistory_controller.php',
        'search' => '/controllers/advanced_search_controller.php',
        'advanced-search' => '/controllers/advanced_search_controller.php',
        'recently-added' => '/controllers/recently_added_controller.php',
        'latest-updates' => '/controllers/latestUpdates_controller.php',
        'random' => '/controllers/random_manga_controller.php',
        'my-follows' => '/controllers/follows_controller.php',
        'admin/create-announcements' => '/controllers/announcement_controller.php',
        'admin/view-reports' => '/controllers/report_controller.php',
        'admin/add-manga' => '/controllers/create_controller.php',
        'admin/staff-pick' => '/controllers/staff_pick_controller.php',
    ];

    $authActions = [
        'profile' => 'profile',
        'user-profile' => 'user_profile',
        'login' => 'login',
        'register' => 'register',
        'logout' => 'logout',
        'forgot-password' => 'forgotPassword',
        'reset-password' => 'resetPassword',
        'activate' => 'activate',
    ];

    if (isset($authActions[$path])) {
        $_GET['action'] = $authActions[$path];
        require APP_ROOT . '/controllers/auth_controller.php';
        return true;
    }

    if (isset($static[$path])) {
        require APP_ROOT . $static[$path];
        return true;
    }

    return false;
}

function route_not_found(): void
{
    http_response_code(404);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><head><title>Not found</title></head><body>';
    echo '<h1>Page not found</h1><p><a href="/">Back to home</a></p></body></html>';
}
