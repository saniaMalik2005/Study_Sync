<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/classes/User.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!verify_csrf()) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if ($email === '') {
        $errors[] = 'Email cannot be empty.';
    }

    if ($password === '') {
        $errors[] = 'Password cannot be empty.';
    }

    if (empty($errors)) {
        try {
            $userModel = new User();
            $user = $userModel->verifyLogin($email, $password);

            if ($user) {
                // Session fixation attack theke bachar jonno notun session id
                session_regenerate_id(true);

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                set_flash('success', 'Welcome back, ' . $user['name'] . '!');
                redirect('dashboard.php');
            } else {
                // Email naki password vul, seta bole dei na (security)
                $errors[] = 'Invalid email or password.';
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $errors[] = 'Something went wrong, try again.';
        }
    }
}

$pageTitle = 'Login';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Login</h3>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= e($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?= e($email) ?>" required>
                        <div class="invalid-feedback">Email cannot be empty.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">Password cannot be empty.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    New here? <a href="<?= BASE_URL ?>/signup.php">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>