<?php

require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/router.php';

$path = app_request_path();

if (route_dispatch($path)) {
    exit;
}

if ($path !== '') {
    route_not_found();
    exit;
}

require __DIR__ . '/controllers/homepage_controller.php';
