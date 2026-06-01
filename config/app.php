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
