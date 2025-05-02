<?php
// edit_manga.php
require '../db/edit_model.php'; // Your database connection
$mode = "edit";
$id = $_GET['MangaID'] ?? null;
if (!$id) {
    echo "No manga ID provided.";
    exit;
}


$manga = getMangaInfo($id);
if (!$manga) {
    echo "Manga not found.";
    exit;
}

$authorsRaw = getMangaAuthors($id);
$artistsRaw = getMangaArtists($id);
$coverLink = "../IMG/" . $id . "/" . $manga["CoverLink"];

$selectedTags = getTags($id);
include("../PHP/create.php")
?>
<script>
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
</script>
<script>
  // When editing, we'll preload selected tags
  window.addEventListener("DOMContentLoaded", () => {
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
</script>

<script>
document.getElementById('mangaUploadForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('id', <?= json_encode($id) ?>);

  const toastBody = document.getElementById('uploadToastBody');
  fetch('handle_edit.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      toastBody.textContent = data.success ? data.message : `Error: ${data.error}`;
      const toast = new bootstrap.Toast(document.getElementById('uploadToast'));
      toast.show();
  })
  .catch(error => {
      toastBody.textContent = `Update failed: ${error.message}`;
      const toast = new bootstrap.Toast(document.getElementById('uploadToast'));
      toast.show();
  });
});
</script>


