<?php
require_once __DIR__ . '/includes/functions.php';

// Browser ke bolo je page paoa jay nai
http_response_code(404);

$pageTitle = 'Page Not Found';
require_once __DIR__ . '/includes/header.php';
?>

<div class="text-center py-5">
    <h1 class="display-1 fw-bold text-primary">404</h1>
    <h3 class="mb-3">Page not found</h3>
    <p class="text-muted">The page you are looking for does not exist or has been moved.</p>
    <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary mt-2">Back to Home</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>