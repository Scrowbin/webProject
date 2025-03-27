document.addEventListener("DOMContentLoaded", function () {
    // DOM Elements
    const pageContainer = document.getElementById("page-container");
    const progressBar = document.getElementById("progress-bar");
    const toggleButton = document.getElementById("toggleFit");
    const readMethodButton = document.getElementById("readMethod");
    const prevPageBtn = document.getElementById("prevPageBtn");
    const nextPageBtn = document.getElementById("nextPageBtn");
    const pageDropdown = document.querySelector(".page-dropdown");
    let scrollSpyInstance;
    let currentIndex = 0;
    let isLongStripMode = true; // Default to "Long Strip" mode

    function initializeScrollSpy() {
        if (scrollSpyInstance) {
            scrollSpyInstance.dispose(); // Destroy previous instance
        }

        scrollSpyInstance = new bootstrap.ScrollSpy(document.getElementById("page-container"), {
            target: "#progress-bar",
            offset: 0
        });
    }

    initializeScrollSpy();
    // Function to dynamically fetch the latest images from the DOM
    function getImages() {
        return document.querySelectorAll(".page img");
    }


    // Update the toggle button text based on the image fit class
    function updateToggleButton() {
        const images = getImages();
        if (images[0].classList.contains("img-fluid")) {
            toggleButton.innerHTML = '<i class="bi bi-arrow-left-right"></i> Fit Width';
        } else if (images[0].classList.contains("img-fit-height")) {
            toggleButton.innerHTML = '<i class="bi bi-arrow-down-up"></i> Fit Height';
        } else if (images[0].classList.contains("img-fit-both")) {
            toggleButton.innerHTML = '<i class="bi bi-arrows-fullscreen"></i> Fit Both';
        } else {
            toggleButton.innerHTML = '<i class="bi bi-stop"></i> None';
        }
    }

    // Link images to their respective next images for navigation
    // function linkNextImage() {
    //     const images = getImages();
    //     images.forEach((img, index) => {
    //         if (img.parentElement.tagName.toLowerCase() === "a") return;

    //         const link = document.createElement("a");
    //         const nextIndex = (index + 1) % images.length; // Loop back to the first image
    //         const nextId = `page-${nextIndex + 1}`;

    //         if (!img.id) img.id = `page-${index + 1}`;
    //         if (!images[nextIndex].id) images[nextIndex].id = nextId;

    //         link.href = `#${nextId}`;
    //         link.appendChild(img.cloneNode(true));
    //         img.replaceWith(link);
    //     });
    // }

    // Revert links back to standalone images
    // function revertToImages() {
    //     document.querySelectorAll(".page a").forEach(link => {
    //         const img = link.querySelector("img");
    //         if (img) link.replaceWith(img);
    //     });
    // }

    // Show a specific image in "One Page" mode
    function showImage(index) {
        const images = getImages();
        images.forEach((img, i) => {
            img.classList.toggle("active", i === index);
            img.classList.toggle("hidden", i !== index);
        });
    }

    // Navigate to the next image
    function nextImage() {
        const images = getImages();
        currentIndex = (currentIndex + 1) % images.length;
        if (!isLongStripMode) {
            showImage(currentIndex);
        } else {
            window.location.href = `#page-${currentIndex + 1}`;
        }
        pageDropdown.value = currentIndex + 1;
    }

    // Navigate to the previous image
    function prevImage() {
        const images = getImages();
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        if (!isLongStripMode) {
            showImage(currentIndex);
        } else {
            window.location.href = `#page-${currentIndex + 1}`;
        }
        pageDropdown.value = currentIndex + 1;
    }

    // Toggle between different image fit modes
    toggleButton.addEventListener("click", function () {
        const images = getImages();
        images.forEach(img => {
            if (img.classList.contains("img-fluid")) {
                img.classList.replace("img-fluid", "img-fit-height");
            } else if (img.classList.contains("img-fit-height")) {
                img.classList.replace("img-fit-height", "img-fit-both");
            } else if (img.classList.contains("img-fit-both")) {
                img.classList.remove("img-fit-both");
            } else {
                img.classList.add("img-fluid");
            }
        });
        updateToggleButton();
    });

    // Toggle between "Long Strip" and "One Page" modes
    readMethodButton.addEventListener("click", function () {
        let images = getImages();
        let navbarLinks = document.querySelectorAll("#progress-bar a");

        if (isLongStripMode) {
            // Switch to "One Page" mode
            readMethodButton.innerHTML = "One Page";
            // revertToImages();
            images.forEach(img => img.classList.add("clickable"));
            images.forEach(img => img.addEventListener("click", nextImage));
            showImage(currentIndex);
            pageDropdown.value = currentIndex + 1; // Sync dropdown to match current image

            
            navbarLinks.forEach((link, index) => {
                link.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent default anchor jump
                    showImage(index);
                    currentIndex = index; // Update current index
                    pageDropdown.value = index + 1; // Sync with dropdown
                });
            });
            
        } else {
            // Switch to "Long Strip" mode
            readMethodButton.innerHTML = "Long Strip";
            images.forEach(img => img.classList.remove("clickable", "active", "hidden"));
            images.forEach(img => img.removeEventListener("click", nextImage));

            // 🔥 Force update `currentIndex` to match the scroll position
            let activeImageIndex = Array.from(images).findIndex(img => img.getBoundingClientRect().top >= 0);
            if (activeImageIndex !== -1) {
                currentIndex = activeImageIndex;
            }

            pageDropdown.value = currentIndex + 1;

            navbarLinks.forEach(link => {
                link.replaceWith(link.cloneNode(true)); // This removes old event listeners
            });
        // linkNextImage();
        initializeScrollSpy();

        }
        isLongStripMode = !isLongStripMode;
    });

    // Handle dropdown page selection
    pageDropdown.addEventListener("change", function () {
        images = getImages();
        currentIndex = parseInt(pageDropdown.value, 10) - 1;
        if (!isLongStripMode) {
            showImage(currentIndex);
        } else {
            window.location.href = `#page-${currentIndex + 1}`;
        }
    });
    // document.addEventListener("DOMContentLoaded", function () {
    // document.addEventListener("scroll", function () {
    //     const images = getImages();
    //     let newIndex = images.length - 1; // Default to last image

    //     for (let i = 0; i < images.length; i++) {
    //         const rect = images[i].getBoundingClientRect();
    //         if (rect.top >= 0 && rect.top < window.innerHeight / 2) {
    //             newIndex = i;
    //             break;
    //         }
    //     }

    //     currentIndex = newIndex;
    //     pageDropdown.value = currentIndex + 1; // Update dropdown
    //     });
    // });

    // Attach event listeners for navigation buttons
    prevPageBtn.addEventListener("click", prevImage);
    nextPageBtn.addEventListener("click", nextImage);

    updateToggleButton();
});
