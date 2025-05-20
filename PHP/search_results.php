<?php
// search_results.php - Display search results
// Expects $results array from search_controller.php
// Expects $query string from search_controller.php
// Expects $pathPrefix for relative paths
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Results - MangaDax</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="<?= $pathPrefix ?>CSS/navbar.css">
  <link rel="stylesheet" href="<?= $pathPrefix ?>CSS/search.css">
</head>
<body>
  <?php include $pathPrefix . 'PHP/includes/navbar.php'; ?>
  <?php include $pathPrefix . 'PHP/includes/sidebar.php'; ?>

  <main class="container-xxl mt-5 pt-4">
    <div class="search-header">
      <h1 class="search-title">Search Results for "<?= htmlspecialchars($query) ?>"</h1>
      <div class="search-stats">
        Found <?= count($results) ?> results
      </div>
    </div>

    <div class="search-filters mb-4">
      <div class="filter-group">
        <label>Status:</label>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-filter active">All</button>
          <button type="button" class="btn btn-filter">Ongoing</button>
          <button type="button" class="btn btn-filter">Completed</button>
        </div>
      </div>
      <div class="filter-group">
        <label>Sort by:</label>
        <select class="form-select">
          <option selected>Relevance</option>
          <option>Title (A-Z)</option>
          <option>Rating (High-Low)</option>
          <option>Latest Update</option>
        </select>
      </div>
    </div>

    <div class="search-results-container">
      <?php if (empty($results)): ?>
        <div class="no-results">
          <i class="bi bi-search"></i>
          <h3>No results found</h3>
          <p>Try different keywords or check your spelling</p>
        </div>
      <?php else: ?>
        <?php foreach ($results as $manga): ?>
          <div class="search-result-card">
            <div class="result-cover">
              <a href="<?= $pathPrefix ?>controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>">
                <img src="<?= $pathPrefix ?>IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?>">
              </a>
            </div>
            <div class="result-details">
              <h3 class="result-title">
                <a href="<?= $pathPrefix ?>controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>">
                  <?= htmlspecialchars($manga['MangaNameOG']) ?>
                </a>
              </h3>
              <h4 class="result-subtitle">
                <?= htmlspecialchars($manga['MangaNameEN']) ?>
              </h4>
              <div class="result-meta">
                <span class="result-status <?= strtolower(getSimplifiedStatus($manga['PublicationStatus'])) ?>">
                  <?= getSimplifiedStatus($manga['PublicationStatus']) ?>
                </span>
                <span class="result-year"><?= $manga['PublicationYear'] ?></span>
                <span class="result-rating">
                  <i class="bi bi-star-fill"></i>
                  <?= $manga['AvgRating'] ? number_format($manga['AvgRating'], 2) : 'N/A' ?>
                </span>
                <span class="result-follows">
                  <i class="bi bi-bookmark-fill"></i>
                  <?= $manga['BookmarkCount'] ?? '0' ?>
                </span>
              </div>
              <div class="result-description">
                <?= substr($manga['MangaDiscription'], 0, 200) ?>...
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <!-- Bootstrap JS, Custom JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $pathPrefix ?>JS/navbar.js"></script>
  <script src="<?= $pathPrefix ?>JS/sidebar.js"></script>
  <script src="<?= $pathPrefix ?>JS/search.js"></script>
</body>
</html>
