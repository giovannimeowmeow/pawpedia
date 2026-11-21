<?php
require __DIR__ . '/includes/bootstrap.php';

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token($_POST['csrf_token'] ?? null);

    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Enter your name (up to 100 characters).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $errors[] = 'Enter a valid email address.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Your password must be at least 8 characters.';
    }

    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);

        if ($check->fetch()) {
            $errors[] = 'An account with that email already exists.';
        } else {
            $insert = $pdo->prepare(
                'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)'
            );
            $insert->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
            ]);

            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int)$pdo->lastInsertId(),
                'name' => $name,
                'email' => $email,
                'role' => 'user',
            ];

            header('Location: index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create account — PawPedia</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <main class="section">
    <div class="container auth-card">
      <a class="brand" href="index.php">🐾 Paw<span class="brand-accent">Pedia</span></a>
      <h1>Create an account</h1>

      <?php foreach ($errors as $error): ?>
        <p class="form-error"><?= h($error) ?></p>
      <?php endforeach; ?>

      <form class="feedback-form" method="post">
        <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">

        <label for="name">Name
          <input id="name" name="name" required maxlength="100" value="<?= h($name) ?>">
        </label>

        <label for="email">Email
          <input id="email" name="email" type="email" required maxlength="254" value="<?= h($email) ?>">
        </label>

        <label for="password">Password (at least 8 characters)
          <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password">
        </label>

        <button class="button button-primary" type="submit">Register</button>
      </form>

      <p>Already registered? <a href="login.php">Log in</a></p>
    </div>
  </main>
</body>
</html>