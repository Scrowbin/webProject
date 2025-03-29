document.addEventListener("DOMContentLoaded", () => {
    const sideBar = document.getElementById("rightSidebar");
    const closeButton = document.getElementById("close-btn");
    const menuOpen = document.getElementById("menu-sticky");
    const pinButton = document.getElementById("pin-btn");
    const pinIcon = pinButton.querySelector("i");
    const topreadbar = document.getElementById("topReadBar");
    const toggleFit = document.getElementById("toggleFit");
    const images = document.querySelectorAll("#page-container img");
    const readMethod = document.getElementById("readMethod");
    const pageDropdown = document.getElementById("page-dropdown")
    let currentIndex= 0;
    let  isInLongStrip = true; // default is inlongstrip

    closeButton.addEventListener("click", toggleSidebar);
    pinButton.addEventListener("click", toggleSticky);

    if (!sideBar || !closeButton) {
        console.error("Sidebar or Close Button not found!");
        return;
    }

    function toggleSidebar() {
        console.log("Toggling sidebar...");
        sideBar.classList.toggle("close");
        if (pinIcon.classList.contains("bi-pin-angle")) {
        menuOpen.classList.toggle("hidden");
        }
    }

    function toggleSticky(){
        sideBar.classList.toggle("sticky");
        topreadbar.classList.toggle("hidden");
        if (pinIcon.classList.contains("bi-pin")) {
            pinIcon.classList.replace("bi-pin", "bi-pin-angle"); // Change to pin with cross
        } else {
            pinIcon.classList.replace("bi-pin-angle", "bi-pin"); // Change back to normal pin
        }

    }
    

    // 
    // fucked up and evil toggleFit
    // 
    
    function updateToggleButton() {
        if (images[0].classList.contains("img-fit-width")) {
            toggleFit.innerHTML = '<i class="bi bi-arrow-left-right"></i> Fit Width';
        } else if (images[0].classList.contains("img-fit-height")) {
            toggleFit.innerHTML = '<i class="bi bi-arrow-down-up"></i> Fit Height';
        } else if (images[0].classList.contains("img-fit-both")) {
            toggleFit.innerHTML = '<i class="bi bi-arrows-fullscreen"></i> Fit Both';
        } else {
            toggleFit.innerHTML = '<i class="bi bi-stop"></i> None';
        }
    }
    toggleFit.addEventListener("click", function () {
        images.forEach(img => {
            if (img.classList.contains("img-fit-width")) {
                img.classList.replace("img-fit-width", "img-fit-height");
            } else if (img.classList.contains("img-fit-height")) {
                img.classList.replace("img-fit-height", "img-fit-both");
            } else if (img.classList.contains("img-fit-both")) {
                img.classList.remove("img-fit-both");
            } else {
                img.classList.add("img-fit-width");
            }
        });
        updateToggleButton();
    });
    // 
    // readMode
    // 
   
    function toggleReadModeIcon(){

        if (isInLongStrip) {
            readMethod.innerHTML = "<i class='bi-file'></i>One Page";
        } else {
            readMethod.innerHTML = "<i class='bi-files'></i>Long strip";
        }
        
    }
    readMethod.addEventListener("click",()=>{
        if (isInLongStrip){ //switch to one page
            images.forEach((img, index) => {
                if (index!=currentIndex)
                    img.classList.add("hidden");
            });
            document.addEventListener()

        }
        else{//switchback to long page
            images.forEach((img) => {
                img.classList.remove("hidden");
            });
            images[currentIndex].scrollIntoView({ block: "start", behavior: "instant" });
        }

        toggleReadModeIcon();
        isInLongStrip = !isInLongStrip;
    });
    // functions to show the pages
    function showImage(goToPage){
        if (isInLongStrip){
            
            images[goToPage].scrollIntoView({ block: "start", behavior: "instant" });
        }else{
            images[currentIndex].classList.add("hidden");
            images[goToPage].classList.remove("hidden");
        }
        currentIndex= goToPage;
        pageDropdown.value = currentIndex +1;
    }

    // add each teleport to each image
    images.forEach((img, index) => {
        img.addEventListener("click", function(event) {
            const clickX = event.offsetX; // X coordinate of the click inside the image
            const imgWidth = img.clientWidth; // Image width
        
            if (clickX < imgWidth / 2) {
                if (index > 0) { // Ensure we don't go below 0
                    showImage(index - 1); 
                }
            } else {
                if (index < images.length - 1) { // Ensure it's not the last image
                    showImage(index + 1);
                }
            }    
        });
    });
    
    window.toggleSidebar = toggleSidebar; // ✅ Makes it globally accessible

});