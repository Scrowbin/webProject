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

    if (username.value.trim() === '') {
        showError(username, usernameErr);
    }

    if (password.value.trim() === '') {
        showError(password, passwordErr);
    }

    else if (cfPassword.value !== password.value) {
        cfPasswordErr.textContent = 'Passwords do not match.';
        showError(cfPassword, cfPasswordErr);
    }

    if (email.value.trim() === '') {
        showError(email, emailErr);
    }

    return isValid;
}
