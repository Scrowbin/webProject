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
    // document.querySelectorAll('.dropdown-item').forEach(item => {
    //     item.addEventListener('click', function (e) {
    //         e.preventDefault();

    //         if (!isLoggedIn) {
    //             toast.show(); // Show toast if not logged in
    //             return;
    //         }

    //         // Set rating value in hidden input
    //         const ratingValue = this.dataset.value;
    //         document.getElementById('rating-input').value = ratingValue;

    //         // Optional: update button text
    //         const label = this.textContent.trim();
    //         document.querySelector('.dropdown button span').textContent = label;

    //         ratingForm.submit();
    //     });
    // });

    // Prevent rating form submission if not logged in
    // if (ratingForm) {
    //     ratingForm.addEventListener('submit', function (e) {
    //         if (!isLoggedIn) {
    //             e.preventDefault();
    //             toast.show();
    //         }
    //     });
    // }

    // Prevent add-form submission if not logged in
    // if (addForm) {
    //     addForm.addEventListener('submit', function (e) {
    //         if (!isLoggedIn) {
    //             e.preventDefault();
    //             toast.show();
    //         }
    //     });
    // }
    addForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!isLoggedIn) {
            toast.show();
            return;
        }
    
        const formData = new FormData(addForm);
        try {
            const res = await fetch(addForm.action, {
                method: "POST",
                body: formData
            });
    
            const data = await res.json();
    
            if (data.success) {
                const isNowBookmarked = data.bookmarked;
                const button = addForm.querySelector("button");
                const icon = button.querySelector("i");
                const label = button.querySelector("span");
    
                icon.className = isNowBookmarked ? "bi bi-check2 me-2" : "bi bi-bookmark me-2";
                label.textContent = isNowBookmarked ? "Added to Library" : "Add To Library";
    
                addForm.dataset.bookmarked = isNowBookmarked ? "true" : "false";
            } else {
                console.error("Server responded with failure:", data.message);
            }
        } catch (err) {
            console.error("Bookmark error:", err);
        }
    });
    // Rating dropdown logic
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', async function (e) {
            e.preventDefault();

            if (!isLoggedIn) {
                toast.show();
                return;
            }

            const ratingValue = this.dataset.value;
            document.getElementById('rating-input').value = ratingValue;

            const formData = new FormData(ratingForm);

            try {
                const res = await fetch(ratingForm.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.success) {
                    const btnLabel = ratingForm.querySelector('button span');
                    const rating = data.rating;
                    btnLabel.textContent = rating === 0 ? "Rate" : `(${rating})`;
                } else {
                    console.error("Failed to rate:", data.message);
                }
            } catch (err) {
                console.error("Rating error:", err);
            }
        });
    });

        
});
