<?php

require_once __DIR__ . '/../config/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/search_model.php';

// Check if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Get the search query
$query = $_GET['query'] ?? '';

// If empty query and not AJAX, redirect to homepage
if (empty($query) && !$isAjax) {
    header('Location: ../index.php';
    exit;
}

// Perform the search
$results = [];
if (!empty($query)) {
    $results = searchManga($query);
}

// If this is an AJAX request, return JSON
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}

// Otherwise, include the search results page
$pathPrefix = '../'; // Define path prefix for includes relative to controller directory
include __DIR__ . '/../views/search_results.php';
?>
