<?php
// Expects $user_data, $profile_errors, $profile_update_message from controller.
if (!isset($user_data)) {
    die('Error: Profile data not available.'); 
}
$profile_errors = $profile_errors ?? [];
$profile_update_message = $profile_update_message ?? null;
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
    <?php // include 'includes/navbar.php'; // Navbar is typically included by the main layout/controller now ?>

    <div class="container-fluid mt-3"> 
        <div class="row">
            <div class="col-md-3 col-lg-2"> 
                <ul class="list-group mb-2 sticky-top profile-nav"> 
                    <li class="list-group-item fw-bold">Your account</li>
                    <li class="list-group-item active"><i class="bi bi-person"></i> Profile</li>
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
                    
                    <div class="row mb-3">
                        <label for="avatar" class="col-sm-3 col-form-label text-end">Avatar:</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <img src="../IMG/avatar_default.png" alt="User Avatar" class="avatar me-3" id="currentAvatar"> 
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#avatarModal">
                                Change Avatar
                            </button>
                        </div>
                        <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <?php // Modal content remains for client-side interaction ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                         <label class="col-sm-3 col-form-label text-end">Profile Banner:</label> 
                        <div class="col-sm-9 d-flex align-items-center">
                            <img src="../IMG/loginBG.png" alt="Profile Banner" class="banner me-3" id="currentBanner"> 
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bannerModal">
                                Change Banner
                            </button>
                             <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerLabel" aria-hidden="true">
                                <?php // Modal content remains for client-side interaction ?>
                             </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="DOB" class="col-sm-3 col-form-label text-end">Date of Birth:</label> 
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="DOB" name="DOB" value="<?php echo htmlspecialchars($user_data['dob'] ?? ''); ?>"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="location" class="col-sm-3 col-form-label text-end">Location:</label> 
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($user_data['location'] ?? ''); ?>"> 
                        </div>
                    </div>
                    <div class="row mb-3">
                         <label for="userText" class="col-sm-3 col-form-label text-end">About you:</label> 
                        <div class="col-sm-9">
                            <textarea class="form-control" id="userText" name="userText" rows="7" placeholder="Type here..."><?php echo htmlspecialchars($user_data['about'] ?? ''); ?></textarea> 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-end"></div>
                        <div class="col-sm-9">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/profile.js"></script> 
</body>
</html>
