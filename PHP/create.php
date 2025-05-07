<?php
  require('helper.php');
  $mode = $mode ?? "create"; // Default to create if $mode is not set
  $actionUrl = ($mode === "edit") ? "handle_edit.php" : "handle_create.php";
  $formTitle = ($mode === "edit") ? "Edit Manga" : "Upload New Manga";
  $submitButtonText = ($mode === "edit") ? "Update Manga" : "Upload Manga";
  if ($mode==="edit"){
    $mangaNameOG = $manga["MangaNameOG"];
    $mangaNameEN = $manga["MangaNameEN"];
    $image = $manga["CoverLink"];
    $pubStatus = $manga["PublicationStatus"];
    $mangaAuthors = combineAuthorsAndArtists($authorsRaw,$artistsRaw);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$mode==="create"? "Upload Manga":"Edit Manga"?> - MangaDax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="../CSS/navbar.css">
  <link rel="stylesheet" href="../CSS/create.css">
</head>
<body>
  <?php include 'includes/navbar_minimal.php'; ?>
  <?php include 'includes/sidebar.php'; ?>

  <div class="container-xxl mt-5 pt-4">
    <h2 class="mb-4" id="title"><?=$mode==="create"? "Upload New Manga":"Edit Manga"?></h2>
    <?php
      if ($mode==="edit"){
    ?>
    <a href="../controller/mangaInfo_Controller.php?MangaID=<?=$mangaID?>">
    <div class="d-flex align-items-center border rounded p-3 mb-4">
      <img src="../IMG/<?=$mangaID?>/<?=$image?>" alt="Manga Cover" class="me-3" style="width: 60px; height: 90px; object-fit: cover;">
      <div>
        <strong><?=$mangaNameOG?></strong><br>
        <?=$mangaAuthors?>
        <?php
              switch ($pubStatus) {
                  case "Ongoing":
                      echo "<span class=\"badge bg-success ms-2\"><strong>● PUBLICATION: ONGOING</strong></span>";
                      break;
                  case "Hiatus":
                      echo "<span class=\"badge bg-warning ms-2 \"><strong>● PUBLICATION: Hiatus</strong></span>";
                      break;
                  case "Completed":
                      echo "<span class=\"badge bg-primary ms-2\"><strong>● PUBLICATION: COMPLETED</strong></span>";
                      break;
                  default:
                      echo "";
                      break;
              }
        ?>
      </div>
  </div>
  <style>
  a{
    text-decoration: none;
    color: inherit;
  }
  </style>
  </a>
  <?php
  }
  ?>
  <form id="mangaUploadForm" enctype="multipart/form-data" class="row g-3">
  <!-- Manga Name -->
  <div class="col-md-6">
  <label class="form-label">Original Name</label>
  <input type="text" name="original_name" class="form-control" required>
  </div>
  <div class="col-md-6">
  <label class="form-label">English Name</label>
  <input type="text" name="english_name" class="form-control" required>
  </div>

  <!-- Cover Image -->
  <div class="col-md-6">
  <label class="form-label">Cover Image</label>

  <?php
  if($mode==="edit"){
  ?>
  <div class="mt-2">
  <input type="file" name="cover" class="form-control" accept="image/*">
  <img name="cover_preview" alt="Current Cover" style="max-width: 200px;">
  </div>
  <?php
  }
  else{
  ?>
  <input type="file" name="cover" class="form-control" accept="image/*" required>
  <?php
  }
  ?>
  </div>
  <!-- Original Language -->
  <div class="col-md-6">
  <label class="form-label">Original Language</label>
  <select name="language" class="form-control" required>
  <option value="">-- Select Language --</option>
  <option value="Japanese">Japanese</option>
  <option value="Korean">Korean</option>
  <option value="Chinese">Chinese</option>
  <option value="English">English</option>
  <option value="French">French</option>
  <option value="Spanish">Spanish</option>
  <option value="Vietnamese">Vietnamese</option>
  <option value="Other">Other</option>
  </select>

  </div>



  <!-- Authors & Artists -->
  <div class="col-md-6">
  <label class="form-label">Authors</label>
  <input type="text" name="authors" class="form-control" required>
  </div>
  <div class="col-md-6">
  <label class="form-label">Artists</label>
  <input type="text" name="artists" class="form-control" required>
  </div>

  <!-- Demographic & Content Rating -->
  <div class="col-md-3">
  <label class="form-label">Demographic</label>
  <select name="demographic" class="form-select" required>
  <option value="Shounen">Shounen</option>
  <option value="Shoujo">Shoujo</option>
  <option value="Seinen">Seinen</option>
  <option value="Josei">Josei</option>
  <option value="None">None</option>
  </select>
  </div>

  <div class="col-md-3">
  <label class="form-label">Content Rating</label>
  <select name="content_rating" class="form-select" required>
  <option value="Safe">Safe</option>
  <option value="Suggestive">Suggestive</option>
  <option value="Erotica">Erotica</option>
  </select>
  </div>

  <!-- Publication Info -->
  <div class="col-md-3">
  <label class="form-label">Publication Year</label>
  <input type="number" name="year" class="form-control" min="1900" max="<?= date('Y') ?>" required>
  </div>
  <div class="col-md-3">
  <label class="form-label">Publication Status</label>
  <select name="status" class="form-select" required>
  <option value="Ongoing">Ongoing</option>
  <option value="Completed">Completed</option>
  <option value="Hiatus">Hiatus</option>
  </select>
  </div>

  <!-- Description -->
  <div class="col-12 mb-3">
  <label class="form-label">Manga Description</label>
  <textarea class="form-control" name="description" id="description" rows="4" placeholder="Write the manga synopsis here (max 200 words)"></textarea>
  <small id="wordCount" class="form-text text-muted">0 / 200 words</small>
  </div>

  <!-- Tags -->
  <div class="col-12">
  <label class="form-label">Tags</label>
  <select name="tags[]" id="tagSelect" class="form-select" multiple required size="15">
  <optgroup label="Format">
  <option value="4-Koma">4-Koma</option>
  <option value="Adaptation">Adaptation</option>
  <option value="Anthology">Anthology</option>
  <option value="Award Winning">Award Winning</option>
  <option value="Doujinshi">Doujinshi</option>
  <option value="Fan Colored">Fan Colored</option>
  <option value="Full Color">Full Color</option>
  <option value="Long Strip">Long Strip</option>
  <option value="Official Colored">Official Colored</option>
  <option value="Oneshot">Oneshot</option>
  <option value="Self-Published">Self-Published</option>
  <option value="Web Comic">Web Comic</option>
  </optgroup>
  <optgroup label="Genre">
  <option value="Action">Action</option>
  <option value="Adventure">Adventure</option>
  <option value="Boys' Love">Boys' Love</option>
  <option value="Comedy">Comedy</option>
  <option value="Crime">Crime</option>
  <option value="Drama">Drama</option>
  <option value="Fantasy">Fantasy</option>
  <option value="Girls' Love">Girls' Love</option>
  <option value="Historical">Historical</option>
  <option value="Horror">Horror</option>
  <option value="Isekai">Isekai</option>
  <option value="Magical Girls">Magical Girls</option>
  <option value="Mecha">Mecha</option>
  <option value="Medical">Medical</option>
  <option value="Mystery">Mystery</option>
  <option value="Psychological">Psychological</option>
  <option value="Romance">Romance</option>
  <option value="Sci-Fi">Sci-Fi</option>
  <option value="Slice of Life">Slice of Life</option>
  <option value="Superhero">Superhero</option>
  <option value="Thriller">Thriller</option>
  <option value="Tragedy">Tragedy</option>
  <option value="Wuxia">Wuxia</option>
  <option value="Philosophical">Philosophical</option>
  <option value="Sports">Sports</option>
  </optgroup>
  <optgroup label="Theme">
  <option value="Aliens">Aliens</option>
  <option value="Animals">Animals</option>
  <option value="Cooking">Cooking</option>
  <option value="Demons">Demons</option>
  <option value="Genderswap">Genderswap</option>
  <option value="Crossdressing">Crossdressing</option>
  <option value="Delinquents">Delinquents</option>
  <option value="Ghosts">Ghosts</option>
  <option value="Gyaru">Gyaru</option>
  <option value="Harem">Harem</option>
  <option value="Incest">Incest</option>
  <option value="Loli">Loli</option>
  <option value="Mafia">Mafia</option>
  <option value="Magic">Magic</option>
  <option value="Martial Arts">Martial Arts</option>
  <option value="Military">Military</option>
  <option value="Monster Girls">Monster Girls</option>
  <option value="Monsters">Monsters</option>
  <option value="Music">Music</option>
  <option value="Ninja">Ninja</option>
  <option value="Office Workers">Office Workers</option>
  <option value="Police">Police</option>
  <option value="Post-Apocalyptic">Post-Apocalyptic</option>
  <option value="Reincarnation">Reincarnation</option>
  <option value="Reverse Harem">Reverse Harem</option>
  <option value="Samurai">Samurai</option>
  <option value="School Life">School Life</option>
  <option value="Shota">Shota</option>
  <option value="Supernatural">Supernatural</option>
  <option value="Survival">Survival</option>
  <option value="Time Travel">Time Travel</option>
  <option value="Traditional Games">Traditional Games</option>
  <option value="Vampires">Vampires</option>
  <option value="Video Games">Video Games</option>
  <option value="Villainess">Villainess</option>
  <option value="Virtual Reality">Virtual Reality</option>
  <option value="Zombies">Zombies</option>
  </optgroup>
  <optgroup label="Content">
  <option value="Gore">Gore</option>
  <option value="Sexual Violence">Sexual Violence</option>
  </optgroup>
  </select>
  <small class="text-muted">Hold Ctrl (or ⌘) to select multiple tags</small>

  <div class="mt-2" id="selectedTags"></div>
  </div>

  <!-- Submit Button -->
  <div class="col-12">
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitButtonText) ?></button>
  </div>
  </form>
  </div>

  <!--Toast để cho coi thành công hay không -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="uploadToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Upload Status</strong>
        <small>Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    <div class="toast-body" id="uploadToastBody"></div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Word Count
    const descInput = document.getElementById("description");
    const wordCountText = document.getElementById("wordCount");
    function updateWordCount() {
      const words = descInput.value.trim().split(/\s+/).filter(word => word.length > 0);
      wordCountText.textContent = `${words.length} / 200 words`;
      wordCountText.classList.toggle("text-danger", words.length > 200);
    }
    
    descInput.addEventListener("input", updateWordCount);

    // Tag Tracker
    const tagSelect = document.getElementById("tagSelect");
    const selectedTagsDisplay = document.getElementById("selectedTags");

    tagSelect.addEventListener("change", () => {
      selectedTagsDisplay.innerHTML = ""; // Clear
      Array.from(tagSelect.selectedOptions).forEach(option => {
        const badge = document.createElement("span");
        badge.className = "badge bg-secondary me-1 mb-1";
        badge.textContent = option.value;
        selectedTagsDisplay.appendChild(badge);
      });
    });

  document.getElementById('mangaUploadForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission
    const form = e.target;
    const formData = new FormData(form);

    // Add manga_id if in edit mode
    <?php if ($mode === "edit"): ?>
      formData.append('manga_id', <?= json_encode($mangaID) ?>);
    <?php endif; ?>

    const toastBody = document.getElementById('uploadToastBody');
    
    // Decide the action based on mode: create or edit
    const actionUrl = <?php echo json_encode($mode === 'create' ? '../controller/handle_create.php' : '../controller/handle_edit.php'); ?>;

    fetch(actionUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not OK");
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        
        toastBody.textContent = data.message;
        <?php if ($mode === "create"): ?>
        form.reset();
        document.getElementById("selectedTags").innerHTML = ""; // Reset selected tags display
        document.getElementById("wordCount").textContent = "0 / 200 words"; // Reset word count
        <?php endif; ?>
      } else {
        toastBody.textContent = `Error: ${data.error}`;
      }
      const toast = new bootstrap.Toast(document.getElementById('uploadToast'));
      toast.show();
    })
    .catch(error => {
      console.error("Error uploading manga:", error);
      toastBody.textContent = `Upload failed: ${error.message}`;
      const toast = new bootstrap.Toast(document.getElementById('uploadToast'));
      toast.show();
    });
  });
});


<?php if ($mode === "edit"): ?>
    // Preload manga data for editing
    
    document.addEventListener("DOMContentLoaded", () => {

    document.querySelector('img[name="cover_preview"]').src = <?= json_encode($coverLink) ?>;
    document.querySelector('input[name="original_name"]').value = <?= json_encode($manga['MangaNameOG']) ?>;
    document.querySelector('input[name="english_name"]').value = <?= json_encode($manga['MangaNameEN']) ?>;
    document.querySelector('select[name="language"]').value = <?= json_encode($manga['OriginalLanguage']) ?>;
    document.querySelector('input[name="authors"]').value = <?= json_encode($authorsRaw) ?>;
    document.querySelector('input[name="artists"]').value = <?= json_encode($artistsRaw) ?>;
    document.querySelector('select[name="demographic"]').value = <?= json_encode($manga['MagazineDemographic']) ?>;
    document.querySelector('select[name="content_rating"]').value = <?= json_encode($manga['ContentRating']) ?>;
    document.querySelector('input[name="year"]').value = <?= json_encode($manga['PublicationYear']) ?>;
    document.querySelector('select[name="status"]').value = <?= json_encode($manga['PublicationStatus']) ?>;
    document.querySelector('textarea[name="description"]').value = <?= json_encode($manga['MangaDiscription']) ?>;
    document.querySelector('textarea[name="description"]').dispatchEvent(new Event('input'));
    const descInput = document.getElementById("description");
    const wordCountText = document.getElementById("wordCount");
    function updateWordCount() {
      const words = descInput.value.trim().split(/\s+/).filter(word => word.length > 0);
      wordCountText.textContent = `${words.length} / 200 words`;
      wordCountText.classList.toggle("text-danger", words.length > 200);
    }
    updateWordCount();
    const selected = <?= json_encode($selectedTags) ?>;
    const tagSelect = document.getElementById("tagSelect");
    const selectedTagsDisplay = document.getElementById("selectedTags");

    for (const option of tagSelect.options) {
      if (selected.includes(option.value)) {
        option.selected = true;
        const badge = document.createElement("span");
        badge.className = "badge bg-secondary me-1 mb-1";
        badge.textContent = option.value;
        selectedTagsDisplay.appendChild(badge);
      }
    }
  });

<?php endif; ?>
</script>

  
</body>
</html>