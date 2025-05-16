<?php
// controller/staff_pick_controller.php - Controller for Staff Picks Admin Page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require_once '../db/account_db.php';
require_once '../db/staff_picks_model.php';
require_once '../db/mangaInfoPdo.php';

// Check if user is logged in
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $username = $_SESSION['username'] ?? null;

    // Only check role if userID is not null
    if ($userID !== null) {
        $role = get_role((string)$userID); // Convert to string to ensure type safety

        // If not admin, redirect to homepage
        if ($role !== 'admin') {
            header('Location: /');
            exit("You must be an admin to access this page");
        }
    } else {
        // UserID is still null, redirect
        header('Location: /');
        exit("Unable to verify admin status. Please log in again.");
    }
} else {
    // Not logged in, redirect to homepage
    header('Location: /');
    exit("You must be logged in as an admin to access this page");
}

// Create the staff_picks table if it doesn't exist
createStaffPicksTable();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add' && isset($_POST['mangaID'])) {
            $mangaID = (int)$_POST['mangaID'];
            $note = $_POST['note'] ?? '';

            try {
                if (addStaffPick($mangaID, $userID, $note)) {
                    $successMessage = "Manga added to Staff Picks successfully!";
                } else {
                    $errorMessage = "Failed to add manga to Staff Picks. It may already be in the list.";
                }
            } catch (PDOException $e) {
                $errorMessage = "Database error: " . $e->getMessage();
            }
        }
        elseif ($action === 'remove' && isset($_POST['mangaID'])) {
            $mangaID = (int)$_POST['mangaID'];

            try {
                if (removeStaffPick($mangaID)) {
                    $successMessage = "Manga removed from Staff Picks successfully!";
                } else {
                    $errorMessage = "Failed to remove manga from Staff Picks.";
                }
            } catch (PDOException $e) {
                $errorMessage = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Get all manga for the selection dropdown
$allManga = getAllManga();

// Get current staff picks
$staffPicks = getStaffPicks();

// Include the staff picks admin page
include "../PHP/staff_pick.php";
