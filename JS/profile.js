// Avatar elements
const avatarInput = document.getElementById("avatarInput");
const previewAvatar = document.getElementById("previewAvatar");
const avatarWrapper = document.querySelector(".avatar-wrapper");
const saveAvatar = document.getElementById("saveAvatar");
const avatarModal = document.getElementById("avatarModal");
const cropAvatarBtn = document.getElementById("cropAvatarBtn");

// Banner elements
const bannerInput = document.getElementById("bannerInput");
const previewBanner = document.getElementById("previewBanner");
const currentBanner = document.getElementById("currentBanner");
const saveBanner = document.getElementById("saveBanner");
const bannerModal = document.getElementById("bannerModal");
const cropBannerBtn = document.getElementById("cropBannerBtn");

let cropper;

// Function to initialize Cropper
function initCropper(imageElement, aspectRatio = null) {
    if (cropper) {
        cropper.destroy();
    }
    const options = {
        viewMode: 1,
        scalable: false,
        zoomable: false,
        movable: false,
        autoCropArea: 1,
        cropBoxResizable: true,
    };
    if (aspectRatio) {
        options.aspectRatio = aspectRatio;
    }
    cropper = new Cropper(imageElement, options);
}

// Initialize avatar preview with current avatar (if available)
if (previewAvatar) {
    // Use the first letter of username as fallback
    const firstLetter = avatarWrapper ? avatarWrapper.textContent.trim() : 'U';
    previewAvatar.setAttribute('data-initial', firstLetter);
}

// Initialize banner preview with current banner
if (previewBanner && currentBanner) {
    previewBanner.src = currentBanner.src;
}

// Handle avatar image selection
avatarInput.addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewAvatar.src = e.target.result;
            cropAvatarBtn.style.display = "block";
            if (cropper) {
                cropper.destroy();
            }
            initCropper(previewAvatar, 1);
        };
        reader.readAsDataURL(file);
    } else {
        previewAvatar.src = avatar.src; // Reset to original avatar if no file
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }
});

// Handle clicking the Crop button for avatar
cropAvatarBtn.addEventListener("click", function () {
    initCropper(previewAvatar, 1);
    saveAvatar.style.display = "block";
});

// Handle saving the cropped avatar
saveAvatar.addEventListener("click", function () {
    if (cropper) {
        const croppedCanvas = cropper.getCroppedCanvas({
            width: 150,
            height: 150,
        });

        // Get the data URL of the cropped image
        const imageDataUrl = croppedCanvas.toDataURL("image/png");

        // Update the avatar wrapper with the new image
        if (avatarWrapper) {
            // Create a new image element
            const img = document.createElement('img');
            img.src = imageDataUrl;
            img.className = 'w-100 h-100';
            img.style.objectFit = 'cover';

            // Clear the avatar wrapper and add the new image
            avatarWrapper.innerHTML = '';
            avatarWrapper.appendChild(img);

            // Hide the text content (first letter)
            avatarWrapper.style.fontSize = '0';
            avatarWrapper.style.lineHeight = 'normal';
        }

        // Update the preview
        previewAvatar.src = imageDataUrl;

        // Clean up
        cropper.destroy();
        cropper = null;
        saveAvatar.style.display = "none";

        // Close the modal
        let modalElement = document.getElementById("avatarModal");
        let modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();

        // Add a hidden input to the form to submit the avatar data
        let avatarDataInput = document.getElementById('avatarData');
        if (!avatarDataInput) {
            avatarDataInput = document.createElement('input');
            avatarDataInput.type = 'hidden';
            avatarDataInput.name = 'avatarData';
            avatarDataInput.id = 'avatarData';
            document.querySelector('form').appendChild(avatarDataInput);
        }
        avatarDataInput.value = imageDataUrl;
    }
});

// Handle banner image selection
bannerInput.addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewBanner.src = e.target.result;
            cropBannerBtn.style.display = "block";
            if (cropper) {
                cropper.destroy();
            }
            initCropper(previewBanner);
        };
        reader.readAsDataURL(file);
    } else {
        previewBanner.src = banner.src; // Reset to original banner if no file
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }
});

// Handle clicking the Crop button for banner
cropBannerBtn.addEventListener("click", function () {
    initCropper(previewBanner);
    saveBanner.style.display = "block";
});

// Handle saving the cropped banner
saveBanner.addEventListener("click", function () {
    if (cropper) {
        const croppedCanvas = cropper.getCroppedCanvas({
            width: 1200,
            height: 300
        });

        // Get the data URL of the cropped image
        const imageDataUrl = croppedCanvas.toDataURL("image/png");

        // Update the banner image
        if (currentBanner) {
            currentBanner.src = imageDataUrl;
        }

        // Update the preview
        previewBanner.src = imageDataUrl;

        // Clean up
        cropper.destroy();
        cropper = null;
        saveBanner.style.display = "none";

        // Close the modal
        let modalElement = document.getElementById("bannerModal");
        let modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();

        // Add a hidden input to the form to submit the banner data
        let bannerDataInput = document.getElementById('bannerData');
        if (!bannerDataInput) {
            bannerDataInput = document.createElement('input');
            bannerDataInput.type = 'hidden';
            bannerDataInput.name = 'bannerData';
            bannerDataInput.id = 'bannerData';
            document.querySelector('form').appendChild(bannerDataInput);
        }
        bannerDataInput.value = imageDataUrl;
    }
});