document.querySelectorAll('.chapter-container a').forEach(link => {
    link.addEventListener('click', e => e.stopPropagation());
});
window.onload = function() {
const descriptionText = document.querySelector('.description-text');
const seeMoreBtn = document.querySelector('.see-more-btn');

// Check if the description is overflowing
if (descriptionText.scrollHeight > descriptionText.clientHeight) {
    descriptionText.parentElement.classList.add('overflow');
}

// Toggle full description on "See More" button click
seeMoreBtn.addEventListener('click', function() {
    if (descriptionText.style.webkitLineClamp === "3") {
        descriptionText.style.webkitLineClamp = "unset"; // Show full text
        seeMoreBtn.innerText = "See Less"; // Change button text
    } else {
        descriptionText.style.webkitLineClamp = "3"; // Truncate text
        seeMoreBtn.innerText = "See More"; // Change button text back
    }
});
}

document.addEventListener('DOMContentLoaded', () => {
const form = document.getElementById('rating-form');
const isLoggedIn = form.dataset.loggedIn === "true";
const toastElement = document.getElementById('loginToast');
const toast = new bootstrap.Toast(toastElement);

document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();

        if (!isLoggedIn) {
            toast.show(); // Show toast if not logged in
            return;
        }

        // Set rating value in hidden input
        const ratingValue = this.dataset.value;
        document.getElementById('rating-input').value = ratingValue;

        // Optional: update button text (UI feedback)
        const label = this.textContent.trim();
        document.querySelector('.dropdown button span').textContent = label;

        form.submit();
    });
});

// Redundant, but safe fallback in case the form is submitted some other way
form.addEventListener('submit', function (e) {
    if (!isLoggedIn) {
        e.preventDefault();
        toast.show();
    }
    });
});

document.addEventListener('DOMContentLoaded', () => {
const form = document.getElementById('add-form');
const isLoggedIn = form.dataset.loggedIn === "true";
const toastElement = document.getElementById('loginToast');
const toast = new bootstrap.Toast(toastElement);

document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();

        if (!isLoggedIn) {
            toast.show(); // Show toast if not logged in
            return;
        }
        form.submit();
    });
});

// Redundant, but safe fallback in case the form is submitted some other way
form.addEventListener('submit', function (e) {
    if (!isLoggedIn) {
        e.preventDefault();
        toast.show();
    }
    });
});