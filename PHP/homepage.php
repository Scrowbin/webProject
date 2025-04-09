<?php 
  // Ensure $featuredManga exists and is not empty before using it
  $hasFeaturedManga = isset($featuredManga) && !empty($featuredManga);
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
    <!-- Add inner container for content alignment -->
    <div class="container-xxl">
      <div class="section-heading">
        <h2 class="text-white fw-bold">Popular New Titles</h2>
      </div>

      <!-- Featured Manga Carousel (Stays within the inner container) -->
      <div id="featuredMangaCarousel" class="carousel slide">
        <div class="carousel-inner">
           <?php if ($hasFeaturedManga): 
                // Combine authors and artists for display
                $authorArtistList = array_merge($featuredManga['authors'] ?? [], $featuredManga['artists'] ?? []);
                $authorDisplay = !empty($authorArtistList) ? implode(', ', $authorArtistList) : 'N/A';
           ?>
            <!-- Featured Manga Slide (Zeikin de Katta Hon) -->
            <div class="carousel-item active"> <?php // Make this the first active item ?>
              <?php /* Link the whole slide content */ ?>
              <div class="featured-manga" data-bg-src="IMG/<?= htmlspecialchars($featuredManga['MangaID']) ?>/<?= htmlspecialchars($featuredManga['CoverLink']) ?>"> 
                  <div class="background-overlay"></div>
                  <div class="featured-manga-content row g-0">
                    <div class="col-md-3 featured-cover-col">
                      <a href="controller/mangaInfo_Controller.php?mangaID=<?= htmlspecialchars($featuredManga['MangaID']) ?>">
                        <img src="IMG/<?= htmlspecialchars($featuredManga['MangaID']) ?>/<?= htmlspecialchars($featuredManga['CoverLink']) ?>" alt="<?= htmlspecialchars($featuredManga['MangaNameOG']) ?> Cover" class="img-fluid rounded featured-cover">
                      </a>
                      <?php /* Display flag if available */
                         $langCode = strtolower(substr($featuredManga['OriginalLanguage'] ?? 'jp', 0, 2)); 
                         $flagSrc = "https://mangadex.org/img/flags/{$langCode}.svg";
                      ?>
                      <img class="flag flag-featured" src="<?= $flagSrc ?>" alt="<?= strtoupper($langCode) ?>">
                    </div>
                    <div class="col-md-9 featured-details d-flex flex-column"> <?php // Use flex column for alignment ?>
                      <div> <?php // Top content wrapper ?>
                        <h3 class="title"><a href="controller/mangaInfo_Controller.php?mangaID=<?= htmlspecialchars($featuredManga['MangaID']) ?>" class="text-white text-decoration-none"><?= htmlspecialchars($featuredManga['MangaNameOG']) ?></a></h3>
                        <div class="genres mb-3">
                          <?php if (!empty($featuredManga['tags'])): ?>
                              <?php foreach (array_slice($featuredManga['tags'], 0, 5) as $tag): // Limit tags shown ?>
                                  <span class="genre-tag"><?= strtoupper(htmlspecialchars($tag)) ?></span>
                              <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="description-box mb-3 flex-grow-1"> <?php // Allow description to grow ?>
                        <?= nl2br(htmlspecialchars(substr($featuredManga['MangaDiscription'] ?? 'No description available.', 0, 350))) ?>
                        <?= (strlen($featuredManga['MangaDiscription'] ?? '') > 350) ? '...' : '' ?> <?php // Add ellipsis if truncated ?>
                      </div>
                      <div class="featured-bottom-row mt-auto"> <?php // Push to bottom ?>
                        <div class="author"><?= htmlspecialchars($authorDisplay) ?></div>
                        <div class="featured-right-controls">
                          <?php /* <div class="ranking-indicator">NO. X</div> */ // Add ranking logic if needed ?>
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
          <?php endif; ?>

          <!-- Slide 1 (Original Item - Should not be active if featured manga exists) -->
          <div class="carousel-item <?php if (!$hasFeaturedManga) echo 'active'; ?>">
             <?php /* Corrected image path relative to index.php */ ?>
            <div class="featured-manga" data-bg-src="IMG/cover1.png">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <?php /* Corrected image path relative to index.php */ ?>
                  <img src="IMG/cover1.png" alt="Featured Manga Cover 1" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title">Shio no Kikan ~Moto Yuusha no Ore, Jibun ga Soshiki Shita Chuunibyou Himitsu Kessha o Tomeru Tame ni...</h3>
                  <div class="genres mb-3">
                    <span class="genre-tag">ACTION</span>
                    <span class="genre-tag">ADVENTURE</span>
                    <span class="genre-tag">COMEDY</span>
                    <span class="genre-tag">FANTASY</span>
                    <span class="genre-tag">ISEKAI</span>
                  </div>
                  <div class="description-box mb-3">
                    When he was in the third year of middle school, Hizaki Shiou was summoned to another world to save it. After defeating the Demon King, he was forcibly returned back to the present day. Yet another three years later, he is summoned to the other world once again, this time to stop the rampage of the secret society "Helheim."
                    That organization was supposedly actually the one that he had founded during his chuunibyou phase, where he called himself the "Corpse King"—a dark past too embarrassing to remember!
                    Someone seems to be impersonating the name of "Helheim" and tarnishing its reputation. To uncover the truth behind this mystery and clear the organization's name, the Corpse King reunites with his former subordinates—the "Undead Knights," who once made Helheim the strongest it had ever been.
                  </div>
                  <div class="featured-bottom-row">
                  <div class="author">Adashino Sotova, Sty</div>
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
          </div>

          <!-- Slide 2 (Update content/images) -->
          <div class="carousel-item">
             <?php /* Corrected image path relative to index.php */ ?>
            <div class="featured-manga" data-bg-src="IMG/cover2.jpg">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                  <?php /* Corrected image path relative to index.php */ ?>
                  <img src="IMG/cover2.jpg" alt="Akuyaku Reijou no Oyome-sama Cover" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg" alt="JP">
                </div>
                <div class="col-md-9 featured-details d-flex flex-column"> <!-- Make this a flex column -->
                  <div> <!-- Wrapper for top content -->
                    <h3 class="title">Akuyaku Reijou no Oyome-sama</h3>
                    <div class="genres mb-3">
                      <span class="genre-tag genre-suggestive">SUGGESTIVE</span> <!-- Added specific class for potential styling -->
                      <span class="genre-tag">DRAMA</span>
                      <span class="genre-tag">FANTASY</span>
                      <span class="genre-tag">GIRLS' LOVE</span>
                      <span class="genre-tag">ROMANCE</span>
                    </div>
                  </div>
                  <div class="description-box mb-3 flex-grow-1"> <!-- Allow description to grow -->
                    One day, Karina, a lady who has been groomed to be queen, suddenly has her engagement broken by her fiancé, the prince. Now he is sending Karina into exile while standing beside her sister, Aurora, instead. Exiled to the far north, where monsters are said to dwell, Karina ventures out to investigate the identity of a disturbing sound and has a fateful encounter in the snow...? A predatory love fantasy between a lady sworn to revenge and a strange girl seeking love.
                  </div>
                  <div class="featured-bottom-row mt-auto"> <!-- Use mt-auto as fallback, flex-grow above should push it -->
                    <div class="author">Kawano Akiko</div>
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
            </div>
          </div>

          <!-- Slide 3 (Update content/images) -->
          <div class="carousel-item">
            <?php /* Using placeholder, path would be IMG/ if it existed */ ?>
            <div class="featured-manga" data-bg-src="https://placehold.co/1200x450/444/ccc?text=Slide+3+BG">
              <div class="background-overlay"></div>
              <div class="featured-manga-content row g-0">
                <div class="col-md-3 featured-cover-col">
                   <?php /* Using placeholder, path would be IMG/ if it existed */ ?>
                  <img src="https://placehold.co/250x350/1e1e1e/cccccc?text=Featured+3" alt="Featured Manga Cover 3" class="img-fluid rounded featured-cover">
                  <img class="flag flag-featured" src="https://mangadex.org/img/flags/gb.svg" alt="GB">
                </div>
                <div class="col-md-9 featured-details">
                  <h3 class="title">Custom Title for Slide 3</h3>
                  <div class="genres mb-3">
                    <span class="genre-tag">COMEDY</span>
                    <span class="genre-tag">FANTASY</span>
                    <span class="genre-tag">ROMANCE</span>
                  </div>
                  <div class="description-box mb-3">
                    Here is the updated description for the third slide in the popular new titles carousel. Add relevant details here.
                  </div>
                  <div class="featured-bottom-row">
                  <div class="author">Author Name 3</div>
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
          </div>

          <!-- Slide 4 (Update content/images) -->
          <div class="carousel-item">
             <?php /* Using placeholder, path would be IMG/ if it existed */ ?>
            <div class="featured-manga" data-bg-src="https://placehold.co/1200x450/555/ccc?text=Slide+4+BG">
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
        <a href="#" class="see-all see-all-arrow">
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
      
      <div class="latest-updates-grid">
        <!-- Column 1 (Visible by default) -->
        <div class="latest-updates-column">
          <?php if ($hasFeaturedManga): ?>
          <!-- Featured Manga Item (Zeikin de Katta Hon) -->
          <a href="controller/mangaInfo_Controller.php?mangaID=<?= htmlspecialchars($featuredManga['MangaID']) ?>" class="latest-item">
             <img src="IMG/<?= htmlspecialchars($featuredManga['MangaID']) ?>/<?= htmlspecialchars($featuredManga['CoverLink']) ?>" alt="<?= htmlspecialchars($featuredManga['MangaNameOG']) ?> Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title"><?= htmlspecialchars($featuredManga['MangaNameOG']) ?></div>
              <?php /* Add chapter/group info if available/needed */ ?>
            </div>
            <?php /* Add meta info if available/needed */ ?>
          </a>
          <?php endif; ?>
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
          <a href="#" class="latest-item">
             <?php /* Placeholders, paths would be IMG/ if exist */ ?>
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">I Became the Genius Bastard of a Noble Dark Clan</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 4</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Reaper_Scans</div>
            </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">24 minutes ago</span></div>
          </a>
          <!-- Item 5 -->
           <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Cool na Megami-sama to Issho ni Sundara, Amayakashi Sug...</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 2 Ch. 5.1</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> O TRANSLATIONS</div>
          </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">25 minutes ago</span></div>
          </a>
          <!-- Item 6 -->
           <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Boss In My House</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 2</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Honey.BeexScans</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">35 minutes ago</span></div>
          </a>
        </div> <!-- End Column 1 -->

        <!-- Column 2 (Visible by default) -->
        <div class="latest-updates-column">
          <!-- Item 7 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Super Girl UFO</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 1 Ch. 3 - Goodbye, And Hello... <span class="badge bg-primary end-badge">END</span></div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> AndroidLB</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">41 minutes ago</span></div>
          </a>
          <!-- Item 8 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Dorei Shounin shika Sentakushi ga Nai desu yo? Harem? Nani...</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Vol. 8 Ch. 50</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> SilasMeanQuite</div>
              </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">49 minutes ago</span></div>
          </a>
          <!-- Item 9 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Yuurei to Tsukareta Kaishain</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 386 – Where She Wanted To Go</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Irrelevant Scans</div>
              </div>
            <div class="latest-meta"><span class="latest-comments">1 <i class="bi bi-chat-square"></i></span><span class="latest-time">58 minutes ago</span></div>
          </a>
          <!-- Item 10 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Digimon 04: Infinite Zone</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/pl.svg" class="flag-icon" alt="PL"> Vol. 1 Ch. 7 - Opowieść o 4 okrutnych Digimonach!</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> ARTURAP89</div>
            </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">1 hour ago</span></div>
          </a>
          <!-- Item 11 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Naniwa Tomoare</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN"> Vol. 6 Ch. 52 - Phẩm chất khỉ vui vẻ</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> To Another Reality</div>
          </div>
            <div class="latest-meta"><span class="latest-comments"><i class="bi bi-chat-square"></i></span><span class="latest-time">1 hour ago</span></div>
          </a>
          <!-- Item 12 -->
          <a href="#" class="latest-item">
            <img src="https://placehold.co/50x70/1a1a1a/cccccc?text=Cover" alt="Cover" class="latest-cover">
            <div class="latest-details">
              <div class="latest-title">Tensei Shite Inaka de Slow Life wo Okuritai</div>
              <div class="latest-chapter"><img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN"> Ch. 74</div>
              <div class="latest-group"><i class="bi bi-people-fill"></i> Nerissa's Barely Competent Jailbird Scans</div>
              </div>
            <div class="latest-meta"><span class="latest-comments">8 <i class="bi bi-chat-square"></i></span><span class="latest-time">2 hours ago</span></div>
          </a>
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
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+1" alt="Manga 1 Cover">
              <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB"> 
              <div class="overlay">
                 <div class="description-box">
                  Despite being from a prestigious noble family, Bridget, a failed daughter who made a contract with the weakest spirit, one day had her engagement broken off by the third prince, Joseph.

However, no one sympathized with her, who was acting as a proud daughter at the behest of Joseph... At that time, Bridget meets the Duke's son Yuri, who is feared by those around him because of his overwhelming ability and cold personality.

Two people who hate each other and repel each other. However, the encounter gradually changes their destinies. This is the story of a villainess who is despised for being incompetent and a villain who is shunned for being a genius who eventually fall in love.

Despite her noble status, Brigitte contracts with the weakest type of spirit—and on that very same day, the prince publicly breaks off their engagement. No one shows much sympathy towards the once haughty young lady—except for the duke's son, Yuri, who attends the same magic academy. Yuri is feared for his incredible abilities and icy personality, but with him on her side, her fortunes might have changed…
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
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 1</h3></a> 
          </div>

        <!-- Item 2 -->
            <div class="swiper-slide item"> <!-- Changed class -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+2" alt="Manga 2 Cover">
              <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB"> 
               <div class="overlay">
                 <div class="description-box">
                  Despite being from a prestigious noble family, Bridget, a failed daughter who made a contract with the weakest spirit, one day had her engagement broken off by the third prince, Joseph.

                  However, no one sympathized with her, who was acting as a proud daughter at the behest of Joseph... At that time, Bridget meets the Duke's son Yuri, who is feared by those around him because of his overwhelming ability and cold personality.
                  
                  Two people who hate each other and repel each other. However, the encounter gradually changes their destinies. This is the story of a villainess who is despised for being incompetent and a villain who is shunned for being a genius who eventually fall in love.
                  
                  Despite her noble status, Brigitte contracts with the weakest type of spirit—and on that very same day, the prince publicly breaks off their engagement. No one shows much sympathy towards the once haughty young lady—except for the duke's son, Yuri, who attends the same magic academy. Yuri is feared for his incredible abilities and icy personality, but with him on her side, her fortunes might have changed… 
                  Despite being from a prestigious noble family, Bridget, a failed daughter who made a contract with the weakest spirit, one day had her engagement broken off by the third prince, Joseph.

However, no one sympathized with her, who was acting as a proud daughter at the behest of Joseph... At that time, Bridget meets the Duke's son Yuri, who is feared by those around him because of his overwhelming ability and cold personality.

Two people who hate each other and repel each other. However, the encounter gradually changes their destinies. This is the story of a villainess who is despised for being incompetent and a villain who is shunned for being a genius who eventually fall in love.

Despite her noble status, Brigitte contracts with the weakest type of spirit—and on that very same day, the prince publicly breaks off their engagement. No one shows much sympathy towards the once haughty young lady—except for the duke's son, Yuri, who attends the same magic academy. Yuri is feared for his incredible abilities and icy personality, but with him on her side, her fortunes might have changed…
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
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 2</h3></a> 
              </div>
        <!-- Item 3 -->
          <div class="swiper-slide item"> <!-- Changed class -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1e1e1e/cccccc?text=Manga+3" alt="Manga 3 Cover">
               <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="GB"> 
               <div class="overlay">
                 <div class="description-box">
                   This is a placeholder description for Manga 3.
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
           <a href="#" class="item-title-link"><h3 class="item-title">Manga 3</h3></a> 
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
          <div class="swiper-slide item"> <!-- Swiper Slide -->
          <a href="#">
            <div class="image-container">
              <img src="https://placehold.co/150x210/1a1a1a/cccccc?text=Cover" alt="Recent 1">
              <img class="flag" src="https://mangadex.org/img/flags/gb.svg" alt="EN">
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
              <h3 class="item-title">April Fool's Collection 2025</h3> <!-- Use h3 and class -->
          </a>
        </div>

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
</body>
</html>