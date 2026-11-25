<?php
require_once __DIR__ . '/classes/Database.php';

$db = Database::getConnection();
echo "Database connected successfully!";