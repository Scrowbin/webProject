document.addEventListener("DOMContentLoaded", function () {
    const chaptersPerPage = 5;
    let currentPage = 1;
    let groupedData = [];

    function truncateNumber(num) {
        const n = parseFloat(num);
        return Number.isInteger(n) ? String(Math.trunc(n)) : String(n);
    }

    function chapterQueryValue(chapterNumber) {
        const n = parseFloat(chapterNumber);
        return Number.isInteger(n) ? String(Math.trunc(n)) : String(n);
    }

    function chapterSlugPart(chapterNumber) {
        return chapterQueryValue(chapterNumber).replace('.', '-');
    }

    function mangaInfoUrl(slug) {
        if (window.MANGA_URL_MODE === 'pretty') {
            return '/manga/' + slug;
        }
        return '/controllers/mangaInfo_Controller.php?slug=' + encodeURIComponent(slug);
    }

    function chapterReadUrl(slug, chapterNumber) {
        if (window.MANGA_URL_MODE === 'pretty') {
            return '/read/' + slug + '/chapter-' + chapterSlugPart(chapterNumber);
        }
        return '/controllers/mangaRead_Controller.php?slug=' + encodeURIComponent(slug)
            + '&chapter=' + encodeURIComponent(chapterQueryValue(chapterNumber));
    }

    function commentsUrl(slug, chapterNumber) {
        if (window.MANGA_URL_MODE === 'pretty') {
            return '/comments/' + slug + '/chapter-' + chapterSlugPart(chapterNumber);
        }
        return '/controllers/comments_controller.php?slug=' + encodeURIComponent(slug)
            + '&chapter=' + encodeURIComponent(chapterQueryValue(chapterNumber));
    }

    function timeAgo(dateStr) {
        const date = new Date(dateStr);
        const seconds = Math.floor((new Date() - date) / 1000);
        const intervals = {
            year: 31536000, month: 2592000, day: 86400,
            hour: 3600, minute: 60, second: 1
        };
        for (let unit in intervals) {
            const interval = Math.floor(seconds / intervals[unit]);
            if (interval >= 1) return `${interval} ${unit}${interval > 1 ? 's' : ''} ago`;
        }
        return 'just now';
    }
    function getFlag(language) {
        switch (language.toLowerCase()) {
            case "en":
            case "english":
                return '<img class="flag" src="https://mangadex.org/img/flags/gb.svg">';
            case "jp":
            case "japanese":
                return '<img class="flag" src="https://mangadex.org/img/flags/jp.svg">';
            case "kr":
            case "korean":
                return '<img class="flag" src="https://mangadex.org/img/flags/kr.svg">';
            case "vn":
            case "vietnamese":
                return '<img class="flag" src="https://mangadex.org/img/flags/vn.svg">';
            default:
                return '<img class="flag" src="https://mangadex.org/img/flags/gb.svg">';
        }
    }
    function renderPage(page) {
        const container = document.getElementById('manga-container');
        container.innerHTML = '';

        const start = (page - 1) * chaptersPerPage;
        const end = start + chaptersPerPage;
        const paginatedGroups = groupedData.slice(start, end);

        paginatedGroups.forEach(mangaGroup => {
            const manga = mangaGroup[0];
            const mangaHTML = `
                <div class="manga-card">
                    <div class="manga-cover">
                        <a href="${mangaInfoUrl(manga.Slug)}">
                            <img src="/manga/${manga.MangaID}/${manga.CoverLink}" alt="Manga Cover">
                        </a>
                    </div>
                    <div class="manga-details">
                        <div class="manga-header">
                            ${getFlag(manga.OriginalLanguage)}
                            <a href="${mangaInfoUrl(manga.Slug)}" class="manga-title"><strong>${manga.MangaNameOG}</strong></a>
                        </div>
                        <hr>
                        ${mangaGroup.map(chapter => {
                            const chapterNum = truncateNumber(chapter.ChapterNumber);
                            const chapterSlug = chapterReadUrl(manga.Slug, chapter.ChapterNumber);
                            const CommentSectionSlug = commentsUrl(manga.Slug, chapter.ChapterNumber);
                            return `
                                <div class="chapter-container mb-1" onclick="window.location.href='${chapterSlug}'">
                                    <div class="chapter-info">
                                        <div class="info-left">
                                            <div class="chapter-title">
                                                ${getFlag(chapter.Language)}
                                                <strong>Ch. ${chapterNum} - ${chapter.ChapterName}</strong>
                                            </div>
                                            <div class="scan-group">
                                                <a href="#">
                                                    <img src="/assets/static/avatar.svg" class="icon">
                                                    <span>${chapter.ScangroupName}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info-middle">
                                            <div class="time">
                                                <img src="/assets/static/clock.svg" class="icon">
                                                <strong>${timeAgo(chapter.UploadTime)}</strong>
                                            </div>
                                            <div class="uploader">
                                                <img src="/assets/static/avatar.svg" class="icon">
                                                <a href="#">${chapter.UploaderName}</a>
                                            </div>
                                        </div>
                                        <div class="info-right">
                                            <div class="views">
                                                <img class="icon" src="/assets/static/eye.svg">
                                                <strong>N/A</strong>
                                            </div>
                                            <div class="comments">
                                                <a href="${CommentSectionSlug}">
                                                    <img src="/assets/static/comment.svg">
                                                    <strong>${chapter.NumOfComments}</strong>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }).join('')}

                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', mangaHTML);
        });

        renderPagination();
    }

    function renderPagination() {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';
        const totalPages = Math.ceil(groupedData.length / chaptersPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.add('page-btn');
            if (i === currentPage) btn.classList.add('active');
            btn.addEventListener('click', () => {
                currentPage = i;
                renderPage(currentPage);
            });
            paginationContainer.appendChild(btn);
        }
    }

    fetch('/controllers/fetchChapter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ chapterIDs: JSON.parse(localStorage.getItem('viewedChapters') || '[]') })
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('HTTP ' + res.status);
        }
        return res.json();
    })
    .then(grouped => {
        if (!Array.isArray(grouped)) {
            throw new Error('Invalid response');
        }
        groupedData = grouped;

        // Check if there's any reading history
        if (grouped.length === 0) {
            const container = document.getElementById('manga-container');
            container.innerHTML = `
                <h2 class="mb-4">Reading History</h2>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    You haven't read any manga yet. Start reading to see your history here!
                </div>
            `;
            document.getElementById('pagination').style.display = 'none';
        } else {
            renderPage(currentPage);
        }
    })
    .catch(err => {
        console.error('Failed to load viewed chapters:', err);
        const container = document.getElementById('manga-container');
        if (container) {
            container.innerHTML = `
                <div class="alert alert-warning ms-5 me-5">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Could not load reading history. Try refreshing the page.
                </div>`;
        }
    });
});
