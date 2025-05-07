document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.chapter-container a').forEach(link => {
        link.addEventListener('click', e => e.stopPropagation());
    });

    const descriptionText = document.querySelector('.description-text');
    const seeMoreBtn = document.querySelector('.see-more-btn');
    function checkOverflow() {
        if (!descriptionText || !seeMoreBtn) return;

        const isOverflowing = descriptionText.scrollHeight > descriptionText.clientHeight;

        // Show or hide the See More button
        seeMoreBtn.style.display = isOverflowing ? "inline-block" : "none";
    }

    checkOverflow();
    // Re-check on window resize
    window.addEventListener("resize", checkOverflow);

    // Toggle full description on button click
    seeMoreBtn.addEventListener('click', function () {
        const isExpanded = descriptionText.classList.toggle("expanded");
        seeMoreBtn.innerText = isExpanded ? "See Less" : "See More";
        checkOverflow(); // Optional: re-check in case expansion collapses the need
    });

    const ratingForm = document.getElementById('rating-form');
    const addForm = document.getElementById('add-form');
    const isLoggedIn = ratingForm?.dataset.loggedIn === "true";
    const toastElement = document.getElementById('loginToast');
    const toast = new bootstrap.Toast(toastElement);

    addForm?.addEventListener('submit', async function (e) {
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
    
    

    document.getElementById("report-btn").addEventListener("click", function () {
        if (!isLoggedIn) {
            toast.show();
            return;
        }
        const reportModal = new bootstrap.Modal(document.getElementById("reportModal"));
        reportModal.show();
    });
    $(document).ready(function() {
        $('#reportForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: '../controller/handle_report.php',  // The server-side script that will handle the report
                method: 'POST',            // HTTP method (POST in this case)
                data: formData,            // The serialized form data
                success: function(response) {
                    // Handle success
                    console.log('Report submitted:', response);
                    alert('Your report has been submitted successfully.');

                    // Optionally, close the modal
                    $('#reportModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log('Error submitting report:', error);
                    alert('Failed to submit report. Please try again later.');
                }
            });
        });
    });
    document.getElementById("deleteMangaBtn").addEventListener("click", function () {
        const toastEl = document.getElementById("confirmDeleteToast");
        const toast = new bootstrap.Toast(toastEl);
        toast.show();

        document.getElementById("confirmDeleteBtn").onclick = function () {
            document.getElementById("hiddenMangaID").value = mangaID;
            document.getElementById("deleteForm").submit();
        };
    });
});
