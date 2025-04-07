const avatarInput = document.getElementById("avatarInput");
const previewAvatar = document.getElementById("previewAvatar");
const avatar = document.getElementById("avatar");
const saveAvatar = document.getElementById("saveAvatar");
const avatarModal = document.getElementById("avatarModal");
const cropAvatarBtn = document.getElementById("cropAvatarBtn");
const bannerInput = document.getElementById("bannerInput");
const previewBanner = document.getElementById("previewBanner");
const banner = document.getElementById("banner");
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

// Initialize avatar preview with current avatar
previewAvatar.src = avatar.src;

// Initialize banner preview with current banner
previewBanner.src = banner.src;

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
        avatar.src = croppedCanvas.toDataURL("image/png");
        previewAvatar.src = croppedCanvas.toDataURL("image/png"); // Update preview
        cropper.destroy();
        cropper = null;
        saveAvatar.style.display = "none";
        let modalElement = document.getElementById("avatarModal");
        let modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();
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
        const croppedCanvas = cropper.getCroppedCanvas();
        banner.src = croppedCanvas.toDataURL("image/png");
        previewBanner.src = croppedCanvas.toDataURL("image/png"); // Update preview
        cropper.destroy();
        cropper = null;
        saveBanner.style.display = "none";
        let modalElement = document.getElementById("bannerModal");
        let modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();
    }
});