<?php
require __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_csrf_token($_POST['csrf_token'] ?? null);

$_SESSION = [];
session_destroy();

header('Location: index.php');
exit;