<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Manga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Upload New Manga</h2>

  <form action="handle_upload.php" method="POST" enctype="multipart/form-data" class="row g-3">
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
      <input type="file" name="cover" class="form-control" accept="image/*" required>
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
    <div class="col-md-6">
      <label class="form-label">Demographic</label>
      <select name="demographic" class="form-select" required>
        <option value="Shounen">Shounen</option>
        <option value="Shoujo">Shoujo</option>
        <option value="Seinen">Seinen</option>
        <option value="Josei">Josei</option>
        <option value="None">None</option>
      </select>
    </div>

    <div class="col-md-6">
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
      <select name="tags[]" id="tagSelect" class="form-select" multiple required>
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
          <option value="Horror Isekai">Horror Isekai</option>
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
      <button type="submit" class="btn btn-primary">Upload Manga</button>
    </div>
  </form>
</div>

<!-- Scripts -->
<script>
  // Word Count
  const descInput = document.getElementById("description");
  const wordCountText = document.getElementById("wordCount");

  descInput.addEventListener("input", () => {
    const words = descInput.value.trim().split(/\s+/).filter(word => word.length > 0);
    wordCountText.textContent = `${words.length} / 200 words`;
    wordCountText.classList.toggle("text-danger", words.length > 200);
  });

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
</script>
</body>
</html>
