// import Cropper from "cropperjs";
// import "cropperjs/dist/cropper.min.css"; // Import the styles

// let cropper;
// const imageInput = document.getElementById("imageInput");
// const cropImage = document.getElementById("cropImage");
// const avatar = document.getElementById("avatar");
// const cropBtn = document.getElementById("cropBtn");

// imageInput.addEventListener("change", function (event) {
//     const file = event.target.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function (e) {
//             cropImage.src = e.target.result;

//             // Wait for the image to load before initializing Cropper.js
//             setTimeout(() => {
//                 if (cropper) {
//                     cropper.destroy(); // Remove any previous Cropper instance
//                 }
//                 cropper = new Cropper(cropImage, {
//                     aspectRatio: 1,
//                     viewMode: 2,
//                     autoCropArea: 1
//                 });

//                 // Show cropping modal
//                 const cropModal = new bootstrap.Modal(document.getElementById("cropModal"));
//                 cropModal.show();
//             }, 500);
//         };
//         reader.readAsDataURL(file);
//     }
// });

// cropBtn.addEventListener("click", function () {
//     const croppedCanvas = cropper.getCroppedCanvas({
//         width: 150,
//         height: 150
//     });
//     avatar.src = croppedCanvas.toDataURL("image/png");

//     // Close the cropping modal
//     const cropModal = bootstrap.Modal.getInstance(document.getElementById("cropModal"));
//     cropModal.hide();
// });

document.getElementById("avatarInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById("saveAvatar").addEventListener("click", function() {
    document.getElementById("avatar").src = document.getElementById("preview").src;
    
    // Close the modal using Bootstrap’s Modal API
    let modalElement = document.getElementById("avatarModal");
    let modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide(); // Properly hides the modal
});


document.getElementById("bannerInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("preview2").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById("saveBanner").addEventListener("click", function() {
    document.getElementById("banner").src = document.getElementById("preview2").src;
    
    // Close the modal using Bootstrap’s Modal API
    let modalElement = document.getElementById("bannerModal");
    let modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide(); // Properly hides the modal
});