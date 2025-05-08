<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MangaDax Home</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <?php /* Corrected CSS paths relative to index.php */ ?>
  <link rel="stylesheet" href="CSS/navbar.css">
  <link rel="stylesheet" href="CSS/home.css" />
  <?php if (isset($activeAnnouncement) && $activeAnnouncement): ?>
  <link rel="stylesheet" href="CSS/announcement.css" />
  <?php endif; ?>
  <style>
    .rating-badge {
      background-color: #ffb400;
      color: #000;
      padding: 3px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      margin-right: 10px;
    }
    .rating-badge i {
      margin-right: 4px;
    }
    .rating-count {
      font-size: 0.8rem;
      color: #ddd;
      margin-left: 5px;
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <?php include 'includes/sidebar.php'; ?>

  <?php if (isset($activeAnnouncement) && $activeAnnouncement && !empty($activeAnnouncement['content'])): ?>
  <!-- Announcement Overlay -->
  <div id="announcement-overlay" style="display: none;">
    <div class="container-xxl position-relative">
      <div class="announcement-content">
        <?= $activeAnnouncement['content'] ?>
      </div>
      <button type="button" id="announcement-close" aria-label="Close">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </div>
  <script src="JS/announcement.js"></script>
  <script src="JS/homepage-announcements.js"></script>
  <?php endif; ?>

  <!-- Thông báo xóa manga thành công -->
  <?php if (isset($_GET['status']) && $_GET['status'] === 'manga_deleted'): ?>
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div id="deleteToast" class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto"><i class="bi bi-check-circle-fill"></i> Thành công</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Manga đã được xóa thành công.
      </div>
    </div>
  </div>

  <script>
    // Tự động ẩn thông báo sau 5 giây
    setTimeout(function() {
      var toast = document.getElementById('deleteToast');
      var bsToast = new bootstrap.Toast(toast);
      bsToast.hide();
    }, 5000);
  </script>
  <?php endif; ?>

  <!-- INSERT BLOCK BEFORE main -->
  <!-- Popular New Titles Section - Moved OUTSIDE main container -->
  <section class="section-container popular-new-titles-section full-width-section">
    <!-- Background container for sliding backgrounds -->
    <div class="featured-backgrounds-container">
      <?php
      // Get the manga IDs in order
      $mangaIds = array_keys($allManga);

      // Create background slides for each manga
      foreach ($mangaIds as $index => $mangaId):
        $manga = $allManga[$mangaId];
        $isActive = ($index === 0) ? 'active' : '';
        $bgImage = isset($manga['CoverLink']) ?
          "url('IMG/{$mangaId}/" . htmlspecialchars($manga['CoverLink']) . "')" :
          "url('https://placehold.co/1200x450/555/ccc?text=Slide+" . ($index + 1) . "+BG')";
      ?>
      <!-- Background for Slide <?= $index + 1 ?> -->
      <div class="featured-background <?= $isActive ?>" data-slide="<?= $index ?>" style="background-image: <?= $bgImage ?>;"></div>
      <?php endforeach; ?>
    </div>
    <!-- Add inner container for content alignment -->
    <div class="container-xxl">
      <div class="section-heading">
        <h2 class="text-white fw-bold">Top Rated Manga</h2>
      </div>

      <!-- Featured Manga Carousel (Stays within the inner container) -->
      <div id="featuredMangaCarousel" class="carousel slide carousel-fade">
        <div class="carousel-inner">
          <?php
          // Get the manga IDs in order
          $mangaIds = array_keys($allManga);

          // Create carousel items for each manga
          foreach ($mangaIds as $index => $mangaId):
            $manga = $allManga[$mangaId];
            $isActive = ($index === 0) ? 'active' : '';

            // Get cover image
            $coverImage = isset($manga['CoverLink']) && !empty($manga['CoverLink'])
              ? "IMG/{$mangaId}/" . htmlspecialchars($manga['CoverLink'])
              : "https://placehold.co/250x350/1e1e1e/cccccc?text=Featured+" . ($index + 1);

            // Get manga title
            $mangaTitle = htmlspecialchars($manga['MangaNameOG'] ?? "Manga " . ($index + 1));

            // Get manga description
            $mangaDesc = $manga['MangaDiscription'] ?? "No description available.";
          ?>
          <!-- Slide <?= $index + 1 ?> -->
          <div class="carousel-item <?= $isActive ?>">
            <div class="featured-manga" data-bg-src="<?= $coverImage ?>" onclick="window.location='controller/mangaInfo_Controller.php?MangaID=<?= $mangaId ?>'">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <img src="<?= $coverImage ?>" alt="<?= $mangaTitle ?>" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title"><?= $mangaTitle ?></h3>

                  <?php if (isset($manga['AvgRating'])): ?>
                  <div class="rating mb-2">
                    <span class="rating-badge">
                      <i class="bi bi-star-fill"></i> <?= $manga['AvgRating'] ?>
                      <span class="rating-count">(<?= $manga['RatingCount'] ?> ratings)</span>
                    </span>
                  </div>
                  <?php endif; ?>

                  <div class="genres mb-3">
                    <?php if (isset($manga['tags'])): ?>
                      <?php foreach ($manga['tags'] as $tag): ?>
                        <span class="genre-tag"><?= strtoupper(htmlspecialchars($tag)) ?></span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="description-box mb-3">
                    <?= $mangaDesc ?>
                  </div>
                  <div class="featured-bottom-row">
                    <div class="author">
                      <?php
                      $authorNames = [];
                      if (isset($manga['authors'])) {
                          foreach ($manga['authors'] as $author) {
                              $authorNames[] = htmlspecialchars($author['AuthorName']);
                          }
                      }
                      echo implode(', ', $authorNames);
                      ?>
                    </div>
                    <div class="featured-right-controls">
                      <div class="ranking-indicator">NO. <?= $index + 1 ?></div>
                      <div class="featured-navigation-arrows">
                        <button class="carousel-control-prev featured-carousel-control" type="button" data-bs-target="#featuredMangaCarousel" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next featured-carousel-control" type="button" data-bs-target="#featuredMangaCarousel" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div> <!-- End inner container -->
  </section>

  <!-- Main content - Starts BELOW the featured section -->
  <main class="container-xxl">
    <!-- NEW Latest Updates Section -->
    <section class="section-container latest-updates-section">
      <div class="section-heading">
        <h2 class="text-white fw-bold">Latest Updates</h2>
        <a href="controller/latestUpdates_controller.php" class="see-all see-all-arrow">
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="latest-updates-grid">
        <!-- Column 1 (Visible by default) -->
        <div class="latest-updates-column">
          <?php // Display latest updated manga ?>
          <?php
          $count = 0;
          foreach ($latestUpdates as $index => $manga):
            if ($count >= 6) break; // Limit to 6 items in first column
            $count++;
          ?>
              <a href="controller/mangaRead_controller.php?chapterID=<?= $manga['Chapter']['ChapterID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['Chapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['Chapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['Chapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['Chapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['Chapter']['ScangroupName']) && !empty($manga['Chapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['Chapter']['ScangroupName']);
                    } else {
                        $authorNames = [];
                        $id = $manga['MangaID'];
                        if (isset($allManga[$id]['authors'])) {
                            foreach ($allManga[$id]['authors'] as $author) {
                                $authorNames[] = htmlspecialchars($author['AuthorName']);
                            }
                            echo implode(', ', $authorNames);
                        } else {
                            echo 'Unknown Author';
                        }
                    }
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i>
                    <?php
                    // Hiển thị số comment nếu có
                    if (isset($manga['Chapter']['NumOfComments'])) {
                        echo $manga['Chapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['Chapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['Chapter']['UploadTime']);
                        $currentTime = time();
                        $timeDiff = $currentTime - $uploadTime;

                        if ($timeDiff < 60) {
                            echo "just now";
                        } elseif ($timeDiff < 3600) {
                            $minutes = floor($timeDiff / 60);
                            echo $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
                        } elseif ($timeDiff < 86400) {
                            $hours = floor($timeDiff / 3600);
                            echo $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else {
                            $days = floor($timeDiff / 86400);
                            echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        }
                    } else {
                        echo rand(5, 60) . " minutes ago"; // Fallback
                    }
                    ?>
                  </span>
                </div>
              </a>
          <?php endforeach; ?>


          <?php // Không cần các mục hardcoded nữa vì đã có dữ liệu từ database ?>
        </div> <!-- End Column 1 -->

        <!-- Column 2 (Visible by default) -->
        <div class="latest-updates-column">
          <?php
          $count = 0;
          foreach ($latestUpdates as $index => $manga):
            if ($index < 6) continue; // Skip first 6 items (shown in first column)
            if ($count >= 6) break; // Limit to 6 items in second column
            $count++;
          ?>
              <a href="controller/mangaRead_controller.php?chapterID=<?= $manga['Chapter']['ChapterID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['Chapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['Chapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['Chapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['Chapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['Chapter']['ScangroupName']) && !empty($manga['Chapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['Chapter']['ScangroupName']);
                    } else {
                        $authorNames = [];
                        $id = $manga['MangaID'];
                        if (isset($allManga[$id]['authors'])) {
                            foreach ($allManga[$id]['authors'] as $author) {
                                $authorNames[] = htmlspecialchars($author['AuthorName']);
                            }
                            echo implode(', ', $authorNames);
                        } else {
                            echo 'Unknown Author';
                        }
                    }
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i>
                    <?php
                    // Hiển thị số comment nếu có
                    if (isset($manga['Chapter']['NumOfComments'])) {
                        echo $manga['Chapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['Chapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['Chapter']['UploadTime']);
                        $currentTime = time();
                        $timeDiff = $currentTime - $uploadTime;

                        if ($timeDiff < 60) {
                            echo "just now";
                        } elseif ($timeDiff < 3600) {
                            $minutes = floor($timeDiff / 60);
                            echo $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
                        } elseif ($timeDiff < 86400) {
                            $hours = floor($timeDiff / 3600);
                            echo $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else {
                            $days = floor($timeDiff / 86400);
                            echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        }
                    } else {
                        echo rand(5, 60) . " minutes ago"; // Fallback
                    }
                    ?>
                  </span>
                </div>
              </a>
          <?php endforeach; ?>
        </div> <!-- End Column 2 -->

        <!-- Column 3 -->
        <div class="latest-updates-column">
          <?php
          $count = 0;
          foreach ($latestUpdates as $index => $manga):
            if ($index < 12) continue; // Skip first 12 items (shown in first and second columns)
            if ($count >= 6) break; // Limit to 6 items in third column
            $count++;
          ?>
              <a href="controller/mangaRead_controller.php?chapterID=<?= $manga['Chapter']['ChapterID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['Chapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['Chapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['Chapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['Chapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['Chapter']['ScangroupName']) && !empty($manga['Chapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['Chapter']['ScangroupName']);
                    } else {
                        $authorNames = [];
                        $id = $manga['MangaID'];
                        if (isset($allManga[$id]['authors'])) {
                            foreach ($allManga[$id]['authors'] as $author) {
                                $authorNames[] = htmlspecialchars($author['AuthorName']);
                            }
                            echo implode(', ', $authorNames);
                        } else {
                            echo 'Unknown Author';
                        }
                    }
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i>
                    <?php
                    // Hiển thị số comment nếu có
                    if (isset($manga['Chapter']['NumOfComments'])) {
                        echo $manga['Chapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['Chapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['Chapter']['UploadTime']);
                        $currentTime = time();
                        $timeDiff = $currentTime - $uploadTime;

                        if ($timeDiff < 60) {
                            echo "just now";
                        } elseif ($timeDiff < 3600) {
                            $minutes = floor($timeDiff / 60);
                            echo $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
                        } elseif ($timeDiff < 86400) {
                            $hours = floor($timeDiff / 3600);
                            echo $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else {
                            $days = floor($timeDiff / 86400);
                            echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        }
                    } else {
                        echo rand(5, 60) . " minutes ago"; // Fallback
                    }
                    ?>
                  </span>
                </div>
              </a>
          <?php endforeach; ?>
        </div> <!-- End Column 3 -->

        <!-- Column 4 -->
        <div class="latest-updates-column">
          <?php
          $count = 0;
          foreach ($latestUpdates as $index => $manga):
            if ($index < 18) continue; // Skip first 18 items (shown in first, second, and third columns)
            if ($count >= 6) break; // Limit to 6 items in fourth column
            $count++;
          ?>
              <a href="controller/mangaRead_controller.php?chapterID=<?= $manga['Chapter']['ChapterID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['Chapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['Chapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['Chapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['Chapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['Chapter']['ScangroupName']) && !empty($manga['Chapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['Chapter']['ScangroupName']);
                    } else {
                        $authorNames = [];
                        $id = $manga['MangaID'];
                        if (isset($allManga[$id]['authors'])) {
                            foreach ($allManga[$id]['authors'] as $author) {
                                $authorNames[] = htmlspecialchars($author['AuthorName']);
                            }
                            echo implode(', ', $authorNames);
                        } else {
                            echo 'Unknown Author';
                        }
                    }
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i>
                    <?php
                    // Hiển thị số comment nếu có
                    if (isset($manga['Chapter']['NumOfComments'])) {
                        echo $manga['Chapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['Chapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['Chapter']['UploadTime']);
                        $currentTime = time();
                        $timeDiff = $currentTime - $uploadTime;

                        if ($timeDiff < 60) {
                            echo "just now";
                        } elseif ($timeDiff < 3600) {
                            $minutes = floor($timeDiff / 60);
                            echo $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
                        } elseif ($timeDiff < 86400) {
                            $hours = floor($timeDiff / 3600);
                            echo $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else {
                            $days = floor($timeDiff / 86400);
                            echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        }
                    } else {
                        echo rand(5, 60) . " minutes ago"; // Fallback
                    }
                    ?>
                  </span>
                </div>
              </a>
          <?php endforeach; ?>
        </div>  <!-- End Column 4 -->

      </div> <!-- End latest-updates-grid -->
    </section>

    <!-- Recently Added Section -->
    <section class="section-container staff-picks-section">
      <div class="section-heading">
        <a href="controller/recently_added_controller.php" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Recently Added</h2></a>
        <a href="controller/recently_added_controller.php" class="see-all see-all-arrow staff-picks-next"> <!-- Changed class for Swiper navigation -->
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <!-- Swiper Container -->
      <div class="swiper staff-picks-swiper">
        <div class="swiper-wrapper">
          <?php foreach ($recentlyAddedManga as $manga): ?>
          <!-- Manga Item -->
          <div class="swiper-slide item">
            <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>">
              <div class="image-container">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover">
                <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                <div class="overlay">
                  <div class="description-box">
                    <?= $manga['MangaDiscription'] ?? 'No description available.' ?>
                  </div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                      <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="item-title-link">
              <h3 class="item-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></h3>
            </a>
          </div>
          <?php endforeach; ?>
        </div> <!-- End swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination staff-picks-pagination"></div>

        <!-- Add Navigation Buttons (Hidden initially, controlled by Swiper) -->
        <!-- We'll use the existing arrow in the header as the 'next' button -->
        <!-- Add a 'prev' button if needed, or handle looping differently -->
        <!-- <div class="swiper-button-prev"></div> -->
        <!-- <div class="swiper-button-next"></div> -->

      </div> <!-- End swiper container -->
    </section>



    </section>
  </main>

  <!-- Bootstrap JS, Swiper JS, Custom JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <?php /* Corrected JS paths relative to index.php */ ?>
  <script src="JS/navbar.js"></script>
  <script src="JS/home.js"></script>
  <script src="JS/search.js"></script>
  <script>
    // Prevent click events from bubbling up from navigation controls
    document.addEventListener('DOMContentLoaded', function() {
      // Get all navigation controls in the featured carousel
      const navControls = document.querySelectorAll('.featured-bottom-row .featured-right-controls');

      // Add event listener to each control to stop propagation
      navControls.forEach(control => {
        control.addEventListener('click', function(e) {
          e.stopPropagation(); // Prevent the click from bubbling up to the parent
        });
      });

      // Initialize the carousel with custom options
      const featuredCarousel = new bootstrap.Carousel(document.getElementById('featuredMangaCarousel'), {
        interval: 5000, // Change slides every 5 seconds
        ride: 'carousel', // Auto-play the carousel
        wrap: true, // Loop through slides
        touch: true, // Enable touch swiping on mobile
        pause: 'hover' // Pause on hover
      });

      // Add smooth transition effect
      const carouselElement = document.getElementById('featuredMangaCarousel');
      carouselElement.addEventListener('slide.bs.carousel', function (e) {
        const activeItem = this.querySelector('.active');
        const nextItem = e.relatedTarget;
        const currentIndex = [...this.querySelectorAll('.carousel-item')].indexOf(activeItem);
        const nextIndex = [...this.querySelectorAll('.carousel-item')].indexOf(nextItem);
        const direction = e.direction; // 'left' for next, 'right' for prev

        // Remove any existing transition classes
        activeItem.classList.remove('sliding-out-left', 'sliding-out-right', 'sliding-in-left', 'sliding-in-right');
        nextItem.classList.remove('sliding-out-left', 'sliding-out-right', 'sliding-in-left', 'sliding-in-right');

        // Add custom transition classes based on direction
        if (direction === 'left') { // Next button - slide from right to left
          activeItem.classList.add('sliding-out-left');
          nextItem.classList.add('sliding-in-right');
        } else { // Prev button - slide from left to right
          activeItem.classList.add('sliding-out-right');
          nextItem.classList.add('sliding-in-left');
        }

        // Sync background with carousel
        const backgrounds = document.querySelectorAll('.featured-background');
        const currentBg = document.querySelector(`.featured-background[data-slide="${currentIndex}"]`);
        const nextBg = document.querySelector(`.featured-background[data-slide="${nextIndex}"]`);

        // Reset all backgrounds - remove all animation classes
        backgrounds.forEach(bg => {
          bg.classList.remove('active', 'slide-out-left', 'slide-out-right', 'slide-in-left', 'slide-in-right');
          // Also remove any inline styles that might interfere
          bg.style.transform = '';
          bg.style.opacity = '';
        });

        // Make sure current background is visible before starting animation
        currentBg.classList.add('active');

        // Set direction based on slide direction
        if (direction === 'left') { // Next button - slide from right to left
          // Start animations immediately to sync with carousel
          requestAnimationFrame(() => {
            // Start the animations
            currentBg.classList.remove('active');
            currentBg.classList.add('slide-out-left');
            nextBg.classList.add('slide-in-right');
          });
        } else { // Prev button - slide from left to right
          // Start animations immediately to sync with carousel
          requestAnimationFrame(() => {
            // Start the animations
            currentBg.classList.remove('active');
            currentBg.classList.add('slide-out-right');
            nextBg.classList.add('slide-in-left');
          });
        }

        // Remove classes after transition completes
        setTimeout(function() {
          // Clean up carousel item classes
          activeItem.classList.remove('sliding-out-left', 'sliding-out-right');
          nextItem.classList.remove('sliding-in-left', 'sliding-in-right');

          // Reset background classes and set active class
          backgrounds.forEach(bg => {
            // Remove all animation classes
            bg.classList.remove('slide-out-left', 'slide-out-right', 'slide-in-left', 'slide-in-right');
            // Remove active class from all backgrounds
            bg.classList.remove('active');
          });
          // Set active class only on the current visible background
          nextBg.classList.add('active');
        }, 600); // Match the transition duration in CSS
      });
    });
  </script>
</body>
</html>