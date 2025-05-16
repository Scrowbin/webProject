<?php
// PHP/staff_pick.php - Staff Picks Admin Page
$pageTitle = "Staff Picks Management";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - MangaDax</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/CSS/navbar.css">
    <link rel="stylesheet" href="/CSS/staff_pick.css">
</head>
<body>
    <?php include 'includes/navbar_minimal.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="container-xxl mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white"><?= $pageTitle ?></h1>
        </div>

        <?php if (isset($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $successMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $errorMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Add Manga to Staff Picks</h5>
                    </div>
                    <div class="card-body">
                        <form action="/admin/staff-pick" method="POST">
                            <input type="hidden" name="action" value="add">

                            <div class="mb-3">
                                <label for="mangaID" class="form-label">Select Manga</label>
                                <select name="mangaID" id="mangaID" class="form-select manga-select" required>
                                    <option value="">-- Select a manga --</option>
                                    <?php foreach ($allManga as $manga): ?>
                                        <?php if (!isStaffPick($manga['MangaID'])): ?>
                                        <option value="<?= $manga['MangaID'] ?>"><?= htmlspecialchars($manga['MangaNameOG']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">Staff Note (Optional)</label>
                                <textarea name="note" id="note" class="form-control manga-select" rows="3" placeholder="Why is this manga being featured?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add to Staff Picks</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        <h5 class="mb-0">Current Staff Picks</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($staffPicks)): ?>
                            <p class="text-center">No staff picks added yet. Use the form to add manga to staff picks.</p>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($staffPicks as $pick): ?>
                                <div class="col-md-6">
                                    <div class="staff-pick-card">
                                        <div class="d-flex">
                                            <img src="/IMG/<?= $pick['MangaID'] ?>/<?= htmlspecialchars($pick['CoverLink']) ?>" alt="<?= htmlspecialchars($pick['MangaNameOG']) ?>" class="staff-pick-img" style="width: 120px; height: auto; object-fit: cover;">
                                            <div class="staff-pick-body">
                                                <h5 class="staff-pick-title"><?= htmlspecialchars($pick['MangaNameOG']) ?></h5>
                                                <div class="staff-pick-meta">
                                                    Added by: <?= htmlspecialchars($pick['AdminName']) ?><br>
                                                    Date: <?= date('M j, Y', strtotime($pick['AddedDate'])) ?>
                                                </div>
                                                <form action="/admin/staff-pick" method="POST" onsubmit="return confirm('Are you sure you want to remove this manga from Staff Picks?');">
                                                    <input type="hidden" name="action" value="remove">
                                                    <input type="hidden" name="mangaID" value="<?= $pick['MangaID'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                    <a href="/manga/<?= $pick['Slug'] ?>" class="btn btn-sm btn-secondary" target="_blank">View</a>
                                                </form>
                                                <?php if (!empty($pick['Note'])): ?>
                                                <div class="staff-pick-note">
                                                    <small><?= htmlspecialchars($pick['Note']) ?></small>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/JS/navbar.js"></script>
</body>
</html>
