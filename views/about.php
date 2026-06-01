<?php
$hide_auth_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About <?= htmlspecialchars(site_title()) ?> — a non-commercial student web development project for reading and cataloguing manga.">
    <title>About — <?= htmlspecialchars(site_title()) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/site-identity.css">
</head>
<body class="bg-dark text-light">
    <?php include __DIR__ . '/includes/site_identity_bar.php'; ?>

    <main class="about-page">
        <h1>About this project</h1>
        <p class="lead"><?= htmlspecialchars(site_subtitle()) ?></p>

        <section>
            <h2>What this site is</h2>
            <p>
                <?= htmlspecialchars(site_title()) ?> is a manga reading and catalog website built as coursework
                to practice PHP, MySQL, HTML, CSS, JavaScript, and server deployment. Visitors can browse titles,
                read chapters, and optionally create an account to use a personal library and reading history.
            </p>
        </section>

        <section>
            <h2>What this site is not</h2>
            <ul>
                <li>Not a commercial service and not affiliated with any existing manga platform or publisher.</li>
                <li>Not collecting credentials for third-party services — accounts exist only on this site.</li>
                <li>Not intended to impersonate another brand; <?= htmlspecialchars(site_name()) ?> is this project’s own name only.</li>
            </ul>
        </section>

        <section>
            <h2>Accounts</h2>
            <p>
                Registration is optional. Signing in unlocks features such as bookmarks, ratings, and comments.
                You can use the full catalog without an account where the site allows guest access.
            </p>
        </section>

        <section>
            <h2>Contact &amp; hosting</h2>
            <p>
                This site runs on shared student hosting for demonstration purposes.
                Project maintainer: <?= htmlspecialchars(site_author()) ?>.
            </p>
        </section>

        <p>
            <a href="<?= htmlspecialchars(app_url('/')) ?>" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to home catalog
            </a>
        </p>
    </main>

    <?php include __DIR__ . '/includes/site_footer_disclaimer.php'; ?>
</body>
</html>
