<?php
require __DIR__ . '/includes/bootstrap.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: login.php');
  exit;
}

// All registered users
$usersStmt = $pdo->query("
  SELECT id, name, email, role, created_at
  FROM users
  ORDER BY created_at DESC
");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

// Favourite pets for every user
$favouritesStmt = $pdo->query("
  SELECT
    u.id AS user_id,
    u.name AS user_name,
    u.email,
    p.id AS pet_id,
    p.slug,
    p.name AS pet_name,
    p.category,
    f.created_at
  FROM favorites AS f
  JOIN users AS u ON u.id = f.user_id
  JOIN pets AS p ON p.id = f.pet_id
  ORDER BY f.created_at DESC
");
$favourites = $favouritesStmt->fetchAll(PDO::FETCH_ASSOC);

// Feedback submitted through feedback.php
$feedback = [];

try {
  $feedbackStmt = $pdo->query("
    SELECT
  f.user_id,
  f.username,
  f.pet_id,
  f.pet_name,
  f.created_at
FROM favorites_with_names AS f
ORDER BY f.created_at DESC
  ");
  $feedback = $feedbackStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
  // The feedback table may not exist yet.
  $feedback = [];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?= h(csrf_token()) ?>">
  <title>PawPedia — Admin Dashboard</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="index.php" aria-label="PawPedia home">
        <span class="brand-mark" aria-hidden="true">🐾</span>
        <span>Paw<span class="brand-accent">Pedia</span></span>
      </a>

      <nav class="primary-nav" aria-label="Admin navigation">
        <a href="index.php">Website</a>
        <span class="nav-user">
          Admin: <?= h($_SESSION['user']['name']) ?>
        </span>

        <form class="nav-logout" action="logout.php" method="post">
          <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
          <button class="nav-button" type="submit">Log out</button>
        </form>
      </nav>
    </div>
  </header>

  <main id="main">
    <section class="section">
      <div class="container">
        <p class="eyebrow">Administration</p>
        <h1>Admin Dashboard</h1>
        <p>Manage registered accounts, view favourite pets, and review website feedback.</p>

        <h2>Registered users</h2>

        <div class="admin-table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= h($user['id']) ?></td>
                  <td><?= h($user['name']) ?></td>
                  <td><?= h($user['email']) ?></td>
                  <td><?= h($user['role']) ?></td>
                  <td><?= h($user['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>

              <?php if (!$users): ?>
                <tr>
                  <td colspan="5">No registered users.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <h2>User favourite pets</h2>

        <div class="admin-table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>User</th>
                <th>Email</th>
                <th>Favourite pet</th>
                <th>Category</th>
                <th>Saved at</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($favourites as $favourite): ?>
                <tr>
                  <td><?= h($favourite['user_name']) ?></td>
                  <td><?= h($favourite['email']) ?></td>
                  <td><?= h($favourite['pet_name']) ?></td>
                  <td><?= h($favourite['category']) ?></td>
                  <td><?= h($favourite['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>

              <?php if (!$favourites): ?>
                <tr>
                  <td colspan="5">No favourite pets have been saved.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <h2>Feedback submissions</h2>

        <div class="admin-table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Type</th>
                <th>Date/time</th>
                <th>Message</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($feedback as $item): ?>
                <tr>
                  <td><?= h($item['name']) ?></td>
                  <td><?= h($item['email']) ?></td>
                  <td><?= h($item['gender']) ?></td>
                  <td><?= h($item['feedback_type']) ?></td>
                  <td><?= h($item['submitted_at']) ?></td>
                  <td><?= h($item['message']) ?></td>
                </tr>
              <?php endforeach; ?>

              <?php if (!$feedback): ?>
                <tr>
                  <td colspan="6">No feedback submissions.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-bottom">
      <span>© <span id="current-year"></span> PawPedia Admin</span>
      <a href="index.php">Back to website</a>
    </div>
  </footer>

  <script>
    const year = document.querySelector("#current-year");

    if (year) {
      year.textContent = new Date().getFullYear();
    }
  </script>
</body>
</html>