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
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <?php include 'includes/sidebar.php'; ?>

  <!-- Announcement Overlay -->
  <div id="announcement-overlay" style="display: none;">
    <div class="container-xxl position-relative">
      <div class="announcement-content">
        <?php if (isset($activeAnnouncement) && $activeAnnouncement): ?>
        <?= $activeAnnouncement['content'] ?>
        <?php endif; ?>
      </div>
      <button type="button" id="announcement-close" aria-label="Close">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </div>
  <script src="JS/announcement.js"></script>
  <script src="JS/homepage-announcements.js"></script>

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
      <!-- Background for Slide 1 -->
      <div class="featured-background active" data-slide="0" style="background-image: url('IMG/<?= $allManga[1]['MangaID'] ?>/<?= htmlspecialchars($allManga[1]['CoverLink']) ?>');"></div>
      <!-- Background for Slide 2 -->
      <div class="featured-background" data-slide="1" style="background-image: url('IMG/<?= $allManga[2]['MangaID'] ?>/<?= htmlspecialchars($allManga[2]['CoverLink']) ?>');"></div>
      <!-- Background for Slide 3 -->
      <div class="featured-background" data-slide="2" style="background-image: url('IMG/<?= $allManga[3]['MangaID'] ?>/<?= htmlspecialchars($allManga[3]['CoverLink']) ?>');"></div>
      <!-- Background for Slide 4 -->
      <div class="featured-background" data-slide="3" style="background-image: url('https://placehold.co/1200x450/555/ccc?text=Slide+4+BG');"></div>
    </div>
    <!-- Add inner container for content alignment -->
    <div class="container-xxl">
      <div class="section-heading">
        <h2 class="text-white fw-bold">Popular New Titles</h2>
      </div>

      <!-- Featured Manga Carousel (Stays within the inner container) -->
      <div id="featuredMangaCarousel" class="carousel slide carousel-fade">
        <div class="carousel-inner">
          <!-- Slide 1 (Zeikin de Katta Hon - MangaID 1) -->
          <div class="carousel-item active">
            <?php if (isset($allManga[1]) && $allManga[1]): ?>
            <div class="featured-manga" data-bg-src="IMG/<?= $allManga[1]['MangaID'] ?>/<?= htmlspecialchars($allManga[1]['CoverLink']) ?>" onclick="window.location='controller/mangaInfo_Controller.php?MangaID=<?= $allManga[1]['MangaID'] ?>'">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <img src="IMG/<?= $allManga[1]['MangaID'] ?>/<?= htmlspecialchars($allManga[1]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[1]['MangaNameOG']) ?>" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title"><?= htmlspecialchars($allManga[1]['MangaNameOG']) ?></h3>
                  <div class="genres mb-3">
                    <?php if (isset($allManga[1]['tags'])): ?>
                      <?php foreach ($allManga[1]['tags'] as $tag): ?>
                        <span class="genre-tag"><?= strtoupper(htmlspecialchars($tag)) ?></span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="description-box mb-3">
                    <?= $allManga[1]['MangaDiscription'] ?>
                  </div>
                  <div class="featured-bottom-row">
                    <div class="author">
                      <?php
                      $authorNames = [];
                      if (isset($allManga[1]['authors'])) {
                          foreach ($allManga[1]['authors'] as $author) {
                              $authorNames[] = htmlspecialchars($author['AuthorName']);
                          }
                      }
                      echo implode(', ', $authorNames);
                      ?>
                    </div>
                    <div class="featured-right-controls">
                      <div class="ranking-indicator">NO. 1</div>
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
            <?php endif; ?>
          </div>

          <!-- Slide 2 (Kaoru Hana wa Rin to Saku - MangaID 2) -->
          <div class="carousel-item">
            <?php if (isset($allManga[2]) && $allManga[2]): ?>
            <div class="featured-manga" data-bg-src="IMG/<?= $allManga[2]['MangaID'] ?>/<?= htmlspecialchars($allManga[2]['CoverLink']) ?>" onclick="window.location='controller/mangaInfo_Controller.php?MangaID=<?= $allManga[2]['MangaID'] ?>'">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <img src="IMG/<?= $allManga[2]['MangaID'] ?>/<?= htmlspecialchars($allManga[2]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[2]['MangaNameOG']) ?>" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title"><?= htmlspecialchars($allManga[2]['MangaNameOG']) ?></h3>
                  <div class="genres mb-3">
                    <?php if (isset($allManga[2]['tags'])): ?>
                      <?php foreach ($allManga[2]['tags'] as $tag): ?>
                        <span class="genre-tag"><?= strtoupper(htmlspecialchars($tag)) ?></span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="description-box mb-3">
                    <?= $allManga[2]['MangaDiscription'] ?>
                  </div>
                  <div class="featured-bottom-row">
                    <div class="author">
                      <?php
                      $authorNames = [];
                      if (isset($allManga[2]['authors'])) {
                          foreach ($allManga[2]['authors'] as $author) {
                              $authorNames[] = htmlspecialchars($author['AuthorName']);
                          }
                      }
                      echo implode(', ', $authorNames);
                      ?>
                    </div>
                    <div class="featured-right-controls">
                      <div class="ranking-indicator">NO. 2</div>
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
            <?php endif; ?>
          </div>
          <!-- Slide 3 (Sousou no Frieren - MangaID 3) -->
          <div class="carousel-item">
            <?php if (isset($allManga[3]) && $allManga[3]): ?>
            <div class="featured-manga" data-bg-src="IMG/<?= $allManga[3]['MangaID'] ?>/<?= htmlspecialchars($allManga[3]['CoverLink']) ?>" onclick="window.location='controller/mangaInfo_Controller.php?MangaID=<?= $allManga[3]['MangaID'] ?>'">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <img src="IMG/<?= $allManga[3]['MangaID'] ?>/<?= htmlspecialchars($allManga[3]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[3]['MangaNameOG']) ?>" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title"><?= htmlspecialchars($allManga[3]['MangaNameOG']) ?></h3>
                  <div class="genres mb-3">
                    <?php if (isset($allManga[3]['tags'])): ?>
                      <?php foreach ($allManga[3]['tags'] as $tag): ?>
                        <span class="genre-tag"><?= strtoupper(htmlspecialchars($tag)) ?></span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="description-box mb-3">
                    <?= $allManga[3]['MangaDiscription'] ?>
                  </div>
                  <div class="featured-bottom-row">
                    <div class="author">
                      <?php
                      $authorNames = [];
                      if (isset($allManga[3]['authors'])) {
                          foreach ($allManga[3]['authors'] as $author) {
                              $authorNames[] = htmlspecialchars($author['AuthorName']);
                          }
                      }
                      echo implode(', ', $authorNames);
                      ?>
                    </div>
                    <div class="featured-right-controls">
                      <div class="ranking-indicator">NO. 3</div>
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
            <?php endif; ?>
          </div>

          <!-- Slide 4 (Update content/images) -->
          <div class="carousel-item">
             <?php /* Using placeholder, path would be IMG/ if it existed */ ?>
            <div class="featured-manga" data-bg-src="https://placehold.co/1200x450/555/ccc?text=Slide+4+BG" onclick="window.location='controller/mangaInfo_Controller.php?MangaID=4'">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                   <?php /* Using placeholder, path would be IMG/ if it existed */ ?>
                  <img src="https://placehold.co/250x350/1e1e1e/cccccc?text=Featured+4" alt="Featured Manga Cover 4" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title">Custom Title for Slide 4</h3>
                  <div class="genres mb-3">
                    <span class="genre-tag">COMEDY</span>
                    <span class="genre-tag">DRAMA</span>
                    <span class="genre-tag">ROMANCE</span>
                  </div>
                  <div class="description-box mb-3">
                    Description for slide four goes here. Adjust content as needed for demonstration purposes.
                  </div>
                  <div class="featured-bottom-row">
                    <div class="author">Another Author</div>
                    <div class="featured-right-controls">
                      <div class="ranking-indicator">NO. 4</div>
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
          <!-- Add more slides as needed -->
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
              <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['LatestChapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['LatestChapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['LatestChapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['LatestChapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['LatestChapter']['ScangroupName']) && !empty($manga['LatestChapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['LatestChapter']['ScangroupName']);
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
                    if (isset($manga['LatestChapter']['NumOfComments'])) {
                        echo $manga['LatestChapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['LatestChapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['LatestChapter']['UploadTime']);
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
              <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="latest-item">
                <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover" class="latest-cover">
                <div class="latest-details">
                  <div class="latest-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></div>
                  <div class="latest-chapter">
                    <img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">
                    <?php if (isset($manga['LatestChapter'])): ?>
                      Ch. <?= htmlspecialchars($manga['LatestChapter']['ChapterNumber']) ?>
                      <?php if (!empty($manga['LatestChapter']['ChapterName'])): ?>
                        - <?= htmlspecialchars($manga['LatestChapter']['ChapterName']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      Latest Ch. ?
                    <?php endif; ?>
                  </div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
                    if (isset($manga['LatestChapter']['ScangroupName']) && !empty($manga['LatestChapter']['ScangroupName'])) {
                        echo htmlspecialchars($manga['LatestChapter']['ScangroupName']);
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
                    if (isset($manga['LatestChapter']['NumOfComments'])) {
                        echo $manga['LatestChapter']['NumOfComments'];
                    } else {
                        echo rand(0, 10); // Fallback
                    }
                    ?>
                  </span>
                  <span class="latest-time">
                    <?php
                    // Hiển thị thời gian upload
                    if (isset($manga['LatestChapter']['UploadTime'])) {
                        $uploadTime = strtotime($manga['LatestChapter']['UploadTime']);
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

        <!-- Column 3 (Hidden by default) -->
        <div class="latest-updates-column">
          <?php
          // Có thể thêm code để hiển thị thêm manga nếu cần
          // Ví dụ: lấy thêm 6 manga tiếp theo từ $latestUpdates
          ?>
        </div> <!-- End Column 3 -->

        <!-- Column 4 (Hidden by default) -->
        <div class="latest-updates-column">
          <?php
          // Có thể thêm code để hiển thị thêm manga nếu cần
          // Ví dụ: lấy thêm 6 manga tiếp theo từ $latestUpdates
          ?>
        </div> <!-- End Column 4 -->

      </div> <!-- End latest-updates-grid -->
    </section>

    <!-- Recently Added Section -->
    <section class="section-container staff-picks-section">
      <div class="section-heading">
        <a href="#" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Recently Added</h2></a>
        <a href="#" class="see-all see-all-arrow staff-picks-next"> <!-- Changed class for Swiper navigation -->
          <i class="bi bi-arrow-right"></i>
        </a>
          </div>

      <!-- Swiper Container -->
      <div class="swiper staff-picks-swiper">
        <div class="swiper-wrapper">
          <!-- Recently Added Manga Items -->
          <?php foreach ($recentlyAddedManga as $manga): ?>
          <div class="swiper-slide item">
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>">
            <div class="image-container">
              <img src="IMG/<?= $manga['MangaID'] ?>/<?= htmlspecialchars($manga['CoverLink']) ?>" alt="<?= htmlspecialchars($manga['MangaNameOG']) ?> Cover">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
              <div class="overlay">
                 <div class="description-box">
                  <?= $manga['MangaDiscription'] ?>
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
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $manga['MangaID'] ?>" class="item-title-link"><h3 class="item-title"><?= htmlspecialchars($manga['MangaNameOG']) ?></h3></a>
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