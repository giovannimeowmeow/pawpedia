<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$errors = [];
$message = '';

if ($token === '') {
  $errors[] = 'The password reset link is invalid.';
}

$tokenHash = hash('sha256', $token);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$errors) {
  $password = (string) ($_POST['password'] ?? '');
  $confirm = (string) ($_POST['confirm_password'] ?? '');

  if (strlen($password) < 8) {
    $errors[] = 'Password must contain at least 8 characters.';
  }

  if ($password !== $confirm) {
    $errors[] = 'Passwords do not match.';
  }

  if (!$errors) {
    $statement = $pdo->prepare(
      'SELECT id
       FROM users
       WHERE password_reset_token = :token
         AND password_reset_expires > NOW()
       LIMIT 1'
    );
    $statement->execute(['token' => $tokenHash]);
    $user = $statement->fetch();

    if (!$user) {
      $errors[] = 'The reset link is invalid or has expired.';
    } else {
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      $statement = $pdo->prepare(
        'UPDATE users
         SET password_hash = :password_hash,
             password_reset_token = NULL,
             password_reset_expires = NULL
         WHERE id = :id'
      );

      $statement->execute([
        'password_hash' => $passwordHash,
        'id' => $user['id'],
      ]);

      $message = 'Password changed successfully. '
        . '<a href="login.php">Log in</a>';
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset password — PawPedia</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <main class="login-main">
    <section class="auth-card">
      <p class="eyebrow">Account recovery</p>
      <h1>Reset password</h1>

      <?php foreach ($errors as $error): ?>
        <p><?= h($error) ?></p>
      <?php endforeach ?>

      <?php if ($message !== ''): ?>
        <p><?= $message ?></p>
      <?php else: ?>
        <form action="reset-password.php" method="post" class="feedback-form">
          <input type="hidden" name="token" value="<?= h($token) ?>">

          <label for="password">
            New password
            <input id="password" name="password" type="password"
                   minlength="8" required>
          </label>

          <label for="confirm-password">
            Confirm password
            <input id="confirm-password" name="confirm_password"
                   type="password" minlength="8" required>
          </label>

          <button class="button button-primary" type="submit">
            Change password
          </button>
        </form>
      <?php endif ?>
    </section>
  </main>
</body>
</html>