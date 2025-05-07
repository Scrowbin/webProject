<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manga Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="mb-4">Reported Manga Issues</h2>

    <!-- Card for Each Manga -->
    <div class="card mb-3">
        <div class="card-body">
            <!-- Manga-level Reports Table -->
            <h5>Manga-level Reports</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover align-middle" id="manga-reports-table">
                    <thead class="table-light">
                        <tr>
                            <th>Manga Cover</th>
                            <th>Manga Name</th>
                            <th>Problem</th>
                            <th>Reported By</th>
                            <th>Additional Info</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="manga-reports-body">
                        <!-- Manga reports will be loaded here -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination for Manga Reports -->
            <div id="manga-pagination" class="d-flex justify-content-center">
                <button class="btn btn-primary" id="manga-prev" disabled>Previous</button>
                <span id="manga-page-num" class="mx-3">Page 1</span>
                <button class="btn btn-primary" id="manga-next">Next</button>
            </div>

            <!-- Chapter-level Reports Table -->
            <h5>Chapter-level Reports</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover align-middle" id="chapter-reports-table">
                    <thead class="table-light">
                        <tr>
                            <th>Manga</th>
                            <th>Chapter</th>
                            <th>Chapter Name</th>
                            <th>Problem</th>
                            <th>Reported By</th>
                            <th>Additional Info</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="chapter-reports-body">
                        <!-- Chapter reports will be loaded here -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination for Chapter Reports -->
            <div id="chapter-pagination" class="d-flex justify-content-center">
                <button class="btn btn-primary" id="chapter-prev" disabled>Previous</button>
                <span id="chapter-page-num" class="mx-3">Page 1</span>
                <button class="btn btn-primary" id="chapter-next">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let mangaPage = 1;
    let chapterPage = 1;
    // Fetch manga reports
    function fetchMangaReports(page) {
        fetch(`../controller/fetchReports.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('manga-reports-body');
                const pageNum = document.getElementById('manga-page-num');
                const prevButton = document.getElementById('manga-prev');
                const nextButton = document.getElementById('manga-next');

                tableBody.innerHTML = '';
                data.mangaReports.forEach(report => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-report-id', report.ReportID);
                    row.setAttribute('data-type', "manga");

                    row.innerHTML = `
                        <td><a href="../controller/mangaInfo_Controller.php?MangaID=${report.MangaID}"><img src="../IMG/${report.MangaID}/${report.CoverLink}" height="50"></a></td>
                        <td><a href="../controller/mangaInfo_Controller.php?MangaID=${report.MangaID}">${report.MangaNameOG}</a></td>
                        <td>${report.ReportType}</td>
                        <td>${report.Username}</td>
                        <td>${report.Description}</td>
                        <td><button class="btn btn-success btn-sm resolve-btn">Resolved</button></td>
                    `;
                    tableBody.appendChild(row);
                });

                // Update pagination
                pageNum.textContent = `Page ${page}`;
                prevButton.disabled = page <= 1;
                nextButton.disabled = !data.has_more;

                // Update page
                mangaPage = page;
            });
    }

    // Fetch chapter reports
    function fetchChapterReports(page) {
        fetch(`../controller/fetchReports.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('chapter-reports-body');
                const pageNum = document.getElementById('chapter-page-num');
                const prevButton = document.getElementById('chapter-prev');
                const nextButton = document.getElementById('chapter-next');

                tableBody.innerHTML = '';
                data.chapterReports.forEach(report => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-report-id', report.ReportID);
                    row.setAttribute('data-type', "chapter");

                    row.innerHTML = `
                        <td>${report.MangaNameOG}</td>
                        <td>${report.ChapterNumber}</td>
                        <td><a href="../controller/mangaRead_controller.php?chapterID=${report.manga_id}">${report.ChapterName}</a></td>
                        <td>${report.ReportType}</td>
                        <td>${report.Username}</td>
                        <td>${report.Description}</td>
                        <td><button class="btn btn-success btn-sm resolve-btn">Resolved</button></td>
                    `;
                    tableBody.appendChild(row);
                });

                // Update pagination
                pageNum.textContent = `Page ${page}`;
                prevButton.disabled = page <= 1;
                nextButton.disabled = !data.has_more;

                // Update page
                chapterPage = page;
            });
    }

    // Event listeners for pagination buttons
    document.getElementById('manga-prev').addEventListener('click', function () {
        if (mangaPage > 1) {
            fetchMangaReports(mangaPage - 1);
        }
    });

    document.getElementById('manga-next').addEventListener('click', function () {
        fetchMangaReports(mangaPage + 1);
    });

    document.getElementById('chapter-prev').addEventListener('click', function () {
        if (chapterPage > 1) {
            fetchChapterReports(chapterPage - 1);
        }
    });

    document.getElementById('chapter-next').addEventListener('click', function () {
        fetchChapterReports(chapterPage + 1);
    });

    // Initial fetch
    fetchMangaReports(mangaPage);
    fetchChapterReports(chapterPage);
    
    $(document).ready(function() {
        $(document).on('click', '.resolve-btn', function() {    
            const row = $(this).closest('tr');
            const reportID = row.data('report-id');
            const type = row.data('type'); // "manga" or "chapter"

            $.ajax({
                url: '../controller/resolve_report.php',
                method: 'POST',
                data: { reportID, type },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() { $(this).remove();  if (type === 'manga') {
                            fetchMangaReports(mangaPage);
                        } else {
                            fetchChapterReports(chapterPage);
                        }});
                    } else {
                        alert("Failed to mark as resolved: " + response.message);
                    }
                },
                error: function(xhr) {
                    alert("An error occurred while resolving the report.");
                }
            });
        });
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
