// Function to determine the base path based on the current page
function getBasePath() {
    const path = window.location.pathname;

    // If we're in a subdirectory like /controller/ or /PHP/
    if (path.includes('/controller/') || path.includes('/PHP/')) {
        return '/';
    }

    // If we're at the root
    return '/';
}

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.querySelector('.search-loading');
    const searchNoResults = document.querySelector('.search-no-results');
    const searchInitialState = document.querySelector('.search-initial-state');
    const searchTrigger = document.getElementById('search-trigger');
    const searchDropdown = document.getElementById('search-dropdown');
    const searchBox = document.querySelector('.search-box');
    const searchClose = document.getElementById('search-close');
    const viewAllLink = document.querySelector('.view-all-link');

    // Keyboard shortcut for search (Ctrl+K)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openSearch();
        }
    });

    // Open search dropdown when clicking on search box
    if (searchTrigger) {
        searchTrigger.addEventListener('click', function() {
            openSearch();
        });
    }

    // Close search dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container') && searchDropdown.classList.contains('show')) {
            closeSearch();
        }
    });

    // Close search when clicking the close button
    if (searchClose) {
        searchClose.addEventListener('click', function(e) {
            e.stopPropagation();
            closeSearch();
        });
    }

    // Handle advanced search link click
    if (viewAllLink) {
        viewAllLink.addEventListener('click', function(e) {
            const query = searchInput.value.trim();
            if (query.length > 0) {
                // If there's a query, redirect to advanced search with the query
                const basePath = getBasePath();
                e.preventDefault();
                window.location.href = `${basePath}controller/advanced_search_controller.php?query=${encodeURIComponent(query)}`;
            }
        });
    }

    // Close search when pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchDropdown.classList.contains('show')) {
            closeSearch();
        }
    });

    // Function to open search
    function openSearch() {
        searchBox.classList.add('expanded');
        searchDropdown.classList.add('show');
        searchInput.focus();
        searchClose.classList.remove('d-none');
    }

    // Function to close search
    function closeSearch() {
        searchBox.classList.remove('expanded');
        searchDropdown.classList.remove('show');
        searchInput.value = '';
        searchResults.innerHTML = '';
        showElement(searchInitialState);
        hideElement(searchLoading);
        hideElement(searchNoResults);
        searchClose.classList.add('d-none');
    }

    // Handle search input
    if (searchInput) {
        let debounceTimer;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            // Clear previous timer
            clearTimeout(debounceTimer);

            if (query.length === 0) {
                // Show initial state
                searchResults.innerHTML = '';
                showElement(searchInitialState);
                hideElement(searchLoading);
                hideElement(searchNoResults);
                return;
            }

            // Hide initial state, show loading
            hideElement(searchInitialState);
            hideElement(searchNoResults);
            showElement(searchLoading);

            // Debounce search to avoid too many requests
            debounceTimer = setTimeout(function() {
                performSearch(query);
            }, 300);
        });
    }

    // Perform search
    function performSearch(query) {
        // Get the base path based on the current page
        const basePath = getBasePath();

        fetch(`${basePath}controller/search_controller.php?query=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideElement(searchLoading);

            if (data.length === 0) {
                showElement(searchNoResults);
                searchResults.innerHTML = '';
            } else {
                hideElement(searchNoResults);
                displaySearchResults(data);
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            hideElement(searchLoading);
            showElement(searchNoResults);
        });
    }

    // Display search results
    function displaySearchResults(results) {
        searchResults.innerHTML = '';

        results.forEach(manga => {
            const status = manga.PublicationStatus === 'Completed' ? 'completed' : 'ongoing';
            const rating = manga.AvgRating ? parseFloat(manga.AvgRating).toFixed(1) : 'N/A';
            const bookmarks = manga.BookmarkCount || Math.floor(Math.random() * 1000);
            const mangaSlug = manga.Slug || "";
            const resultItem = document.createElement('a');
            const basePath = getBasePath();
            resultItem.href = basePath + 'manga/' + mangaSlug;
            resultItem.className = 'search-result-item';

            resultItem.innerHTML = `
                <img src="${basePath}IMG/${manga.MangaID}/${manga.CoverLink}" alt="${manga.MangaNameOG}" class="search-result-cover">
                <div class="search-result-info">
                    <div class="search-result-title">${manga.MangaNameOG}</div>
                    <div class="search-result-subtitle">${manga.MangaNameEN}</div>
                    <div class="search-result-meta">
                        <span class="rating"><i class="bi bi-star-fill"></i> ${rating}</span>
                        <span class="search-result-status ${status}">${status}</span>
                        <span><i class="bi bi-bookmark"></i> ${bookmarks}</span>
                    </div>
                </div>
            `;

            searchResults.appendChild(resultItem);
        });
    }

    // Helper functions
    function showElement(element) {
        if (element) element.classList.remove('d-none');
    }

    function hideElement(element) {
        if (element) element.classList.add('d-none');
    }
});
