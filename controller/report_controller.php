<?php
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

    
    include('../PHP/report_view.php');

    