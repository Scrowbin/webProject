// Avatar elements
const avatarInput = document.getElementById("avatarInput");
const previewAvatar = document.getElementById("previewAvatar");
const avatarWrapper = document.querySelector(".avatar-wrapper");
const saveAvatar = document.getElementById("saveAvatar");
const deleteAvatar = document.getElementById("deleteAvatar");
const avatarModal = document.getElementById("avatarModal");
const customAvatarOption = document.getElementById("customAvatarOption");
const avatarPreviewContainer = document.getElementById("avatar-preview-container");

// Banner elements
const bannerInput = document.getElementById("bannerInput");
const previewBanner = document.getElementById("previewBanner");
const currentBanner = document.getElementById("currentBanner");
const saveBanner = document.getElementById("saveBanner");
const deleteBanner = document.getElementById("deleteBanner");
const bannerModal = document.getElementById("bannerModal");
const bannerPreviewContainer = document.getElementById("banner-preview-container");

let cropper;
let isDragging = false;
let startX, startY, startLeft, startTop;

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

// Setup draggable avatar functionality
function setupDraggableAvatar() {
    const avatar = document.querySelector('.draggable-avatar');
    if (!avatar) return;

    const container = avatarPreviewContainer;
    const containerWidth = container.offsetWidth;

    // Wait for image to load to get its dimensions
    avatar.onload = function() {
        // Đặt vị trí ban đầu cho ảnh
        avatar.style.left = '0px';
        avatar.style.top = '0px';

        // Tính toán tỷ lệ khung hình
        const imageRatio = avatar.naturalWidth / avatar.naturalHeight;
        const containerRatio = containerWidth / containerWidth; // Container là hình vuông

        // Kiểm tra xem ảnh có cần kéo theo chiều ngang không
        if (imageRatio > containerRatio) {
            // Ảnh rộng hơn so với tỷ lệ container, có thể kéo ngang
            avatar.classList.add('draggable-avatar');
            avatar.style.cursor = 'move';
        } else {
            // Ảnh cao hơn hoặc vừa khít, không cần kéo
            avatar.classList.remove('draggable-avatar');
            avatar.style.cursor = 'default';

            // Căn giữa ảnh theo chiều ngang
            const scaledWidth = containerWidth * imageRatio;
            avatar.style.left = ((containerWidth - scaledWidth) / 2) + 'px';
        }
    };

    // Mouse down event
    avatar.addEventListener('mousedown', function(e) {
        // Chỉ cho phép kéo nếu ảnh có tỷ lệ rộng hơn container
        const imageRatio = avatar.naturalWidth / avatar.naturalHeight;
        const containerRatio = containerWidth / containerWidth;

        if (imageRatio <= containerRatio) {
            return;
        }

        isDragging = true;
        startX = e.clientX;
        startLeft = parseInt(avatar.style.left || 0);

        // Prevent default behavior to avoid text selection
        e.preventDefault();
    });

    // Mouse move event
    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;

        const dx = e.clientX - startX;

        // Calculate new position (chỉ theo chiều ngang)
        let newLeft = startLeft + dx;

        // Tính toán giới hạn kéo
        const imageRatio = avatar.naturalWidth / avatar.naturalHeight;
        const scaledWidth = containerWidth * imageRatio;
        const minLeft = containerWidth - scaledWidth;

        // Giới hạn kéo
        if (newLeft > 0) newLeft = 0;
        if (newLeft < minLeft) newLeft = minLeft;

        // Chỉ áp dụng vị trí mới theo chiều ngang
        avatar.style.left = newLeft + 'px';
    });

    // Mouse up event
    document.addEventListener('mouseup', function() {
        isDragging = false;
    });
}

// Initialize draggable avatar when modal is shown
avatarModal.addEventListener('shown.bs.modal', function() {
    setupDraggableAvatar();
});

// Handle avatar image selection
avatarInput.addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Remove old avatar if exists
            const oldAvatar = avatarPreviewContainer.querySelector('img');
            if (oldAvatar) {
                oldAvatar.remove();
            }

            // Create new avatar image
            const newAvatar = document.createElement('img');
            newAvatar.src = e.target.result;
            newAvatar.className = 'draggable-avatar';

            // Add to container
            avatarPreviewContainer.appendChild(newAvatar);

            // Setup draggable functionality
            setupDraggableAvatar();
        };
        reader.readAsDataURL(file);
    }
});

// Handle saving the avatar
saveAvatar.addEventListener("click", function() {
    const avatar = avatarPreviewContainer.querySelector('img');
    if (!avatar) return;

    // Create a canvas to capture the visible portion of the avatar
    const canvas = document.createElement('canvas');
    const container = avatarPreviewContainer;
    const containerWidth = container.offsetWidth;
    const containerHeight = container.offsetHeight;

    canvas.width = containerWidth;
    canvas.height = containerHeight;

    const ctx = canvas.getContext('2d');

    // Get the position of the avatar
    const left = parseInt(avatar.style.left || 0);
    const top = parseInt(avatar.style.top || 0);

    // Tính toán tỷ lệ khung hình
    const imageRatio = avatar.naturalWidth / avatar.naturalHeight;

    if (imageRatio > 1) {
        // Ảnh ngang, cần cắt theo chiều ngang
        const sourceWidth = avatar.naturalHeight;
        const sourceHeight = avatar.naturalHeight;
        const sourceX = -left * (avatar.naturalWidth / (containerWidth * imageRatio));

        // Vẽ ảnh lên canvas
        ctx.drawImage(
            avatar,
            sourceX, 0, // Vị trí nguồn
            sourceWidth, sourceHeight, // Kích thước nguồn
            0, 0, // Vị trí đích
            containerWidth, containerHeight // Kích thước đích
        );
    } else {
        // Ảnh dọc hoặc vuông, chỉ cần căn giữa
        const sourceWidth = avatar.naturalWidth;
        const sourceHeight = avatar.naturalWidth;
        const sourceY = (avatar.naturalHeight - sourceHeight) / 2;

        // Vẽ ảnh lên canvas
        ctx.drawImage(
            avatar,
            0, sourceY, // Vị trí nguồn
            sourceWidth, sourceHeight, // Kích thước nguồn
            0, 0, // Vị trí đích
            containerWidth, containerHeight // Kích thước đích
        );
    }

    // Get the data URL
    const imageDataUrl = canvas.toDataURL('image/png');

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

    // Close the modal
    let modalInstance = bootstrap.Modal.getInstance(avatarModal);
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
});

// Handle deleting the avatar
deleteAvatar.addEventListener("click", function() {
    // Xóa ảnh trong preview container
    const oldAvatar = avatarPreviewContainer.querySelector('img');
    if (oldAvatar) {
        oldAvatar.remove();
    }

    // Set avatar to default (first letter of username)
    if (avatarWrapper) {
        const username = avatarWrapper.getAttribute('data-username') || 'U';
        const firstLetter = username.charAt(0).toUpperCase();

        // Clear the avatar wrapper and show the first letter
        avatarWrapper.innerHTML = firstLetter;
        avatarWrapper.style.fontSize = '48px';
        avatarWrapper.style.lineHeight = '100px';

        // Thêm class để hiển thị màu nền
        avatarWrapper.classList.add('default-avatar');
    }

    // Add a hidden input to indicate avatar deletion
    let deleteAvatarInput = document.getElementById('deleteAvatarInput');
    if (!deleteAvatarInput) {
        deleteAvatarInput = document.createElement('input');
        deleteAvatarInput.type = 'hidden';
        deleteAvatarInput.name = 'deleteAvatar';
        deleteAvatarInput.id = 'deleteAvatarInput';
        deleteAvatarInput.value = '1';
        document.querySelector('form').appendChild(deleteAvatarInput);
    } else {
        deleteAvatarInput.value = '1';
    }

    // Hiển thị thông báo
    const messageElement = document.createElement('div');
    messageElement.className = 'alert alert-success mt-2';
    messageElement.textContent = 'Avatar will be reset to default after saving';
    avatarPreviewContainer.appendChild(messageElement);

    // Ẩn nút Delete sau khi đã xóa
    deleteAvatar.style.display = 'none';
});

// Setup draggable banner functionality
function setupDraggableBanner() {
    const banner = document.querySelector('.draggable-banner');
    if (!banner) return;

    const container = bannerPreviewContainer;
    const containerHeight = container.offsetHeight;

    // Wait for image to load to get its dimensions
    banner.onload = function() {
        // Đặt vị trí ban đầu cho ảnh
        banner.style.left = '0px';
        banner.style.top = '0px';

        // Tính toán tỷ lệ khung hình
        const imageRatio = banner.naturalWidth / banner.naturalHeight;
        const containerRatio = container.offsetWidth / containerHeight;

        // Kiểm tra xem ảnh có cần kéo theo chiều dọc không
        if (imageRatio < containerRatio) {
            // Ảnh cao hơn so với tỷ lệ container, có thể kéo dọc
            banner.classList.add('draggable-banner');
            banner.style.cursor = 'move';
        } else {
            // Ảnh rộng hơn hoặc vừa khít, không cần kéo
            banner.classList.remove('draggable-banner');
            banner.style.cursor = 'default';

            // Căn giữa ảnh theo chiều dọc
            const scaledHeight = container.offsetWidth / imageRatio;
            banner.style.top = ((containerHeight - scaledHeight) / 2) + 'px';
        }
    };

    // Mouse down event
    banner.addEventListener('mousedown', function(e) {
        // Chỉ cho phép kéo nếu ảnh có tỷ lệ cao hơn container
        const imageRatio = banner.naturalWidth / banner.naturalHeight;
        const containerRatio = container.offsetWidth / containerHeight;

        if (imageRatio >= containerRatio) {
            return;
        }

        isDragging = true;
        startY = e.clientY;
        startTop = parseInt(banner.style.top || 0);

        // Prevent default behavior to avoid text selection
        e.preventDefault();
    });

    // Mouse move event
    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;

        const dy = e.clientY - startY;

        // Calculate new position (chỉ theo chiều dọc)
        let newTop = startTop + dy;

        // Tính toán giới hạn kéo
        const imageRatio = banner.naturalWidth / banner.naturalHeight;
        const scaledHeight = container.offsetWidth / imageRatio;
        const minTop = containerHeight - scaledHeight;

        // Giới hạn kéo
        if (newTop > 0) newTop = 0;
        if (newTop < minTop) newTop = minTop;

        // Chỉ áp dụng vị trí mới theo chiều dọc
        banner.style.top = newTop + 'px';
    });

    // Mouse up event
    document.addEventListener('mouseup', function() {
        isDragging = false;
    });
}

// Initialize draggable banner when modal is shown
bannerModal.addEventListener('shown.bs.modal', function() {
    setupDraggableBanner();
});

// Handle banner image selection
bannerInput.addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Remove old banner if exists
            const oldBanner = bannerPreviewContainer.querySelector('img');
            if (oldBanner) {
                oldBanner.remove();
            }

            // Create new banner image
            const newBanner = document.createElement('img');
            newBanner.src = e.target.result;
            newBanner.id = 'previewBanner';
            newBanner.className = 'draggable-banner';

            // Add to container
            bannerPreviewContainer.appendChild(newBanner);

            // Setup draggable functionality
            setupDraggableBanner();
        };
        reader.readAsDataURL(file);
    }
});

// Handle saving the banner
saveBanner.addEventListener("click", function () {
    const banner = bannerPreviewContainer.querySelector('img');
    if (!banner) return;

    // Create a canvas to capture the visible portion of the banner
    const canvas = document.createElement('canvas');
    const container = bannerPreviewContainer;
    const containerWidth = container.offsetWidth;
    const containerHeight = container.offsetHeight;

    canvas.width = containerWidth;
    canvas.height = containerHeight;

    const ctx = canvas.getContext('2d');

    // Get the position of the banner
    const left = parseInt(banner.style.left || 0);
    const top = parseInt(banner.style.top || 0);

    // Tính toán tỷ lệ và kích thước thực tế của ảnh trong container
    const scale = banner.offsetWidth / banner.naturalWidth;
    const visibleWidth = containerWidth;
    const visibleHeight = containerHeight;

    // Tính toán vùng nguồn từ ảnh gốc
    const sourceX = -left / scale;
    const sourceY = -top / scale;
    const sourceWidth = visibleWidth / scale;
    const sourceHeight = visibleHeight / scale;

    // Vẽ phần ảnh đã crop lên canvas
    ctx.drawImage(
        banner,
        sourceX, sourceY, // Vị trí nguồn (phần ảnh hiển thị trong container)
        sourceWidth, sourceHeight, // Kích thước nguồn
        0, 0, // Vị trí đích (bắt đầu từ góc trên bên trái của canvas)
        containerWidth, containerHeight // Kích thước đích (kích thước của canvas)
    );

    // Get the data URL
    const imageDataUrl = canvas.toDataURL('image/png');

    // Update the banner image if it exists on the page
    const pageBanner = document.querySelector('.banner-container img');
    if (pageBanner) {
        pageBanner.src = imageDataUrl;

        // Đảm bảo ảnh hiển thị đúng tỷ lệ, không bị bóp méo
        pageBanner.style.width = '100%';
        pageBanner.style.height = '100%';
        pageBanner.style.objectFit = 'cover';
        pageBanner.style.objectPosition = 'center';
        pageBanner.style.display = 'block';
    }

    // Close the modal
    let modalInstance = bootstrap.Modal.getInstance(bannerModal);
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
});

// Handle deleting the banner
deleteBanner.addEventListener("click", function() {
    // Xóa ảnh trong preview container
    const oldBanner = bannerPreviewContainer.querySelector('img');
    if (oldBanner) {
        oldBanner.remove();
    }

    // Tạo banner mặc định
    const defaultBanner = document.createElement('img');
    defaultBanner.src = '../IMG/loginBG.png';
    defaultBanner.id = 'previewBanner';
    defaultBanner.className = 'draggable-banner';
    bannerPreviewContainer.appendChild(defaultBanner);

    // Update the banner image if it exists on the page
    const pageBanner = document.querySelector('.banner-container img');
    if (pageBanner) {
        pageBanner.src = '../IMG/loginBG.png';
        pageBanner.style.width = '100%';
        pageBanner.style.height = '100%';
        pageBanner.style.objectFit = 'cover';
        pageBanner.style.objectPosition = 'center';
        pageBanner.style.display = 'block';
    }

    // Add a hidden input to the form to submit the delete banner request
    let deleteBannerInput = document.getElementById('deleteBannerFlag');
    if (!deleteBannerInput) {
        deleteBannerInput = document.createElement('input');
        deleteBannerInput.type = 'hidden';
        deleteBannerInput.name = 'deleteBanner';
        deleteBannerInput.id = 'deleteBannerFlag';
        deleteBannerInput.value = '1';
        document.querySelector('form').appendChild(deleteBannerInput);
    }
});