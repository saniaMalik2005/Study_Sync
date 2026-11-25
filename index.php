<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Home';
require_once __DIR__ . '/includes/header.php';
?>

<div class="text-center py-5">
    <h1 class="display-5 fw-bold">StudySync</h1>
    <p class="lead text-muted">
        Your smart academic planner. Organize assignments, manage subjects,
        and plan study sessions in one place.
    </p>

    <?php if (is_logged_in()): ?>
        <a href="<?= BASE_URL ?>/dashboard.php" class="btn btn-primary btn-lg mt-3">Go to Dashboard</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>/signup.php" class="btn btn-primary btn-lg mt-3 me-2">Get Started</a>
        <a href="<?= BASE_URL ?>/login.php" class="btn btn-outline-primary btn-lg mt-3">Login</a>
    <?php endif; ?>
</div>

<div class="row text-center g-4 mt-2">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Track Assignments</h5>
                <p class="card-text text-muted">Set deadlines and priorities so nothing gets forgotten.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Organize Subjects</h5>
                <p class="card-text text-muted">Group your work by subject and stay organized.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Plan Study Time</h5>
                <p class="card-text text-muted">Schedule study sessions with dates and times.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>