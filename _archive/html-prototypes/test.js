const image = document.getElementById("image");
const cropper = new Cropper(image, {
    aspect:0,
});

document.querySelector('#btn-crop').addEventListener('click',function(){
    if (!cropper) return; // Ensure cropper is defined

    var croppedImage = cropper.getCroppedCanvas().toDataURL("image/png");
    document.getElementById('output').src = croppedImage;
    document.querySelector('.cropped-container').style.display = 'flex';
});