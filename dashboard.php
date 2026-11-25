<?php
require_once __DIR__ . '/includes/functions.php';

// Login na thakle login page e pathiye dibe
require_login();

$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<h2>Welcome, <?= e($_SESSION['user_name']) ?>!</h2>
<p class="text-muted">Your role: <?= e($_SESSION['user_role']) ?></p>

<div class="alert alert-info">
    Dashboard is under construction. Assignments and subjects are coming soon.
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>