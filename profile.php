<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/classes/User.php';

require_login();

$userModel = new User();
$userId = (int)$_SESSION['user_id'];
$user = $userModel->findById($userId);

// User ডাটাবেসে না থাকলে (মুছে গেলে) logout
if (!$user) {
    redirect('logout.php');
}

$profileErrors = [];
$passwordErrors = [];
$name = $user['name'];
$email = $user['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if (!verify_csrf()) {
        set_flash('danger', 'Invalid form submission. Please try again.');
        redirect('profile.php');
    }

    // ---------- Profile info update ----------
    if ($action === 'update_profile') {
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name === '') {
            $profileErrors[] = 'Name cannot be empty.';
        } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
            $profileErrors[] = 'Name must be between 2 and 100 characters.';
        }

        if ($email === '') {
            $profileErrors[] = 'Email cannot be empty.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $profileErrors[] = 'Please enter a valid email address.';
        }

        if (empty($profileErrors)) {
            try {
                if ($userModel->emailTakenByOther($email, $userId)) {
                    $profileErrors[] = 'This email is already used by another account.';
                } else {
                    $userModel->updateProfile($userId, $name, $email);
                    $_SESSION['user_name'] = $name; // menu/dashboard e notun nam dekhabe
                    set_flash('success', 'Profile updated successfully.');
                    redirect('profile.php');
                }
            } catch (PDOException $ex) {
                error_log($ex->getMessage());
                $profileErrors[] = 'Something went wrong, try again.';
            }
        }
    }

    // ---------- Password change ----------
    if ($action === 'change_password') {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_new_password'] ?? '';

        if ($current === '') {
            $passwordErrors[] = 'Current password cannot be empty.';
        }
        if (strlen($new) < 8) {
            $passwordErrors[] = 'New password must be at least 8 characters.';
        }
        if ($new !== $confirm) {
            $passwordErrors[] = 'New passwords do not match.';
        }

        if (empty($passwordErrors)) {
            try {
                if ($userModel->changePassword($userId, $current, $new)) {
                    session_regenerate_id(true);
                    set_flash('success', 'Password changed successfully.');
                    redirect('profile.php');
                } else {
                    $passwordErrors[] = 'Current password is incorrect.';
                }
            } catch (PDOException $ex) {
                error_log($ex->getMessage());
                $passwordErrors[] = 'Something went wrong, try again.';
            }
        }
    }
}

$pageTitle = 'Profile';
require_once __DIR__ . '/includes/header.php';
?>

<h2 class="mb-4">My Profile</h2>

<div class="row g-4">

    <!-- Edit info -->
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">Edit Information</h5>

                <?php if (!empty($profileErrors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($profileErrors as $error): ?>
                                <li><?= e($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="profileForm" method="POST" action="" novalidate>
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="update_profile">

                    <div class="mb-3">
                        <label for="profile_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="profile_name" name="name"
                               value="<?= e($name) ?>" required>
                        <div class="invalid-feedback">Name must be at least 2 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label for="profile_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profile_email" name="email"
                               value="<?= e($email) ?>" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <p class="text-muted small">
                        Role: <strong><?= e($user['role']) ?></strong> &middot;
                        Member since: <?= e(date('d M Y', strtotime($user['created_at']))) ?>
                    </p>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Change password -->
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">Change Password</h5>

                <?php if (!empty($passwordErrors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($passwordErrors as $error): ?>
                                <li><?= e($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="passwordForm" method="POST" action="" novalidate>
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="change_password">

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback">Current password cannot be empty.</div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                        <div class="invalid-feedback">Passwords do not match.</div>
                    </div>

                    <button type="submit" class="btn btn-warning">Change Password</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>