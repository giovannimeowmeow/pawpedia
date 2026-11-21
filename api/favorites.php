<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if (empty($_SESSION['user'])) {
    json_response(['error' => 'Please log in to use favourites.'], 401);
}

$userId = (int)$_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = $pdo->prepare(
        'SELECT p.slug FROM favorites f
         JOIN pets p ON p.id = f.pet_id
         WHERE f.user_id = ?'
    );
    $query->execute([$userId]);

    json_response(['favorites' => array_column($query->fetchAll(), 'slug')]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method not allowed.'], 405);
}

require_csrf_token($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null);

$input = json_decode(file_get_contents('php://input'), true);
$slug = is_array($input) ? (string)($input['slug'] ?? '') : '';
$favorite = is_array($input) ? ($input['favorite'] ?? null) : null;

$petQuery = $pdo->prepare('SELECT id FROM pets WHERE slug = ?');
$petQuery->execute([$slug]);
$pet = $petQuery->fetch();

if (!$pet || !is_bool($favorite)) {
    json_response(['error' => 'Invalid pet or favourite action.'], 400);
}

if ($favorite) {
    $query = $pdo->prepare(
        'INSERT IGNORE INTO favorites (user_id, pet_id) VALUES (?, ?)'
    );
    $query->execute([$userId, $pet['id']]);
} else {
    $query = $pdo->prepare(
        'DELETE FROM favorites WHERE user_id = ? AND pet_id = ?'
    );
    $query->execute([$userId, $pet['id']]);
}

json_response(['slug' => $slug, 'favorite' => $favorite]);