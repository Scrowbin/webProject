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
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <?php include 'includes/sidebar.php'; ?>

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
                    <?= htmlspecialchars($allManga[1]['MangaDiscription']) ?>
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
                    <?= htmlspecialchars($allManga[2]['MangaDiscription']) ?>
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
                    <?= htmlspecialchars($allManga[3]['MangaDiscription']) ?>
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
                  <div class="latest-chapter"><img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP"> Latest Ch. ?</div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
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
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i> <?= rand(0, 10) ?></span>
                  <span class="latest-time"><?= rand(5, 60) ?> minutes ago</span>
                </div>
              </a>
          <?php endforeach; ?>


          <?php // --- Original Hardcoded Items (for example) --- ?>
          <!-- Item 1 -->
          <a href="#" class="latest-item">
             <?php /* Placeholders, paths would be IMG/ if exist */ ?>
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Sono Bisque Doll wa Koi o Suru</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/ru.svg" class="flag-icon" alt="RU"> Ch. 116 - Епилог</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Vendetta</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">2 minutes ago</span></div>
          </a>
          <!-- Item 2 -->
          <a href="#" class="latest-item">
             <?php /* Placeholders, paths would be IMG/ if exist */ ?>
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Hyakumanjou Labyrinth</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN"> Vol. 1 Ch. 11</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Dịch giả tập sự GTSCHUNDER</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">14 minutes ago</span></div>
          </a>
          <!-- Item 3 -->
          <a href="#" class="latest-item">
             <?php /* Placeholders, paths would be IMG/ if exist */ ?>
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Albus Changes the World</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN"> Vol. 2 Ch. 14 – Thợ rèn</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Mahiro solo dịch truyện</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">18 minutes ago</span></div>
          </a>
          <!-- Item 4 -->
          <!-- <a href="#" class="latest-item">
             <?php /* Placeholders, paths would be IMG/ if exist */ ?>
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">I Became the Genius Bastard of a Noble Dark Clan</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 4</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Reaper_Scans</div>
            </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">24 minutes ago</span></div>
          </a> -->
          <!-- Item 5 -->
           <!-- <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Cool na Megami-sama to Issho ni Sundara, Amayakashi Sug...</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 2 Ch. 5.1</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> O TRANSLATIONS</div>
          </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">25 minutes ago</span></div>
          </a> -->
          <!-- Item 6 -->
           <!-- <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Boss In My House</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 2</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Honey.BeexScans</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">35 minutes ago</span></div>
          </a> -->
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
                  <div class="latest-chapter"><img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP"> Latest Ch. ?</div>
                  <div class="latest-group"><i class="bi bi-people-fill"></i>
                    <?php
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
                    ?>
                  </div>
                </div>
                <div class="latest-meta">
                  <span class="latest-comments"><i class="bi bi-chat-square"></i> <?= rand(0, 10) ?></span>
                  <span class="latest-time"><?= rand(5, 60) ?> minutes ago</span>
                </div>
              </a>
          <?php endforeach; ?>
        </div> <!-- End Column 2 -->

        <!-- Column 3 (Hidden by default) -->
        <div class="latest-updates-column">
          <!-- Item 13 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=13" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">The Baby Fairy is a Villain</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 5</div><div class="latest-group"><i class="bi bi-people-fill"></i> RRScans</div></div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
          <!-- Item 14 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=14" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Wind Breaker</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN"> Vol. 22 Ch. 174 - Thăm tám</div><div class="latest-group"><i class="bi bi-people-fill"></i> WindBreaker_manga</div></div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
          <!-- Item 15 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=15" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Katekyo Hitman Reborn!</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 8 Ch. 69</div><div class="latest-group"><i class="bi bi-people-fill"></i> MTOZT</div></div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
          <!-- Item 16 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=16" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">The Ride-On King</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 79 - The President and the...</div><div class="latest-group"><i class="bi bi-people-fill"></i> Burning Love Scans</div></div>
            <div class="latest-meta"><span class="latest-comments">2 <i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
          <!-- Item 17 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=17" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">My First Friend Was A Zombie</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 1 Ch. 1</div><div class="latest-group"><i class="bi bi-people-fill"></i> RRScans</div></div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">1 hour ago</span></div>
          </a>
          <!-- Item 18 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=18" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Boku wa Isekai de Fuyo Mahou to Shouka...</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 5 Ch. 34</div><div class="latest-group"><i class="bi bi-people-fill"></i> Tenuous Scans</div></div>
            <div class="latest-meta"><span class="latest-comments">6 <i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
        </div> <!-- End Column 3 -->

        <!-- Column 4 (Hidden by default) -->
        <div class="latest-updates-column">
          <!-- Item 19 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=19" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">It's Over! Empress' Husband...</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 243 - Surname ZI,...</div><div class="latest-group"><i class="bi bi-people-fill"></i> ffftizzy</div></div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
          <!-- Item 20 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=20" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Kazure Doushin</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 1 Ch. 5 - Episode...</div><div class="latest-group"><i class="bi bi-people-fill"></i> Stiletto Heels</div></div>
            <div class="latest-meta"><span class="latest-comments">1 <i class="bi bi-chat-square"></i></span><span class="latest-time">3 hours ago</span></div>
          </a>
          <!-- Item 21 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=21" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Youheidan no Ryouriban</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 3 Ch. 71</div><div class="latest-group"><i class="bi bi-people-fill"></i> TripolarsNotBipol...</div></div>
            <div class="latest-meta"><span class="latest-comments">7 <i class="bi bi-chat-square"></i></span><span class="latest-time">3 hours ago</span></div>
          </a>
          <!-- Item 22 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=22" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Will You Clean This For Me?</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 6 Ch. 36 - This...</div><div class="latest-group"><i class="bi bi-people-fill"></i> Koin Randorii</div></div>
            <div class="latest-meta"><span class="latest-comments">4 <i class="bi bi-chat-square"></i></span><span class="latest-time">3 hours ago</span></div>
          </a>
          <!-- Item 23 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=23" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">Wakarase ♥ Dekamaid-ch...</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 3 Ch. 22.5</div><div class="latest-group"><i class="bi bi-people-fill"></i> beeg scans</div></div>
            <div class="latest-meta"><span class="latest-comments">4 <i class="bi bi-chat-square"></i></span><span class="latest-time">3 hours ago</span></div>
          </a>
          <!-- Item 24 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/45x63/1e1e1e/cccccc?text=24" alt="Cover" class="latest-cover">
            <div class="latest-details"><div class="latest-title">I Thought My Time Was Up!</div><div class="latest-chapter"><img src="https://mangadex.org/img/flags/pl.svg" class="flag-icon" alt="PL"> Vol. 2 Ch. 86</div><div class="latest-group"><i class="bi bi-people-fill"></i> Racuchy</div></div>
            <div class="latest-meta"><span class="latest-comments">3 <i class="bi bi-chat-square"></i></span><span class="latest-time">3 hours ago</span></div>
          </a>
        </div> <!-- End Column 4 -->

      </div> <!-- End latest-updates-grid -->
    </section>

    <!-- Staff Picks Section -->
    <section class="section-container staff-picks-section">
      <div class="section-heading">
        <a href="#" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Staff Picks</h2></a>
        <a href="#" class="see-all see-all-arrow staff-picks-next"> <!-- Changed class for Swiper navigation -->
          <i class="bi bi-arrow-right"></i>
        </a>
          </div>

      <!-- Swiper Container -->
      <div class="swiper staff-picks-swiper">
        <div class="swiper-wrapper">
          <!-- Staff Picks Manga Items - Now Swiper Slides -->
          <div class="swiper-slide item"> <!-- Changed class -->
          <?php if (isset($allManga[1]) && $allManga[1]): ?>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[1]['MangaID'] ?>">
            <div class="image-container">
              <img src="IMG/<?= $allManga[1]['MangaID'] ?>/<?= htmlspecialchars($allManga[1]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[1]['MangaNameOG']) ?> Cover">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
              <div class="overlay">
                 <div class="description-box">
                  <?= htmlspecialchars($allManga[1]['MangaDiscription']) ?>
                </div>
                <div class="overlay-actions">
                  <div class="overlay-buttons">
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[1]['MangaID'] ?>" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[1]['MangaID'] ?>" class="more-button"><i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[1]['MangaID'] ?>" class="item-title-link"><h3 class="item-title"><?= htmlspecialchars($allManga[1]['MangaNameOG']) ?></h3></a>
          <?php endif; ?>
          </div>

        <!-- Item 2 (Kaoru Hana wa Rin to Saku - MangaID 2) -->
            <div class="swiper-slide item"> <!-- Changed class -->
          <?php if (isset($allManga[2]) && $allManga[2]): ?>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[2]['MangaID'] ?>">
            <div class="image-container">
              <img src="IMG/<?= $allManga[2]['MangaID'] ?>/<?= htmlspecialchars($allManga[2]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[2]['MangaNameOG']) ?> Cover">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
              <div class="overlay">
                <div class="description-box">
                  <?= htmlspecialchars($allManga[2]['MangaDiscription']) ?>
                </div>
                <div class="overlay-actions">
                  <div class="overlay-buttons">
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[2]['MangaID'] ?>" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[2]['MangaID'] ?>" class="more-button"><i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[2]['MangaID'] ?>" class="item-title-link"><h3 class="item-title"><?= htmlspecialchars($allManga[2]['MangaNameOG']) ?></h3></a>
          <?php endif; ?>
          </div>
        <!-- Item 3 (Sousou no Frieren - MangaID 3) -->
          <div class="swiper-slide item"> <!-- Changed class -->
          <?php if (isset($allManga[3]) && $allManga[3]): ?>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[3]['MangaID'] ?>">
            <div class="image-container">
              <img src="IMG/<?= $allManga[3]['MangaID'] ?>/<?= htmlspecialchars($allManga[3]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[3]['MangaNameOG']) ?> Cover">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
              <div class="overlay">
                <div class="description-box">
                  <?= htmlspecialchars($allManga[3]['MangaDiscription']) ?>
                </div>
                <div class="overlay-actions">
                  <div class="overlay-buttons">
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[3]['MangaID'] ?>" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[3]['MangaID'] ?>" class="more-button"><i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[3]['MangaID'] ?>" class="item-title-link"><h3 class="item-title"><?= htmlspecialchars($allManga[3]['MangaNameOG']) ?></h3></a>
          <?php endif; ?>
          </div>
         <!-- Item 4 -->
          <div class="swiper-slide item"> <!-- Changed class -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+4" alt="Manga 4 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">
                    This is a placeholder description for Manga 4.
              </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
            </div>
                    <!-- Removed flag-overlay img -->
          </div>
              </div>
              </div>
          </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 4</h3></a>
              </div>
         <!-- Item 5 -->
          <div class="swiper-slide item"> <!-- Changed class -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+5" alt="Manga 5 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">
                    This is a placeholder description for Manga 5.
            </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
          </div>
                    <!-- Removed flag-overlay img -->
              </div>
              </div>
              </div>
          </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 5</h3></a>
            </div>
        <!-- Item 6 -->
          <div class="swiper-slide item"> <!-- Changed class -->
           <a href="#">
            <div class="image-container">
               <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+6" alt="Manga 6 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 6.
          </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
              </div>
                    <!-- Removed flag-overlay img -->
              </div>
              </div>
            </div>
           </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 6</h3></a>
      </div>
        <!-- Item 7 -->
          <div class="swiper-slide item"> <!-- Changed class -->
           <a href="#">
          <div class="image-container">
               <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+7" alt="Manga 7 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
            <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 7.
            </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
          </div>
                    <!-- Removed flag-overlay img -->
        </div>
               </div>
            </div>
           </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 7</h3></a>
        </div>
        <!-- Item 8 -->
        <div class="swiper-slide item"> <!-- Changed class -->
           <a href="#">
          <div class="image-container">
               <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+8" alt="Manga 8 Cover">
            <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
             <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 8.
            </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
          </div>
                    <!-- Removed flag-overlay img -->
        </div>
               </div>
            </div>
           </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 8</h3></a>
        </div>
        <!-- Item 9 -->
        <div class="swiper-slide item"> <!-- Changed class -->
           <a href="#">
          <div class="image-container">
               <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+9" alt="Manga 9 Cover">
            <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
            <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 9.
                 </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
              <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
              <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
            </div>
                    <!-- Removed flag-overlay img -->
          </div>
        </div>
            </div>
           </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 9</h3></a>
        </div>
        <!-- Item 10 -->
        <div class="swiper-slide item"> <!-- Changed class -->
           <a href="#">
          <div class="image-container">
               <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+10" alt="Manga 10 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
             <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 10.
            </div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                     <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
          </div>
                   <!-- Removed flag-overlay img -->
        </div>
            </div>
          </div>
           </a>
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 10</h3></a>
        </div>

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

    <!-- Self-Published Section -->
    <section class="section-container self-published-section">
      <div class="section-heading">
         <a href="#" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Self-Published</h2></a>
        <a href="#" class="see-all see-all-arrow self-published-next"> <!-- Swiper Nav -->
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="swiper self-published-swiper"> <!-- Swiper Container -->
        <div class="swiper-wrapper">
        <!-- Self-Published Manga Items -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+1" alt="Self-Published 1">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                <div class="overlay">
                   <div class="description-box"> <!-- Changed p to div.description-box -->
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 1</h3> <!-- Use h3 and class -->
          </a>
        </div>

          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+2" alt="Self-Published 2">
              <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="EN">
                <div class="overlay">
                   <div class="description-box"> <!-- Changed p to div.description-box -->
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 2</h3> <!-- Use h3 and class -->
          </a>
        </div>

          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+3" alt="Self-Published 3">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                <div class="overlay">
                   <div class="description-box"> <!-- Changed p to div.description-box -->
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 3</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+4" alt="Self-Published 4">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                <div class="overlay">
                   <div class="description-box"> <!-- Changed p to div.description-box -->
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 4</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+5" alt="Self-Published 5">
              <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="EN">
                 <div class="overlay">
                   <div class="description-box"> <!-- Changed p to div.description-box -->
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 5</h3> <!-- Use h3 and class -->
          </a>
        </div>

        <!-- Item 6 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+6" alt="Manga 6 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
               </div>
             </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 6</h3></a>
        </div>
        <!-- Item 7 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
             <a href="#">
              <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+7" alt="Manga 7 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
                </div>
              </div>
             </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 7</h3></a>
        </div>
        <!-- Item 8 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+8" alt="Manga 8 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
               </div>
             </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 8</h3></a>
        </div>
        <!-- Item 9 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+9" alt="Manga 9 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
             </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 9</h3></a>
        </div>
        <!-- Item 10 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
              <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+10" alt="Manga 10 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
                </div>
              </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 10</h3></a>
      </div>

        </div> <!-- End swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination self-published-pagination"></div> <!-- Swiper Pagination -->

      </div> <!-- End swiper container -->

      <!-- Removed old pagination dots -->
      <!-- <div class="pagination-dots" id="selfPublishedDots"> ... </div> -->
    </section>

    <!-- Featured and Seasonal Section -->
    <section class="section-container featured-items-section">
      <div class="section-heading">
         <a href="#" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Featured</h2></a>
        <a href="#" class="see-all see-all-arrow featured-items-next"> <!-- Swiper Nav -->
          <i class="bi bi-arrow-right"></i> Seasonal: Spring 2025
        </a>
      </div>

      <div class="swiper featured-items-swiper"> <!-- Swiper Container -->
        <div class="swiper-wrapper">
        <!-- Featured Manga Items -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+1" alt="Featured 1">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 1</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+2" alt="Featured 2">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 2</h3> <!-- Use h3 and class -->
          </a>
        </div>

          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+3" alt="Featured 3">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 3</h3> <!-- Use h3 and class -->
          </a>
        </div>

          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+4" alt="Featured 4">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 4</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+5" alt="Featured 5">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 5</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+6" alt="Featured 6">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Manga 6</h3> <!-- Use h3 and class -->
          </a>
        </div>

        <!-- Item 7 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
             <a href="#">
              <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+7" alt="Manga 7 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
                <div class="overlay">
                  <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
             </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 7</h3></a>
        </div>
        <!-- Item 8 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+8" alt="Manga 8 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
               </div>
             </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 8</h3></a>
        </div>
        <!-- Item 9 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+9" alt="Manga 9 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
             </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 9</h3></a>
        </div>
        <!-- Item 10 -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+10" alt="Manga 10 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                  <div class="overlay-actions">
                    <div class="overlay-buttons">
                      <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          <a href="#" class="item-title-link"><h3 class="item-title">Manga 10</h3></a>
      </div>

        </div> <!-- End swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination featured-items-pagination"></div> <!-- Swiper Pagination -->

      </div> <!-- End swiper container -->

      <!-- Removed old pagination dots -->
      <!-- <div class="pagination-dots" id="featuredDots"> ... </div> -->
    </section>

    <!-- Recently Added Section -->
    <section class="section-container recently-added-section">
      <div class="section-heading">
        <a href="#" class="text-white text-decoration-none"><h2 class="text-white fw-bold mb-0">Recently Added</h2></a>
        <a href="#" class="see-all see-all-arrow recently-added-next"> <!-- Swiper Nav -->
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="swiper recently-added-swiper"> <!-- Swiper Container -->
        <div class="swiper-wrapper">
        <!-- Recently Added Manga Items -->
        <?php foreach ([1, 2, 3] as $mangaID): ?>
          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <?php if (isset($allManga[$mangaID]) && $allManga[$mangaID]): ?>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[$mangaID]['MangaID'] ?>">
            <div class="image-container">
              <img src="IMG/<?= $allManga[$mangaID]['MangaID'] ?>/<?= htmlspecialchars($allManga[$mangaID]['CoverLink']) ?>" alt="<?= htmlspecialchars($allManga[$mangaID]['MangaNameOG']) ?> Cover">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
              <div class="overlay">
                <div class="description-box">
                  <?= htmlspecialchars(substr($allManga[$mangaID]['MangaDiscription'], 0, 200)) ?>...
                </div>
                <div class="overlay-actions">
                  <div class="overlay-buttons">
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[$mangaID]['MangaID'] ?>" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                    <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[$mangaID]['MangaID'] ?>" class="more-button"><i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <a href="controller/mangaInfo_Controller.php?MangaID=<?= $allManga[$mangaID]['MangaID'] ?>" class="item-title-link">
            <h3 class="item-title"><?= htmlspecialchars($allManga[$mangaID]['MangaNameOG']) ?></h3>
          </a>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1a1a1a/cccccc?text=Cover" alt="Recent 2">
              <img class="flag" src="https://mangadex.org/img/flags/kr.svg" alt="KR">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Martial Evolution: Start by...</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1a1a1a/cccccc?text=Cover" alt="Recent 3">
              <img class="flag" src="https://mangadex.org/img/flags/kr.svg" alt="KR">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Murim's Youngest Miracle Demon...</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1a1a1a/cccccc?text=Cover" alt="Recent 4">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Touhou - I Can't Do Anything</h3> <!-- Use h3 and class -->
          </a>
        </div>

           <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1a1a1a/cccccc?text=Cover" alt="Recent 5">
              <img class="flag" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                 <div class="overlay">
                   <div class="description-box">
                     Short manga description here
                   </div>
                   <div class="overlay-actions">
                     <div class="overlay-buttons">
                       <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a>
                       <a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
            </div>
          </a>
           <a href="#" class="item-title-link">
              <h3 class="item-title">Meito Ruten - Rakujo no Fu</h3> <!-- Use h3 and class -->
            </a>
          </div>

        <!-- Add more items here following the pattern -->
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+6" alt="Manga 6 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
          <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
               </div>
             </div>
            </a>
            <a href="#" class="item-title-link"><h3 class="item-title">Manga 6</h3></a>
          </div>
          <div class="swiper-slide item"> <!-- Swiper Slide -->
             <a href="#">
              <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+7" alt="Manga 7 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
                </div>
              </div>
             </a>
            <a href="#" class="item-title-link"><h3 class="item-title">Manga 7</h3></a>
          </div>
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+8" alt="Manga 8 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
              <div class="overlay">
                <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
              </div>
             </div>
            </a>
            <a href="#" class="item-title-link"><h3 class="item-title">Manga 8</h3></a>
          </div>
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
             <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+9" alt="Manga 9 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
               </div>
              </div>
            </a>
            <a href="#" class="item-title-link"><h3 class="item-title">Manga 9</h3></a>
          </div>
          <div class="swiper-slide item"> <!-- Swiper Slide -->
            <a href="#">
              <div class="image-container"><img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+10" alt="Manga 10 Cover"><img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
               <div class="overlay">
                 <div class="description-box">Generic description for the manga goes here, maybe a few lines long.</div>
                 <div class="overlay-actions">
                   <div class="overlay-buttons">
                     <a href="#" class="read-button"><i class="bi bi-book-fill"></i> Read</a><a href="#" class="more-button"><i class="bi bi-arrow-right"></i></a>
                   </div>
                 </div>
                </div>
              </div>
            </a>
            <a href="#" class="item-title-link"><h3 class="item-title">Manga 10</h3></a>
      </div>

        </div> <!-- End swiper-wrapper -->

        <!-- Add Pagination -->
        <div class="swiper-pagination recently-added-pagination"></div> <!-- Swiper Pagination -->

      </div> <!-- End swiper container -->

    </section>
  </main>

  <!-- Bootstrap JS, Swiper JS, Custom JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <?php /* Corrected JS paths relative to index.php */ ?>
  <script src="JS/navbar.js"></script>
  <script src="JS/home.js"></script>
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