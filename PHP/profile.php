<?php
// Expects $user_data, $profile_errors, $profile_update_message from controller.
if (!isset($user_data)) {
    die('Error: Profile data not available.');
}
$profile_errors ??= [];
$profile_update_message ??= null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/profile.css">
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/wx4008qjjx7niu643lrzyglnb9byz72numg3c3jss5gk1noi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <title>Profile Settings - <?php echo htmlspecialchars($user_data['username']); ?></title>
</head>
<body class="bg-dark">
    <?php
    // Define path prefix for navbar
    $pathPrefix = '../';
    include 'includes/navbar_minimal.php';
    include 'includes/sidebar.php';
    ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <ul class="list-group mb-2 sticky-top profile-nav">
                    <li class="list-group-item fw-bold">Your account</li>
                    <li class="list-group-item"><a href="../controller/auth_controller.php?action=user_profile" class="text-decoration-none text-dark"><i class="bi bi-person"></i> Profile</a></li>
                    <li class="list-group-item active"><i class="bi bi-gear"></i> Profile Settings</li>
                <ul class="list-group mb-2 sticky-top profile-nav">
                    <li class="list-group-item fw-bold">Settings</li>
                    <li class="list-group-item"><i class="bi bi-person-gear"></i> Profile detail</li>
                </ul>
                <ul class="list-group sticky-top profile-nav">
                    <li class="list-group-item fw-bold">
                        <a href="../controller/auth_controller.php?action=logout" class="text-danger text-decoration-none">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10">
                <form action="../controller/auth_controller.php?action=profile" method="POST" class="profile-form">
                     <?php if ($profile_update_message): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($profile_update_message); ?></div>
                     <?php endif; ?>

                     <?php if (!empty($profile_errors)): ?>
                        <div class="alert alert-danger">
                            <strong>Errors updating profile:</strong><br>
                            <?php foreach ($profile_errors as $field => $error): ?>
                                - <?php echo htmlspecialchars($field); ?>: <?php echo htmlspecialchars($error); ?><br>
                            <?php endforeach; ?>
                        </div>
                     <?php endif; ?>

                    <div class="bg-dark text-white p-4 rounded">
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Username:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control bg-dark text-white border-secondary" id="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Email options:</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="receiveEmails" name="receiveEmails">
                                    <label class="form-check-label" for="receiveEmails">
                                        Receive news and update emails
                                    </label>
                                </div>
                                <div class="text-muted small mt-1">
                                    You may find additional email options under <a href="#" class="text-info">Preferences</a>.
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="avatar" class="col-sm-3 col-form-label">Avatar:</label>
                            <div class="col-sm-9">
                                <div class="avatar-container mb-2">
                                    <div class="avatar-wrapper bg-warning text-center d-inline-block" style="width: 100px; height: 100px; line-height: 100px; font-size: 48px; color: white;" id="avatar">
                                        <?php if (!empty($user_data['Avatar']) && $user_data['Avatar'] !== 'avatar_default.png'): ?>
                                            <img src="../IMG/avatars/<?php echo htmlspecialchars($user_data['Avatar']); ?>" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else: ?>
                                            <?php echo strtoupper(substr($user_data['username'], 0, 1)); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted">Click the image to change your avatar.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Profile banner:</label>
                            <div class="col-sm-9">
                                <div class="banner-container mb-2">
                                    <?php if (!empty($user_data['banner'])): ?>
                                        <img src="../IMG/banners/<?php echo htmlspecialchars($user_data['banner']); ?>" alt="Profile Banner" class="img-fluid rounded" style="max-height: 100px; width: 100%;" id="currentBanner">
                                    <?php else: ?>
                                        <img src="../IMG/loginBG.png" alt="Profile Banner" class="img-fluid rounded" style="max-height: 100px; width: 100%;" id="currentBanner">
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-danger">Edit profile banner</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="DOB" class="col-sm-3 col-form-label">Date of birth:</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-auto">
                                        <?php
                                            // Parse the date of birth if it exists
                                            $dobDay = '';
                                            $dobMonth = '';
                                            $dobYear = '';
                                            if (!empty($user_data['dob'])) {
                                                $dobDate = new DateTime($user_data['dob']);
                                                $dobDay = $dobDate->format('j');
                                                $dobMonth = $dobDate->format('n');
                                                $dobYear = $dobDate->format('Y');
                                            }
                                        ?>
                                        <select class="form-select bg-dark text-white border-secondary" name="dobDay">
                                            <option value="">Day</option>
                                            <?php for($i=1; $i<=31; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php echo ($dobDay == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select bg-dark text-white border-secondary" name="dobMonth">
                                            <option value="">Month</option>
                                            <option value="1" <?php echo ($dobMonth == 1) ? 'selected' : ''; ?>>January</option>
                                            <option value="2" <?php echo ($dobMonth == 2) ? 'selected' : ''; ?>>February</option>
                                            <option value="3" <?php echo ($dobMonth == 3) ? 'selected' : ''; ?>>March</option>
                                            <option value="4" <?php echo ($dobMonth == 4) ? 'selected' : ''; ?>>April</option>
                                            <option value="5" <?php echo ($dobMonth == 5) ? 'selected' : ''; ?>>May</option>
                                            <option value="6" <?php echo ($dobMonth == 6) ? 'selected' : ''; ?>>June</option>
                                            <option value="7" <?php echo ($dobMonth == 7) ? 'selected' : ''; ?>>July</option>
                                            <option value="8" <?php echo ($dobMonth == 8) ? 'selected' : ''; ?>>August</option>
                                            <option value="9" <?php echo ($dobMonth == 9) ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?php echo ($dobMonth == 10) ? 'selected' : ''; ?>>October</option>
                                            <option value="11" <?php echo ($dobMonth == 11) ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?php echo ($dobMonth == 12) ? 'selected' : ''; ?>>December</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select bg-dark text-white border-secondary" name="dobYear">
                                            <option value="">Year</option>
                                            <?php for($i=date('Y')-100; $i<=date('Y'); $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php echo ($dobYear == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showDobDay" name="showDobDay" checked>
                                        <label class="form-check-label" for="showDobDay">
                                            Show day and month of birth
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showDobYear" name="showDobYear">
                                        <label class="form-check-label" for="showDobYear">
                                            Show year of birth
                                        </label>
                                        <div class="text-muted small">This will allow people to see your age.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="location" class="col-sm-3 col-form-label">Location:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control bg-dark text-white border-secondary" id="location" name="location" value="<?php echo htmlspecialchars($user_data['location'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="userText" class="col-sm-3 col-form-label">About you:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control bg-dark text-white border-secondary" id="userText" name="userText" rows="7"><?php echo htmlspecialchars($user_data['About'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button class="btn btn-warning px-4" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="avatarModalLabel">Change Avatar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="cropper-container">
                        <?php if (!empty($user_data['Avatar']) && $user_data['Avatar'] !== 'avatar_default.png'): ?>
                            <img id="previewAvatar" src="../IMG/avatars/<?php echo htmlspecialchars($user_data['Avatar']); ?>" class="avatar mb-3">
                        <?php else: ?>
                            <img id="previewAvatar" src="../IMG/avatar_default.png" class="avatar mb-3">
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-row flex-wrap align-items-center justify-content-center gap-3 mt-3">
                        <button type="button" class="btn btn-warning" id="cropAvatarBtn">Crop</button>
                        <label class="btn btn-outline-light">
                            Upload Image
                            <input type="file" class="d-none" id="avatarInput" accept="image/*">
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="saveAvatar" style="display: none;">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Modal -->
    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="bannerModalLabel">Change Profile Banner</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cropper-container1">
                        <?php if (!empty($user_data['banner'])): ?>
                            <img id="previewBanner" src="../IMG/banners/<?php echo htmlspecialchars($user_data['banner']); ?>" class="img-fluid mb-3">
                        <?php else: ?>
                            <img id="previewBanner" src="../IMG/loginBG.png" class="img-fluid mb-3">
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-row flex-wrap align-items-center justify-content-center gap-3 mt-3">
                        <button type="button" class="btn btn-warning" id="cropBannerBtn">Crop</button>
                        <label class="btn btn-outline-light">
                            Upload Image
                            <input type="file" class="d-none" id="bannerInput" accept="image/*">
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="saveBanner" style="display: none;">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/profile.js"></script>
    <script src="../JS/navbar.js"></script>
    <script src="../JS/sidebar.js"></script>

    <script>
        // Initialize TinyMCE for the About You section
        tinymce.init({
            selector: '#userText',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'bold italic underline | link image | alignleft aligncenter alignright | bullist numlist | emoticons charmap | removeformat',
            menubar: false,
            height: 250,
            skin: 'oxide-dark',
            content_css: 'dark',
            promotion: false,
            branding: false,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save(); // Save content to textarea
                });
            }
        });

        // Handle avatar click to open modal
        document.querySelector('.avatar-wrapper').addEventListener('click', function() {
            const avatarModal = new bootstrap.Modal(document.getElementById('avatarModal'));
            avatarModal.show();
        });

        // Handle banner edit button click
        document.querySelector('.btn-outline-danger').addEventListener('click', function() {
            const bannerModal = new bootstrap.Modal(document.getElementById('bannerModal'));
            bannerModal.show();
        });
    </script>
</body>
</html>
