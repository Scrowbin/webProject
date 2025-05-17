<?php
    require 'helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Search - Mangadax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="<?= $pathPrefix ?>CSS/navbar.css">
    <link rel="stylesheet" href="<?= $pathPrefix ?>CSS/library.css">
    <link rel="stylesheet" href="<?= $pathPrefix ?>CSS/advanced_search.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container-xxl pt-5 mt-4">
        <div class="library-header">
            <div class="back-button">
                <a href="javascript:history.back()">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <h1>Advanced Search</h1>
        </div>

        <!-- Search Form -->
        <div class="search-container mb-4">
            <form id="advanced-search-form" action="../advanced-search" method="GET">
                <div class="search-bar-container">
                    <div class="search-input-wrapper">
                        <input type="text" name="query" id="search-input" placeholder="Search" value="<?= htmlspecialchars($searchQuery) ?>">
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <button type="button" id="toggle-filters-btn" class="btn <?= !empty($_GET) && count($_GET) > 1 ? 'btn-danger' : 'btn-primary' ?>">
                        <?= !empty($_GET) && count($_GET) > 1 ? 'Hide filters' : 'Show filters' ?>
                    </button>
                </div>

                <div id="advanced-filters" class="<?= !empty($_GET) && count($_GET) > 1 ? '' : 'd-none' ?>">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="sort">Sort by</label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="none" <?= $sortBy == 'none' ? 'selected' : '' ?>>None</option>
                                <option value="best_match" <?= $sortBy == 'best_match' ? 'selected' : '' ?>>Best Match</option>
                                <option value="latest_update" <?= $sortBy == 'latest_update' ? 'selected' : '' ?>>Latest Update</option>
                                <option value="oldest_update" <?= $sortBy == 'oldest_update' ? 'selected' : '' ?>>Oldest Update</option>
                                <option value="title_asc" <?= $sortBy == 'title_asc' ? 'selected' : '' ?>>Title (A-Z)</option>
                                <option value="title_desc" <?= $sortBy == 'title_desc' ? 'selected' : '' ?>>Title (Z-A)</option>
                                <option value="highest_rating" <?= $sortBy == 'highest_rating' ? 'selected' : '' ?>>Highest Rating</option>
                                <option value="lowest_rating" <?= $sortBy == 'lowest_rating' ? 'selected' : '' ?>>Lowest Rating</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="filter_tags">Filter tags</label>
                            <div class="filter-tags-container" id="filter-tags-container">
                                <div class="selected-tags">
                                    <?php if (!empty($includeTags)): ?>
                                        <?php foreach ($includeTags as $tag): ?>
                                            <span class="tag-badge include-tag"><?= strtoupper($tag) ?> <i class="bi bi-plus-circle-fill"></i></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($excludeTags)): ?>
                                        <?php foreach ($excludeTags as $tag): ?>
                                            <span class="tag-badge exclude-tag"><?= strtoupper($tag) ?> <i class="bi bi-dash-circle-fill"></i></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" name="include_tags" id="include_tags" value="<?= htmlspecialchars(implode(',', $includeTags)) ?>">
                                <input type="hidden" name="exclude_tags" id="exclude_tags" value="<?= htmlspecialchars(implode(',', $excludeTags)) ?>">
                                <button type="button" class="btn btn-outline-secondary" id="open-tag-modal">Select Tags</button>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="content_rating">Content Rating</label>
                            <select name="content_rating" id="content_rating" class="form-select">
                                <option value="any" <?= $contentRating == 'any' ? 'selected' : '' ?>>Any</option>
                                <option value="Safe" <?= $contentRating == 'Safe' ? 'selected' : '' ?>>Safe</option>
                                <option value="Suggestive" <?= $contentRating == 'Suggestive' ? 'selected' : '' ?>>Suggestive</option>
                                <option value="Erotica" <?= $contentRating == 'Erotica' ? 'selected' : '' ?>>Erotica</option>
                                <option value="Suggestive/Erotica" <?= $contentRating == 'Suggestive/Erotica' ? 'selected' : '' ?>>Suggestive/Erotica</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="demographic">Magazine Demographic</label>
                            <select name="demographic" id="demographic" class="form-select">
                                <option value="any" <?= $demographic == 'any' ? 'selected' : '' ?>>Any</option>
                                <option value="Shounen" <?= $demographic == 'Shounen' ? 'selected' : '' ?>>Shounen</option>
                                <option value="Shoujo" <?= $demographic == 'Shoujo' ? 'selected' : '' ?>>Shoujo</option>
                                <option value="Seinen" <?= $demographic == 'Seinen' ? 'selected' : '' ?>>Seinen</option>
                                <option value="Josei" <?= $demographic == 'Josei' ? 'selected' : '' ?>>Josei</option>
                                <option value="None" <?= $demographic == 'None' ? 'selected' : '' ?>>None</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="author">Authors</label>
                            <select name="author" id="author" class="form-select">
                                <option value="any" <?= $authorID == 'any' ? 'selected' : '' ?>>Any</option>
                                <?php foreach ($allAuthors as $author): ?>
                                    <option value="<?= $author['AuthorID'] ?>" <?= $authorID == $author['AuthorID'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($author['AuthorName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="artist">Artists</label>
                            <select name="artist" id="artist" class="form-select">
                                <option value="any" <?= $artistID == 'any' ? 'selected' : '' ?>>Any</option>
                                <?php foreach ($allArtists as $artist): ?>
                                    <option value="<?= $artist['ArtistID'] ?>" <?= $artistID == $artist['ArtistID'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($artist['ArtistName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="language">Original languages</label>
                            <select name="language" id="language" class="form-select">
                                <option value="any" <?= $originalLanguage == 'any' ? 'selected' : '' ?>>All languages</option>
                                <option value="Japanese" <?= $originalLanguage == 'Japanese' ? 'selected' : '' ?>>Japanese</option>
                                <option value="English" <?= $originalLanguage == 'English' ? 'selected' : '' ?>>English</option>
                                <option value="Chinese" <?= $originalLanguage == 'Chinese' ? 'selected' : '' ?>>Chinese</option>
                                <option value="Korean" <?= $originalLanguage == 'Korean' ? 'selected' : '' ?>>Korean</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="publication_year">Publication year</label>
                            <div class="d-flex">
                                <input type="number" name="year" id="publication_year" class="form-control" placeholder="Year" min="1900" max="<?= date('Y') ?>" value="<?= $publicationYear ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="status">Publication Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="any" <?= $publicationStatus == 'any' ? 'selected' : '' ?>>Any</option>
                                <option value="Ongoing" <?= $publicationStatus == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                <option value="Completed" <?= $publicationStatus == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Hiatus" <?= $publicationStatus == 'Hiatus' ? 'selected' : '' ?>>Hiatus</option>
                                <option value="Cancelled" <?= $publicationStatus == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="has_translated_chapters">Has translated chapters</label>
                            <select name="has_translated_chapters" id="has_translated_chapters" class="form-select">
                                <option value="any">Any language</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                            <button type="button" id="reset-filters" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Library Controls -->
        <div class="library-controls">
            <div class="manga-count"><?= $totalMangaCount ?> Titles</div>
            <div class="view-controls">
                <button class="view-btn list-view active"><i class="bi bi-list"></i></button>
                <button class="view-btn grid-view"><i class="bi bi-grid-3x3-gap"></i></button>
                <button class="view-btn compact-view"><i class="bi bi-grid-3x3"></i></button>
            </div>
        </div>

        <!-- Manga Results -->
        <div class="manga-container">
            <?php if (empty($manga)): ?>
                <div class="no-results">
                    <p>No manga found matching your search criteria.</p>

                    <!-- Debug information -->
                    <?php if (isset($_GET['debug']) && $_GET['debug'] == 1): ?>
                    <div class="debug-info mt-4 p-3 border rounded bg-light">
                        <h5>Debug Information</h5>
                        <p><strong>Search Query:</strong> <?= htmlspecialchars($searchQuery) ?></p>
                        <p><strong>Sort By:</strong> <?= htmlspecialchars($sortBy) ?></p>
                        <p><strong>Content Rating:</strong> <?= htmlspecialchars($contentRating) ?></p>
                        <p><strong>Demographic:</strong> <?= htmlspecialchars($demographic) ?></p>
                        <p><strong>Original Language:</strong> <?= htmlspecialchars($originalLanguage) ?></p>
                        <p><strong>Publication Status:</strong> <?= htmlspecialchars($publicationStatus) ?></p>
                        <p><strong>Publication Year:</strong> <?= htmlspecialchars($publicationYear) ?></p>
                        <p><strong>Include Tags:</strong> <?= htmlspecialchars(implode(', ', $includeTags)) ?></p>
                        <p><strong>Exclude Tags:</strong> <?= htmlspecialchars(implode(', ', $excludeTags)) ?></p>
                        <p><strong>Author ID:</strong> <?= htmlspecialchars($authorID) ?></p>
                        <p><strong>Artist ID:</strong> <?= htmlspecialchars($artistID) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach($manga as $m):
                    $mangaID = $m["MangaID"];
                    $mangaName = $m["MangaNameOG"];
                    $CoverLink = $m["CoverLink"];
                    $pubStatus = $m["PublicationStatus"];
                    $mangaDesc = $m["MangaDiscription"];
                    $mangaLanguage = $m["OriginalLanguage"];
                    $mangaSlug = $m["Slug"];
                ?>
                    <div class="manga-card">
                        <div class="manga-cover">
                            <a href="<?= $pathPrefix ?>manga/<?=$mangaSlug?>">
                                <img src="<?= $pathPrefix ?>IMG/<?=$mangaID?>/<?=$CoverLink?>" alt="Manga Cover">
                            </a>
                        </div>

                        <!-- Right: Details -->
                        <div class="manga-details">
                            <div class="manga-title-row">
                                <div class="flag-title">
                                    <?php echo getFlag($mangaLanguage);?>
                                    <a href="<?= $pathPrefix ?>manga/<?=$mangaSlug?>" class="manga-title-link"><strong><?=$mangaName?></strong></a>
                                </div>
                                <div class="manga-status">
                                    <?php
                                        switch ($pubStatus) {
                                            case "Ongoing":
                                                echo "<span class='status-badge status-ongoing'>● " . strtoupper($pubStatus) . "</span>";
                                                break;
                                            case "Completed":
                                                echo "<span class='status-badge status-completed'>● " . strtoupper($pubStatus) . "</span>";
                                                break;
                                            case "Hiatus":
                                                echo "<span class='status-badge status-hiatus'>● " . strtoupper($pubStatus) . "</span>";
                                                break;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="manga-stats-bar">
                                <?php if (isset($m['CommentSectionID']) && $m['CommentSectionID']): ?>
                                    <a href="<?= $pathPrefix ?>comments/<?= $mangaSlug ?>/chapter-1" class="stat-item-link">
                                        <span class="stat-item"><i class="bi bi-chat-fill"></i> <?= $m['CommentCount'] ?? 0 ?></span>
                                    </a>
                                <?php else: ?>
                                    <span class="stat-item"><i class="bi bi-chat-fill"></i> <?= $m['CommentCount'] ?? 0 ?></span>
                                <?php endif; ?>
                                <span class="stat-item"><i class="bi bi-bookmark-fill"></i> <?= $m['FollowCount'] ?? 0 ?></span>
                                <span class="stat-item"><i class="bi bi-star-fill"></i> <?= number_format($m['AvgRating'] ?? 0, 1) ?></span>
                            </div>
                            <div class="tag-container">
                                <?php
                                    $tags = $m['tags'];
                                    $displayTags = array_slice($tags, 0, 5);
                                    $remainingTags = count($tags) - count($displayTags);

                                    foreach($displayTags as $tag){
                                        echo "<span class='tag-badge'>".strtoupper($tag)."</span>";
                                    }

                                    if($remainingTags > 0) {
                                        echo "<span class='more-tags-btn'>MORE</span>";
                                        echo "<div class='hidden-tags'>";
                                        for($i = 5; $i < count($tags); $i++) {
                                            echo "<span class='tag-badge'>".strtoupper($tags[$i])."</span>";
                                        }
                                        echo "</div>";
                                    }
                                ?>
                            </div>
                            <div class="manga-description">
                                <?=$mangaDesc?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php renderPagination($currentPage, $totalPages); ?>
        </div>
    </div>

    <!-- Tag Selection Modal -->
    <div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tagModalLabel">Filter tags</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tag-search-container mb-3">
                        <input type="text" id="tag-search" class="form-control" placeholder="Search tags">
                        <button id="tag-reset" class="btn btn-secondary">Reset</button>
                    </div>
                    <div class="tag-instructions mb-3">
                        <p>Click on any tag once to include it. Click on it again to exclude it. Click once more to clear it.</p>
                        <button id="tag-dismiss" class="btn btn-link">Dismiss</button>
                    </div>

                    <!-- Format Tags -->
                    <div class="tag-group">
                        <h6>Format</h6>
                        <div class="tag-list">
                            <?php foreach ($tagsByGroup['Format'] as $tag): ?>
                                <span class="tag-badge tag-selectable" data-tag="<?= $tag['TagName'] ?>"><?= strtoupper($tag['TagName']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Genre Tags -->
                    <div class="tag-group">
                        <h6>Genre</h6>
                        <div class="tag-list">
                            <?php foreach ($tagsByGroup['Genre'] as $tag): ?>
                                <span class="tag-badge tag-selectable" data-tag="<?= $tag['TagName'] ?>"><?= strtoupper($tag['TagName']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Theme Tags -->
                    <div class="tag-group">
                        <h6>Theme</h6>
                        <div class="tag-list">
                            <?php foreach ($tagsByGroup['Theme'] as $tag): ?>
                                <span class="tag-badge tag-selectable" data-tag="<?= $tag['TagName'] ?>"><?= strtoupper($tag['TagName']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Content Tags -->
                    <div class="tag-group">
                        <h6>Content</h6>
                        <div class="tag-list">
                            <?php foreach ($tagsByGroup['Content'] as $tag): ?>
                                <span class="tag-badge tag-selectable" data-tag="<?= $tag['TagName'] ?>"><?= strtoupper($tag['TagName']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="apply-tags">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $pathPrefix ?>JS/navbar.js"></script>
    <script src="<?= $pathPrefix ?>JS/search.js"></script>
    <script src="<?= $pathPrefix ?>JS/library.js"></script>
    <script src="<?= $pathPrefix ?>JS/advanced_search.js"></script>
</body>
</html>
