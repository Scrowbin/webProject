<?php
// Include the controller and call the handler function
require_once __DIR__ . '/../controller/auth_controller.php';

// The handleProfile function will either redirect or return user data.
$user_data = handleProfile();

// If handleProfile didn't redirect and returned null (shouldn't happen with current logic, but for safety)
if (!$user_data) {
    // Handle appropriately, maybe redirect again or show a generic error
    die('Error loading profile data.');
}

// $profile_error variable is not set by the controller currently, remove or adapt if needed.

// --- The rest of the file is the View ---
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <title>User Profile - <?php echo htmlspecialchars($user_data['username']); ?></title>
</head>
<body>
    <?php // Include Navbar - It likely needs session data already started by controller ?>
    <?php // If navbar doesn't include db_config, make sure session is available ?>
    <?php // include 'includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 ">
                <ul class="list-group mb-2">
                    <li class="list-group-item fw-bold">Your account</li>
                    <li class="list-group-item active"><i class="bi bi-person"></i> Profile</li>
                    <li class="list-group-item"><i class="bi bi-bell"></i> Notifications</li>
                    <li class="list-group-item"><i class="bi bi-hand-thumbs-up"></i> Reactions Received</li>
                    <li class="list-group-item"><i class="bi bi-bookmark"></i> Bookmarks</li>
                </ul>
                <ul class="list-group mb-2">
                    <li class="list-group-item fw-bold">Settings</li>
                    <li class="list-group-item"><i class="bi bi-person-gear"></i> Account</li>
                    <li class="list-group-item"><i class="bi bi-shield-lock"></i> Privacy</li>
                    <li class="list-group-item"><i class="bi bi-sliders"></i> Preferences</li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item  fw-bold">
                        <a href="logout.php" class="text-danger text-decoration-none">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

             <?php // Action for profile update form needs to point to a controller route/handler ?>
            <form action="" class="container-fluid col-md-8">
                 <?php /* Removed profile_error display, handle errors from controller if needed
                 <?php if (isset($profile_error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($profile_error); ?></div>
                 <?php endif; ?>
                 */ ?>

                <div class="row mb-3">
                    <label for="username" class="col-sm-3 col-form-label text-end">Username:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label text-end">Email:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                    </div>
                </div>
                <?php // Logic for avatar/banner needs update in a real scenario ?>
                <div class="row mb-3">
                    <label for="avatar" class="col-sm-3 col-form-label text-end">Avatar:</label>
                    <div class="col-sm-9 d-flex align-items-center">
                        <img src="../IMG/whiteguy.png" alt="User Avatar" class="avatar me-3" id="currentAvatar">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            Change Avatar
                        </button>
                    </div>

                    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Change Avatar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="preview" src="../IMG/whiteguy.png" alt="Avatar Preview" class="avatar mb-3" >
                                    <br>
                                    <label class="btn btn-outline-secondary">
                                        Upload Image
                                        <input type="file" class="d-none" id="avatarInput" accept="image/*">
                                    </label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveAvatar">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="row mb-3">
                     <div class="col-sm-3 text-end">
                         Profile Banner:
                     </div>
                    <div class="col-sm-9 d-flex align-items-center">
                        <img src="../IMG/loginBG.png" alt="Profile Banner" class="banner me-3" id="currentBanner">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bannerModal">
                            Change Banner
                        </button>
                         <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerLabel" aria-hidden="true">
                             <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title">Change profile banner</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body text-center">
                                         <img id="preview2" src="../IMG/loginBG.png" alt="Banner Preview" class="banner mb-3" >
                                         <br>
                                         <label class="btn btn-outline-secondary">
                                             Upload Image
                                             <input type="file" class="d-none" id="bannerInput" accept="image/*">
                                         </label>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                         <button type="button" class="btn btn-primary" id="saveBanner">Save Changes</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-end">Date of Birth:</div>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="DOB">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-end">Location:</div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="location">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-end">Website:</div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  id="website">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-end">About you:</div>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="userText" rows="7" placeholder="Type here..."></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 text-end"></div>
                    <div class="col-sm-9">
                         <?php // Save button needs to submit the form to the controller ?>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/profile.js"></script>
</body>
</html>
