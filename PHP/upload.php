<?php
    require('helper.php');
    $mangaAuthors = combineAuthorsAndArtists($authorsRaw,$artistsRaw);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?=$mode==="upload" ? "Upload" : "Edit"?> Chapter - MangaDax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="../CSS/navbar.css">
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
    body {
      background-color: #f8f9fa;
      padding-top: 0;
    }
  </style>
</head>
<body class="bg-light">
<?php
  // Set the path prefix for the navbar
  $pathPrefix = '../';
  include 'includes/navbar_minimal.php';
?>

<div class="container bg-white p-4 rounded shadow-sm mt-4">
  <h3 class="mb-3"><?=$mode==="upload" ? "Upload" : "Edit"?> Chapter</h3>
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
  <form method="POST" enctype="multipart/form-data" id="chapterForm">
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
      <?php if($mode==="upload"):?>
      <input type="text" id="mangaID" name="MangaID" value="<?=$mangaID?>" hidden>
      <?php endif?>
      <?php if($mode==="edit"):?>
      <input type="text" id="chapterID" name="chapterID" value="<?=$chapterID?>" hidden>
      <?php endif?>
        <p><strong>+</strong><br>Click or drag pages here</p>
        <input type="file" id="fileInput" name="pages[]" multiple accept="image/*" hidden>
      </div>
    </div>

    <!-- filelist -->
    <div id="fileList" class="mt-2 text-muted small"></div>
    <div id="pagePreview" class="row row-cols-2 row-cols-md-4 g-2 mt-3"></div>

    <!-- Buttons -->
    <div class="d-flex justify-content-between">
      <a href="../controller/mangaInfo_Controller.php?MangaID=<?=$mangaID?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Manga
      </a>
      <button type="submit" class="btn btn-primary"><?=$mode==="upload" ? "Upload" : "Edit"?></button>
    </div>
  </form>
</div>

  <script>
  const mode = "<?= $mode ?>"; // should be "edit" or "upload"
  const form = document.getElementById('chapterForm');

  if (mode === "edit") {
    form.action = "../controller/editChapter.php";
  } else {
    form.action = "../controller/uploadChapter.php";
  }
    const fileInput = document.getElementById('fileInput');
    const box = document.querySelector('.upload-box p');
    fileInput.addEventListener('change', function () {
      const fileList = document.getElementById('fileList');
      const previewContainer = document.getElementById('pagePreview');
      previewContainer.innerHTML = '';

      fileList.innerHTML = ''; // Clear previous
      if (this.files.length > 0) {
        const ul = document.createElement('ul');
        ul.style.listStyle = 'none';
        ul.style.paddingLeft = '0';

        Array.from(this.files).forEach((file, i) => {
          // List file names
          const li = document.createElement('li');
          li.textContent = `${i + 1}. ${file.name}`;
          ul.appendChild(li);

          // Generate image preview
          const reader = new FileReader();
          reader.onload = function (e) {
            const col = document.createElement('div');
            col.className = 'col';
            col.innerHTML = `
              <div class="card shadow-sm h-100">
                <img src="${e.target.result}" class="card-img-top" style="object-fit: cover; height: 200px;">
                <div class="card-body p-2">
                  <p class="card-text small text-truncate mb-0">${file.name}</p>
                </div>
              </div>`;
            previewContainer.appendChild(col);
          };
          reader.readAsDataURL(file);
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
          <?= $_GET['status'] === 'success' ? 'Success!' : 'Failed.' ?>
          <?php if (!empty($_GET['msg'])): ?>
            <br><small><?= htmlspecialchars($_GET['msg']) ?></small>
          <?php endif; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <?php endif; ?>


<?php if ($mode === "edit"):?>
  <script>
    const chapterData = <?= json_encode($chapterInfo, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    window.addEventListener('DOMContentLoaded', () => {
      // Fill text inputs
      document.querySelector('input[name="volume"]').value = chapterData.Volume || '';
      document.querySelector('input[name="chapter-number"]').value = chapterData.ChapterNumber || '';
      document.querySelector('input[name="scangroup-name"]').value = chapterData.ScangroupName || '';
      document.querySelector('input[name="chapter-name"]').value = chapterData.ChapterName || '';
      document.querySelector('select[name="language"]').value = 'English';

      <?php
        $chapterNumber = truncateNumber($chapterInfo["ChapterNumber"]);
        $chapterDir = "../IMG/$mangaID/$chapterNumber"; // adjust as needed
      ?>
      const previewContainer = document.getElementById('pagePreview');
      previewContainer.innerHTML = '';

      const existingPages = <?= json_encode($chapterPages) ?>;
      const chapterImageBasePath = "<?= $chapterDir ?>";

      existingPages.forEach(filename => {
        const col = document.createElement('div');
        col.className = 'col';
        col.innerHTML = `
          <div class="card shadow-sm h-100">
            <img src="${chapterImageBasePath}/${filename}" class="card-img-top" style="object-fit: cover; height: 200px;">
            <div class="card-body p-2">
              <p class="card-text small text-truncate mb-0">${filename}</p>
            </div>
          </div>`;
        previewContainer.appendChild(col);
      });
    });


</script>
<?php endif?>
</body>
</html>

