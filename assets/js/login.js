function showError(message) {
    let error = document.getElementById('username-error');
    if (message == null || message == undefined) {
        error.classList.add('d-none');
    } else {
        error.classList.remove('d-none');
        error.innerHTML = message;
    }
}

function validInput() {
    let usernameField = document.getElementById("username");
    let passwordField = document.getElementById("password");
    let errorMessage  = document.getElementById("username-error");

    errorMessage.classList.remove("active");
    usernameField.classList.remove("input-error");
    passwordField.classList.remove("input-error");
    
    if (usernameField.value.trim() === "") {
        errorMessage.textContent = "Invalid username or password";
        errorMessage.classList.add("active");
        usernameField.classList.add("input-error");
        passwordField.classList.add("input-error");
        return false;
    }

    if (!usernameField.value.includes('@')) {
        errorMessage.textContent = "Invalid username or password";
        errorMessage.classList.add("active");
        usernameField.classList.add("input-error");
        passwordField.classList.add("input-error");
        return false;
    }

    if (passwordField.value.trim() === "") {
        errorMessage.textContent = "Invalid username or password";
        errorMessage.classList.add("active");
        usernameField.classList.add("input-error");
        passwordField.classList.add("input-error");
        return false;
    }
    
    errorMessage.classList.remove("active");
    return true;
}
