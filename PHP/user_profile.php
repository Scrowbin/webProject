<?php
// Expects $user_data from controller.
if (!isset($user_data)) {
    die('Error: Profile data not available.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CSS/user_profile.css">
    <link rel="stylesheet" href="/CSS/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <title><?php echo htmlspecialchars($user_data['username']); ?> - User Profile</title>
</head>
<body class="bg-dark">
    <?php
    include 'includes/navbar_minimal.php';
    ?>

    <div class="container-fluid mt-5">
        <!-- Profile Banner -->
        <div class="profile-banner position-relative">
            <?php if (!empty($user_data['banner'])): ?>
                <img src="/IMG/banners/<?php echo htmlspecialchars($user_data['banner']); ?>" alt="Profile Banner" class="w-100">
            <?php else: ?>
                <div class="empty-banner w-100" style="height: 200px; background-color: #343a40;"></div>
            <?php endif; ?>

            <!-- Profile layout with avatar on left and info on right -->
            <div class="profile-container d-flex align-items-end position-absolute bottom-0 start-0 p-3" style="width: 100%;">
                <!-- Avatar on left -->
                <div class="profile-avatar me-3" style="z-index: 10;">
                    <?php if (!empty($user_data['Avatar']) && $user_data['Avatar'] !== 'avatar_default.png'): ?>
                        <div class="avatar-wrapper bg-warning text-center d-inline-block" style="width: 100px; height: 100px; border-radius: 0; overflow: hidden;">
                            <img src="/IMG/avatars/<?php echo htmlspecialchars($user_data['Avatar']); ?>" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div class="avatar-wrapper bg-warning text-center d-inline-block" style="width: 100px; height: 100px; line-height: 100px; font-size: 48px; color: white; border-radius: 0;">
                            <?php echo strtoupper(substr($user_data['username'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- User info on right -->
                <div class="profile-info text-white" style="margin-left: 10px;">
                    <h2 class="mb-1"><?php echo htmlspecialchars($user_data['username']); ?></h2>
                    <div class="user-status">
                        <span>Member</span>
                    </div>
                    <div class="user-activity">
                        <span>Joined: <?php echo date('F j, Y', strtotime($user_data['created_at'] ?? 'now')); ?></span>
                    </div>
                    <div class="user-activity">
                        <span>Last seen: A moment ago • Viewing member profile <?php echo htmlspecialchars($user_data['username']); ?></span>
                    </div>
                </div>
            </div>

            <div class="profile-actions position-absolute top-0 end-0 p-3">
                <button class="btn btn-dark btn-sm me-2">Report</button>
                <a href="/profile" class="btn btn-danger btn-sm">Edit profile</a>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark text-white border-secondary">
                        <div class="card-header bg-dark border-secondary">
                            <h5 class="mb-0"><i class="bi bi-info-circle"></i> About <?php echo htmlspecialchars($user_data['username']); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($user_data['About'])): ?>
                                <div class="mb-4"><?php echo $user_data['About']; ?></div>
                            <?php else: ?>
                                <p class="mb-4">No information provided.</p>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="border-bottom border-secondary pb-2 mb-3">Location</h6>
                                    <p><?php echo !empty($user_data['location']) ? htmlspecialchars($user_data['location']) : 'Not specified'; ?></p>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="border-bottom border-secondary pb-2 mb-3">Date of Birth</h6>
                                    <p><?php echo !empty($user_data['dob']) ? date('F j, Y', strtotime($user_data['dob'])) : 'Not specified'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/JS/user_profile.js"></script>
    <script src="/JS/navbar.js"></script>
    <script src="/JS/sidebar.js"></script>
</body>
</html>
