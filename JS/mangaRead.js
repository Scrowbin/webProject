document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll("img");
    const button = document.getElementById("toggleFit");

    function updateButton() {
        if (images.length === 0) return;

        const firstImg = images[0]; // Check the first image's class

        if (firstImg.classList.contains("img-fluid")) {
            button.innerHTML = '<i class="bi bi-arrow-left-right"></i> Fit Width'; // ↔
        } else if (firstImg.classList.contains("img-fit-height")) {
            button.innerHTML = '<i class="bi bi-arrow-down-up"></i>Fit Height'; // ↕
        } else if (firstImg.classList.contains("img-fit-both")) {
            button.innerHTML = '<i class="bi bi-arrows-fullscreen"></i> Fit Both'; // Expand
        } else {
            button.innerHTML = '<i class="bi bi-stop"></i> None'; // Stop icon
        }
    }

    // Run on page load
    updateButton();

    // Button click event
    button.addEventListener("click", function () {
        images.forEach(img => {
            if (img.classList.contains("img-fluid")) {
                img.classList.remove("img-fluid");
                img.classList.add("img-fit-height");
            } else if (img.classList.contains("img-fit-height")) {
                img.classList.remove("img-fit-height");
                img.classList.add("img-fit-both");
            } else if (img.classList.contains("img-fit-both")) {
                img.classList.remove("img-fit-both");
            } else {
                img.classList.add("img-fluid");
            }
        });

        updateButton(); // Update button text & icon
    });
});
