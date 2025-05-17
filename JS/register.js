function validInput() {
    const username = document.getElementById('username');
    const usernameErr = document.getElementById('username-error');

    const password = document.getElementById('password');
    const passwordErr = document.getElementById('pwd-error');

    const cfPassword = document.getElementById('cf_password');
    const cfPasswordErr = document.getElementById('cfpwd-error');

    const email = document.getElementById('email');
    const emailErr = document.getElementById('email-error');

    let isValid = true;

    function hideError(input, errMsg) {
        errMsg.classList.remove('active');
        input.classList.remove('input-error');
    }

    hideError(username, usernameErr);
    hideError(password, passwordErr);
    hideError(cfPassword, cfPasswordErr);
    hideError(email, emailErr);

    function showError(input, errMsg) {
        errMsg.classList.add('active');
        input.classList.add('input-error');
        isValid = false;
    }

    // Validate username
    if (username.value.trim() === '') {
        usernameErr.textContent = 'Please specify user name.';
        showError(username, usernameErr);
    } else if (username.value.length > 24) {
        usernameErr.textContent = 'Username cannot exceed 24 characters.';
        showError(username, usernameErr);
    } else if (!/^[a-zA-Z0-9_]+$/.test(username.value)) {
        usernameErr.textContent = 'Username can only contain letters, numbers, and underscores.';
        showError(username, usernameErr);
    }

    // Validate password
    if (password.value.trim() === '') {
        passwordErr.textContent = 'Please specify password.';
        showError(password, passwordErr);
    } else if (password.value.length < 8 || password.value.length > 24) {
        passwordErr.textContent = 'Password must be between 8 and 24 characters.';
        showError(password, passwordErr);
    } else if (!/[A-Za-z]/.test(password.value) || !/[0-9]/.test(password.value) || !/[@$!%*?&]/.test(password.value)) {
        passwordErr.textContent = 'Password must contain at least one letter, one number, and one special character (@$!%*?&).';
        showError(password, passwordErr);
    }

    // Validate confirm password
    if (cfPassword.value.trim() === '') {
        cfPasswordErr.textContent = 'Please confirm your password.';
        showError(cfPassword, cfPasswordErr);
    } else if (cfPassword.value !== password.value) {
        cfPasswordErr.textContent = 'Passwords do not match.';
        showError(cfPassword, cfPasswordErr);
    }

    // Validate email
    if (email.value.trim() === '') {
        emailErr.textContent = 'Please specify email.';
        showError(email, emailErr);
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        emailErr.textContent = 'Invalid email format.';
        showError(email, emailErr);
    }

    return isValid;
}
