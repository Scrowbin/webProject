<?php
    header('Content-Type: application/json');

    require("../db/report_model.php");
    require_once('../db/account_db.php');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userID = $_SESSION['userID'] ?? null;
    //check if admin
    $role = get_role($userID);
    if (!$userID||$role !== "admin"){
        exit("You must be logged in as an admin");
    }
    try {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new Exception("Invalid request method.");
        }
        $reportID = $_POST['reportID'] ?? null;
        $type = $_POST['type'] ?? null;
        if ($reportID === null) {
            echo json_encode(['success' => false, 'message' => 'Missing report ID']);
            exit;
        }
        if ($type === "manga"){
            resolveMangaReport($reportID);
            echo json_encode(['success' => true, 'message' => 'Resolved manga report']);
            exit;
        }

        if ($type === "chapter"){
            resolveChapterReport($reportID);
            echo json_encode(['success' => true, 'message' => 'Resolved chapter report']);
            exit;
        }
        else{
            echo json_encode(['success' => false, 'message' => 'IDK']);
            exit;
        }
    } catch (Exception $e) {
        http_response_code(400); // Bad request
        $response = [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }