
<?php
require __DIR__ . '/includes/bootstrap.php';

if (!empty($_SESSION['user'])) {
  if ($_SESSION['user']['role'] === 'admin') {
    header('Location: admin.php');
  } else {
    header('Location: index.php');
  }
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $identity = trim($_POST['identity'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($identity === '' || $password === '') {
    $error = 'Enter your name or email and password.';
  } else {
    $stmt = $pdo->prepare("
      SELECT id, name, email, role, password_hash
      FROM users
      WHERE email = :email OR name = :name
      LIMIT 1
    ");

    $stmt->execute([
      'email' => $identity,
      'name' => $identity,
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
      session_regenerate_id(true);

      $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
      ];

      if ($user['role'] === 'admin') {
        header('Location: admin.php');
      } else {
        header('Location: index.php');
      }
      exit;
    }

    $error = 'Name/email or password is incorrect.';
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PawPedia — Log In</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="index.php">
        <span class="brand-mark">🐾</span>
        <span>Paw<span class="brand-accent">Pedia</span></span>
      </a>

      <nav class="primary-nav" aria-label="Main navigation">
        <a href="index.php">Home</a>

        <div class="auth-nav-links">
          <a class="auth-nav-button" href="login.php">Log in</a>
          <a class="auth-nav-button register" href="register.php">Register</a>
        </div>
      </nav>
    </div>
  </header>

  <main id="main" class="login-main">
    <div class="container">
      <div class="auth-card">
        <p class="eyebrow">Welcome back</p>
        <h1>Log in</h1>

        <?php if ($error !== ''): ?>
          <p class="form-error" role="alert"><?= h($error) ?></p>
        <?php endif; ?>

        <form class="feedback-form" action="login.php" method="post">
          <label for="identity">
            Name or email
            <input
              id="identity"
              name="identity"
              type="text"
              value="<?= h($_POST['identity'] ?? '') ?>"
              autocomplete="username"
              required
              autofocus
            >
          </label>

        <label for="password">
  Password
  <span class="password-field">
    <input
      id="password"
      name="password"
      type="password"
      autocomplete="current-password"
      required
    >
    <button
      class="password-toggle"
      type="button"
      aria-label="Show password"
      aria-pressed="false"
    >
      <svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      </svg>
    </button>
  </span>
</label>

<a class="forgot-password-link" href="forgot-password.php">
  Forgot password?
</a>

          <button class="button button-primary" type="submit">
            Log in
          </button>
        </form>

        <p>
          New to PawPedia?
          <a href="register.php"><strong>Create an account</strong></a>
        </p>
      </div>
    </div>
  </main>

  

  <script>
  const passwordInput = document.querySelector("#password");
  const passwordToggle = document.querySelector(".password-toggle");

  passwordToggle.addEventListener("click", () => {
    const showingPassword = passwordInput.type === "password";

    passwordInput.type = showingPassword ? "text" : "password";
    passwordToggle.setAttribute("aria-pressed", String(showingPassword));
    passwordToggle.setAttribute(
      "aria-label",
      showingPassword ? "Hide password" : "Show password"
    );
  });
</script>
</body>
</html>
