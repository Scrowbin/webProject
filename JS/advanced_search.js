document.addEventListener('DOMContentLoaded', function() {
    // Toggle filters visibility
    const toggleFiltersBtn = document.getElementById('toggle-filters-btn');
    const advancedFilters = document.getElementById('advanced-filters');

    if (toggleFiltersBtn && advancedFilters) {
        toggleFiltersBtn.addEventListener('click', function() {
            advancedFilters.classList.toggle('d-none');

            if (advancedFilters.classList.contains('d-none')) {
                toggleFiltersBtn.textContent = 'Show filters';
                toggleFiltersBtn.classList.remove('btn-danger');
                toggleFiltersBtn.classList.add('btn-primary');
            } else {
                toggleFiltersBtn.textContent = 'Hide filters';
                toggleFiltersBtn.classList.remove('btn-primary');
                toggleFiltersBtn.classList.add('btn-danger');
            }
        });
    }

    // Reset filters
    const resetFiltersBtn = document.getElementById('reset-filters');
    const advancedSearchForm = document.getElementById('advanced-search-form');

    if (resetFiltersBtn && advancedSearchForm) {
        resetFiltersBtn.addEventListener('click', function() {
            // Clear all form fields except the search query
            const searchQuery = document.getElementById('search-input').value;
            advancedSearchForm.reset();
            document.getElementById('search-input').value = searchQuery;

            // Reset all select elements to their first option
            advancedSearchForm.querySelectorAll('select').forEach(select => {
                if (select.id !== 'search-input') {
                    select.selectedIndex = 0;
                }
            });

            // Clear tag selections
            document.getElementById('include_tags').value = '';
            document.getElementById('exclude_tags').value = '';

            // Clear selected tags display
            const selectedTagsContainer = document.querySelector('.selected-tags');
            if (selectedTagsContainer) {
                selectedTagsContainer.innerHTML = '';
            }

            // Reset global tag arrays
            includeTags = [];
            excludeTags = [];

            // Submit the form to apply the reset filters
            advancedSearchForm.submit();
        });
    }

    // Tag Modal Functionality
    const openTagModalBtn = document.getElementById('open-tag-modal');
    const tagModal = new bootstrap.Modal(document.getElementById('tagModal'));
    const applyTagsBtn = document.getElementById('apply-tags');
    const tagSearchInput = document.getElementById('tag-search');
    const tagResetBtn = document.getElementById('tag-reset');
    const tagDismissBtn = document.getElementById('tag-dismiss');
    const tagInstructions = document.querySelector('.tag-instructions');

    // Initialize tag selections from URL parameters
    const includeTagsInput = document.getElementById('include_tags');
    const excludeTagsInput = document.getElementById('exclude_tags');
    let includeTags = includeTagsInput.value ? includeTagsInput.value.split(',') : [];
    let excludeTags = excludeTagsInput.value ? excludeTagsInput.value.split(',') : [];

    // Mark tags in the modal based on current selections
    function updateTagSelections() {
        document.querySelectorAll('.tag-selectable').forEach(tag => {
            const tagName = tag.getAttribute('data-tag');
            tag.classList.remove('include', 'exclude');

            if (includeTags.includes(tagName)) {
                tag.classList.add('include');
            } else if (excludeTags.includes(tagName)) {
                tag.classList.add('exclude');
            }
        });
    }

    // Open tag modal
    if (openTagModalBtn) {
        openTagModalBtn.addEventListener('click', function() {
            updateTagSelections();
            tagModal.show();
        });
    }

    // Tag selection logic
    document.querySelectorAll('.tag-selectable').forEach(tag => {
        tag.addEventListener('click', function() {
            const tagName = this.getAttribute('data-tag');

            if (this.classList.contains('include')) {
                // Change from include to exclude
                this.classList.remove('include');
                this.classList.add('exclude');
                includeTags = includeTags.filter(t => t !== tagName);
                excludeTags.push(tagName);
            } else if (this.classList.contains('exclude')) {
                // Change from exclude to neither
                this.classList.remove('exclude');
                excludeTags = excludeTags.filter(t => t !== tagName);
            } else {
                // Change from neither to include
                this.classList.add('include');
                includeTags.push(tagName);
            }
        });
    });

    // Apply tag selections
    if (applyTagsBtn) {
        applyTagsBtn.addEventListener('click', function() {
            // Debug
            console.log('Include Tags before update:', includeTags);
            console.log('Exclude Tags before update:', excludeTags);

            // Update hidden inputs
            includeTagsInput.value = includeTags.join(',');
            excludeTagsInput.value = excludeTags.join(',');

            // Debug
            console.log('Include Tags input value:', includeTagsInput.value);
            console.log('Exclude Tags input value:', excludeTagsInput.value);

            // Update visual display of selected tags
            const selectedTagsContainer = document.querySelector('.selected-tags');
            selectedTagsContainer.innerHTML = '';

            includeTags.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.className = 'tag-badge include-tag';
                tagElement.innerHTML = tag.toUpperCase() + ' <i class="bi bi-plus-circle-fill"></i>';
                selectedTagsContainer.appendChild(tagElement);
            });

            excludeTags.forEach(tag => {
                const tagElement = document.createElement('span');
                tagElement.className = 'tag-badge exclude-tag';
                tagElement.innerHTML = tag.toUpperCase() + ' <i class="bi bi-dash-circle-fill"></i>';
                selectedTagsContainer.appendChild(tagElement);
            });

            tagModal.hide();
        });
    }

    // Tag search functionality
    if (tagSearchInput) {
        tagSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            document.querySelectorAll('.tag-selectable').forEach(tag => {
                const tagName = tag.textContent.toLowerCase();
                if (tagName.includes(searchTerm)) {
                    tag.style.display = '';
                } else {
                    tag.style.display = 'none';
                }
            });
        });
    }

    // Reset tag search and selections
    if (tagResetBtn) {
        tagResetBtn.addEventListener('click', function() {
            tagSearchInput.value = '';
            document.querySelectorAll('.tag-selectable').forEach(tag => {
                tag.style.display = '';
                tag.classList.remove('include', 'exclude');
            });

            includeTags = [];
            excludeTags = [];
        });
    }

    // Dismiss tag instructions
    if (tagDismissBtn && tagInstructions) {
        tagDismissBtn.addEventListener('click', function() {
            tagInstructions.style.display = 'none';
        });
    }

    // Handle form submission with pagination
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.parentElement.classList.contains('disabled') && !this.parentElement.classList.contains('active')) {
                e.preventDefault();

                const pageNum = this.getAttribute('data-page');
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('page', pageNum);

                window.location.href = currentUrl.toString();
            }
        });
    });
});
