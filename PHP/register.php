<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register MangaDax</title>
    <link rel="icon" href="favicon.ico">
    <!-- Đường dẫn CSS -->
    <link rel="stylesheet" href="/CSS/register.css">
    <!-- Script reCAPTCHA (nếu dùng Google reCAPTCHA v2) -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-pf-page">
        <!-- Header -->
        <div id="kc-header" class="login-pf-page-header">
            <div id="kc-header-wrapper">
                <a href="https://mangadex.org" rel="nofollow">
                    <div class="kc-logo-text">
                        <span id="md-logo"></span>
                        <span id="md-wordmark">MangaDax</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card Form -->
        <div class="card-pf">
            <header class="login-pf-header">
                <h1 id="kc-page-title">Register</h1>
            </header>

            <div id="kc-content">
                <div id="kc-content-wrapper">
                    <div id="kc-form">
                        <div id="kc-form-wrapper">
                            <form id="kc-form-login" action="#" method="post">
                                <!-- Trường Username -->
                                <div class="form-group">
                                    <label for="username" class="pf-c-form__label pf-c-form__label-text">
                                        Username <span class="required">*</span>
                                    </label>
                                    <input
                                        tabindex="1"
                                        id="username"
                                        class="pf-c-form-control"
                                        name="username"
                                        type="text"
                                        required
                                        autocomplete="off"
                                    >
                                </div>

                                <!-- Trường Password -->
                                <div class="form-group">
                                    <label for="password" class="pf-c-form__label pf-c-form__label-text">
                                        Password <span class="required">*</span>
                                    </label>
                                    <input
                                        tabindex="2"
                                        id="password"
                                        class="pf-c-form-control"
                                        name="password"
                                        type="password"
                                        required
                                        autocomplete="off"
                                    >
                                </div>

                                <!-- Trường Confirm Password -->
                                <div class="form-group">
                                    <label for="cf_password" class="pf-c-form__label pf-c-form__label-text">
                                        Confirm Password <span class="required">*</span>
                                    </label>
                                    <input
                                        tabindex="3"
                                        id="cf_password"
                                        class="pf-c-form-control"
                                        name="cf_password"
                                        type="password"
                                        required
                                        autocomplete="off"
                                    >
                                </div>

                                <!-- Trường Email -->
                                <div class="form-group">
                                    <label for="email" class="pf-c-form__label pf-c-form__label-text">
                                        Email <span class="required">*</span>
                                    </label>
                                    <input
                                        tabindex="4"
                                        id="email"
                                        class="pf-c-form-control"
                                        name="email"
                                        type="email"
                                        required
                                        autocomplete="off"
                                    >
                                </div>

                                <!-- reCAPTCHA -->
                                <div class="form-group recaptcha-group">
                                    <!--
                                        Nếu dùng Google reCAPTCHA v2 checkbox:
                                        Thay YOUR_SITE_KEY bằng site key của bạn
                                    -->
                                    <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
                                </div>

                                <!-- Nút Register -->
                                <div id="kc-form-buttons" class="form-group">
                                    <input
                                        tabindex="5"
                                        class="pf-c-button pf-m-primary pf-m-block btn-lg"
                                        name="register"
                                        id="kc-login"
                                        type="submit"
                                        value="Register"
                                    >
                                </div>

                                <!-- Link Back to Login -->
                                <div class="form-group back-to-login-container">
                                    <a class="back-to-login" href="/login">Back to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nếu muốn xử lý reCAPTCHA phía client, thêm JS ở đây (tuỳ chọn) -->
</body>
</html>
