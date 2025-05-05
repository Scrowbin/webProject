<?php
    require('helper.php');
    $authors = implode(', ', array_column($authorsRaw, 'AuthorName'));
    $artists = implode(', ', array_column($artistsRaw, 'ArtistName'));
    $mangaAuthors = $authors . ($authors && $artists ? ' | ' : '') . $artists;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Chapter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .upload-box {
      border: 2px dashed #ccc;
      border-radius: 6px;
      padding: 40px;
      text-align: center;
      cursor: pointer;
      transition: border-color 0.3s;
    }
    .upload-box:hover {
      border-color: #ff5722;
    }
  </style>
</head>
<body class="bg-light py-5">

<div class="container bg-white p-4 rounded shadow-sm">
  <h3 class="mb-3">Upload Chapter</h3>
  <div class="alert alert-warning text-center">
    Make sure to read the guidelines!
  </div>

  <!-- Manga Details (static preview) -->
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
  <form action="../controller/uploadChapter.php" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
      <div class="col-md-2">
        <input type="text" name="volume" class="form-control" placeholder="Volume">
      </div>
      <div class="col-md-2">
        <input type="text" name="chapter-number" class="form-control" placeholder="Chapter">
      </div>
      <div class="col-md-4">
        <input type="text" name="scangroup-name" class="form-control" placeholder="Scangroup Name if none leave empty or type 'none'">
      </div>
      <div class="col-md-4">
        <select name="language" class="form-select" required>
          <option value="">Scanlation Language *</option>
          <option value="en">English</option>
          <option value="jp">Japanese</option>
          <option value="fr">Vietnamese</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <input type="text" name="chapter-name" class="form-control" placeholder="Chapter Name">
    </div>

    <!-- Upload area -->
    <div class="mb-4">
      <label class="form-label">Pages</label>
      <div class="upload-box" onclick="document.getElementById('fileInput').click()">
      <input type="text" id="mangaID" name="MangaID" value="<?=$mangaID?>" hidden>

        <p><strong>+</strong><br>Click or drag pages here</p>
        <input type="file" id="fileInput" name="pages[]" multiple accept="image/*" hidden>
      </div>
    </div>

    <!-- filelist -->
    <div id="fileList" class="mt-2 text-muted small"></div>

    <!-- Buttons -->
    <div class="d-flex justify-content-between">
      <button type="submit" name="upload_another" class="btn btn-outline-primary">Upload and add another chapter</button>
      <button type="submit" class="btn btn-primary">Upload</button>
    </div>
  </form>
</div>

<script>
  const fileInput = document.getElementById('fileInput');
  const box = document.querySelector('.upload-box p');
  fileInput.addEventListener('change', function () {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = ''; // Clear previous

    if (this.files.length > 0) {
      const ul = document.createElement('ul');
      ul.style.listStyle = 'none';
      ul.style.paddingLeft = '0';

      Array.from(this.files).forEach((file, i) => {
        const li = document.createElement('li');
        li.textContent = `${i + 1}. ${file.name}`;
        ul.appendChild(li);
      });

      fileList.appendChild(ul);
    } else {
      fileList.textContent = 'No files selected.';
    }
    
  });
  window.addEventListener('DOMContentLoaded', () => {
  const toastEl = document.getElementById('uploadToast');
  if (toastEl) {
    const toast = new bootstrap.Toast(toastEl, {
      delay: 5000 // 5 seconds
    });
    toast.show();
  }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_GET['status'])): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="uploadToast" class="toast align-items-center text-white <?= $_GET['status'] === 'success' ? 'bg-success' : 'bg-danger' ?>" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <?= $_GET['status'] === 'success' ? 'Chapter uploaded successfully!' : 'Upload failed.' ?>
        <?php if (!empty($_GET['msg'])): ?>
          <br><small><?= htmlspecialchars($_GET['msg']) ?></small>
        <?php endif; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>
</body>
</html>
