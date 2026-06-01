<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

if (!defined('MANGA_PATH')) {
    define('MANGA_PATH', APP_ROOT . DIRECTORY_SEPARATOR . 'manga');
}

if (!defined('UPLOADS_PATH')) {
    define('UPLOADS_PATH', APP_ROOT . DIRECTORY_SEPARATOR . 'uploads');
}

/** Web path prefix for manga cover/chapter images (physical folder: manga/) */
if (!defined('MANGA_URL')) {
    define('MANGA_URL', '/manga');
}
