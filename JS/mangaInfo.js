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
    let ratingForm = document.getElementById('rating-form');
    let addForm = document.getElementById('add-form');
    let isLoggedIn = ratingForm?.dataset.loggedIn === "true"; // Safely access logged-in flag
    let toastElement = document.getElementById('loginToast');
    let toast = new bootstrap.Toast(toastElement);

    // Handle rating dropdown
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

            // Optional: update button text
            const label = this.textContent.trim();
            document.querySelector('.dropdown button span').textContent = label;

            ratingForm.submit();
        });
    });

    // Prevent rating form submission if not logged in
    if (ratingForm) {
        ratingForm.addEventListener('submit', function (e) {
            if (!isLoggedIn) {
                e.preventDefault();
                toast.show();
            }
        });
    }

    // Prevent add-form submission if not logged in
    if (addForm) {
        addForm.addEventListener('submit', function (e) {
            if (!isLoggedIn) {
                e.preventDefault();
                toast.show();
            }
        });
    }

});
