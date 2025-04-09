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
    const progressBar = document.getElementById("progress-bar")
    const nextChapter = document.getElementById("next-chapter")
    let currentIndex= 0;
    let  isInLongStrip = true; // default is inlongstrip
    const barNumberLow = document.getElementById("p-bar-number-low");
    const barNumberHigh = document.getElementById("p-bar-number-high");

    closeButton.addEventListener("click", toggleSidebar);
    pinButton.addEventListener("click", toggleSticky);

    if (!sideBar || !closeButton) {
        console.error("Sidebar or Close Button not found!");
        return;
    }
    window.toggleSidebar = toggleSidebar; 
    function toggleSidebar() {
        sideBar.classList.toggle("close");
        if (pinIcon.classList.contains("bi-pin-angle")) {
        menuOpen.classList.toggle("hidden");
        }
        sideBar.addEventListener("transitionend", function updateWidth() {
            progressBar.style.width = getComputedStyle(progressBar.parentElement).width;
            sideBar.removeEventListener("transitionend", updateWidth); // Cleanup
        });
    }

    function toggleSticky(){
        sideBar.classList.toggle("sticky");
        topreadbar.classList.toggle("hidden");
        if (pinIcon.classList.contains("bi-pin")) {
            pinIcon.classList.replace("bi-pin", "bi-pin-angle"); // Change to pin with cross
        } else {
            pinIcon.classList.replace("bi-pin-angle", "bi-pin"); // Change back to normal pin
        }
        progressBar.style.width = getComputedStyle(progressBar.parentElement).width;

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

    readMethod.addEventListener("click", toggleObservers);

    readMethod.addEventListener("click",()=>{
        if (isInLongStrip){ //switch to one page
            images.forEach((img, index) => {
                if (index!=currentIndex)
                    img.classList.add("hidden");
            });
            
        }
        else{//switchback to long page
            images.forEach((img) => {
                img.classList.remove("hidden");
            });
            images[currentIndex].scrollIntoView({ block: "start", behavior: "instant" });

        }
        nextChapter.classList.toggle("hidden");
        toggleReadModeIcon();
        showImage(currentIndex);
        isInLongStrip = !isInLongStrip;
    });
    // functions to show the pages
    function showImage(goToPage){
        if (goToPage<0 ||goToPage+1>images.length) return;
        if (isInLongStrip){
            
        }else{
            images[currentIndex].classList.add("hidden");
            images[goToPage].classList.remove("hidden");
            
        }
        changeButtonsManual(goToPage);
        currentIndex= goToPage;
        images[goToPage].scrollIntoView({ block: "start", behavior: "instant" });
        barNumberLow.innerHTML = (currentIndex + 1).toString();
        pageDropdown.value = currentIndex +1;
    }
    //
    //  adding event listeners
    //  
    // add each teleport to each image
    images.forEach((img, index) => {
        img.addEventListener("click", function(event) {
            const clickX = event.offsetX; // X coordinate of the click inside the image
            const imgWidth = img.clientWidth; // Image width
        
            if (clickX < imgWidth / 2) {
                if (index > 0) { // Ensure we don't go below 0
                    showImage(currentIndex-1);
                }
            } else {
                if (index < images.length - 1) { // Ensure it's not the last image
                    showImage(currentIndex+1);
                }
            }    
        });
    });


    //add pagedropdown teleport
    pageDropdown.addEventListener("change",function(){
        showImage(pageDropdown.value-1);

    })

    //added keychange to switchImage
    document.addEventListener("keydown", (event) => {
        switch (event.key) {
            case "ArrowLeft":
                // Left pressed
                showImage(currentIndex-1);
                break;
            case "ArrowRight":
                showImage(currentIndex+1);
                break;
        }
    });
    

    //added showimage to the buttons next to dropdown
    document.getElementById("prevPageBtn").addEventListener("click",function(){
        showImage(currentIndex-1);
    })
    document.getElementById("nextPageBtn").addEventListener("click",function(){
        showImage(currentIndex+1);
    })

    //fix height of progressbar dynamically
    function getVisibleHeight(element) {
        let rect = element.getBoundingClientRect();
    
        // Calculate visible height
        const visibleHeight = Math.min(rect.bottom, window.innerHeight) - Math.max(rect.top, 0);
        return visibleHeight;
    }

    document.addEventListener("scroll",function(){
        if (isInLongStrip)
        {
            let height = Math.max(getVisibleHeight(nextChapter),0);
            progressBar.style.bottom = height+1 + "px";
        }
        else{
            progressBar.style.bottom =0;
        }
    })

   

    // added progress setting
        progressSetting = document.getElementById("progress-setting");
        progressSetting.addEventListener("click",function(){
            if(progressSetting.innerHTML == '<i class="bi bi-list"></i> Normal Progress')
                progressSetting.innerHTML = '<i class="bi bi-ban"></i>Progress bar hidden';
            
            else progressSetting.innerHTML = '<i class="bi bi-list"></i> Normal Progress'
            if (progressBar.style.display == "none")
                progressBar.style.display = "flex";
            else (progressBar.style.display = "none")

        });
    
    // show progress bar when mouse is close enough 
    
    let isExpanded = false;
    let isAtBottom = false;
    document.addEventListener("mousemove", (event) => {
        const triggerHeight = window.innerHeight - 100; // Adjust threshold
    
        // Check if mouse is near the bottom
        if (event.clientY > triggerHeight && !isExpanded && !isAtBottom) {
            expandProgressBar();
            isExpanded = true;
        } 
        // Collapse only if the user isn't at the bottom
        else if (event.clientY <= triggerHeight && isExpanded && !isAtBottom) {
            collapseProgressBar();
            isExpanded = false;
        }
    });
    
    function expandProgressBar() {
        progressBar.classList.add("expanded");
        barNumberLow.classList.remove("hidden");
        barNumberHigh.classList.remove("hidden");
    }
    
    // Helper function to collapse the progress bar
    function collapseProgressBar() {
        progressBar.classList.remove("expanded");
        barNumberLow.classList.add("hidden");
        barNumberHigh.classList.add("hidden");
    }

    //function which detects scroll postion
    // progressBarButton
    let observersActive = true;
    const imageObservers = [];
    const bottomButtons = [];
    let originalColor = "#e0e4e6";
    let litUpColor = '#ff6740';
    bottomButtons.push(...Array.from(document.querySelectorAll('.progressBarButton')));
    
    //helper function to manually change the buttons colors 
    function changeButtonsManual (index) {
        if (index >= currentIndex) {
            for (let i = 0; i <= index; i++) {
                bottomButtons[i].style.backgroundColor = litUpColor;
            }
        } else if (index < currentIndex) {
            for (let i = images.length-1; i > index; i--) { // Corrected loop direction
                bottomButtons[i].style.backgroundColor = originalColor;
            }
        }

    }
    // Move to the new image
    bottomButtons.forEach((button, index) => {
        button.addEventListener("click", function () {
            showImage(index);
        });
    });
   
    // add observers to each image to make the progress bar 
    
    images.forEach((img, index) => {
        const observer = new IntersectionObserver((entries) => {
          if (!observersActive) return;
          
          const target = bottomButtons[index];
          if (!target) return;
          
          entries.forEach(entry => {
            const isVisible = entry.isIntersecting;
            const isPast = entry.boundingClientRect.top < 0 && !isVisible;
            
            // if (isVisible || isPast) {
            if (isVisible || isPast) {
              // Same color for both entering and passing
              for (i = 0; i<=index; i++){
                bottomButtons[i].style.backgroundColor = litUpColor;
                bottomButtons[i].style.color = "white";
              }
              if (currentIndex<index){
                pageDropdown.value = index +1;
                
                currentIndex = index;
                barNumberLow.innerHTML = (currentIndex + 1).toString();

              }
            } else {
              // Reset when neither in view nor past
              
              if (index<=currentIndex){
                pageDropdown.value = index;
                currentIndex = index-1;
                barNumberLow.innerHTML = (currentIndex + 1).toString();
              }
              for (i = images.length-1; i>=index; i--){
                bottomButtons[i].style.backgroundColor = originalColor;
                bottomButtons[i].style.color = 'black';
                }
            }
          });
        });
    
        observer.observe(img);
        imageObservers.push(observer);
      });
    function toggleObservers() {
        observersActive = !observersActive;
        
        
        if (observersActive) {
          // Restore proper colors based on current scroll position
         images.forEach((img, index) => {
            const rect = img.getBoundingClientRect();
            const target = bottomButtons[index];
            if (!target) return;
            
            if (rect.top < window.innerHeight * 0.7 && rect.bottom > 0) {
              target.style.backgroundColor = litUpColor;
            } else {
              target.style.backgroundColor = originalColor;
            }
          });
        } else {
          // Reset all to original colors
            bottomButtons.forEach((el) => {
            el.style.backgroundColor = originalColor;
          });
        }
    }
});