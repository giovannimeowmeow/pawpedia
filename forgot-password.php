<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim((string) ($_POST['email'] ?? ''));

  $statement = $pdo->prepare(
    'SELECT id FROM users WHERE email = :email LIMIT 1'
  );
  $statement->execute(['email' => $email]);
  $user = $statement->fetch();

  if ($user) {
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expires = (new DateTime('+30 minutes'))->format('Y-m-d H:i:s');

    $statement = $pdo->prepare(
      'UPDATE users
       SET password_reset_token = :token,
           password_reset_expires = :expires
       WHERE id = :id'
    );

    $statement->execute([
      'token' => $tokenHash,
      'expires' => $expires,
      'id' => $user['id'],
    ]);

    // Local-development option:
    $resetLink = 'http://localhost/pawpedia/reset-password.php?token='
      . urlencode($token);

    $message = 'A reset link has been generated:
      <a href="' . h($resetLink) . '">Reset your password</a>';
  } else {
    // Do not reveal whether the email exists.
    $message = 'If that email is registered, password reset instructions will be sent.';
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot password — PawPedia</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <main class="login-main">
    <section class="auth-card">
      <p class="eyebrow">Password recovery</p>
      <h1>Forgot password</h1>

      <?php if ($message !== ''): ?>
        <p><?= $message ?></p>
      <?php endif; ?>

      <form action="forgot-password.php" method="post" class="feedback-form">
        <label for="email">
          Email
          <input id="email" name="email" type="email" required>
        </label>

        <button class="button button-primary" type="submit">
          Send reset link
        </button>
      </form>

      <p><a href="login.php">Back to login</a></p>
    </section>
  </main>
</body>
</html>