<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';

function escape(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php#feedback');
  exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$gender = trim((string) ($_POST['gender'] ?? ''));
$type = trim((string) ($_POST['feedback_type'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$date = trim((string) ($_POST['submitted_at'] ?? ''));

$errors = [];

if ($name === '' || mb_strlen($name) > 100) {
  $errors[] = 'Please provide a name no longer than 100 characters.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 254) {
  $errors[] = 'Please provide a valid email address.';
}

if (!in_array($gender, ['Female', 'Male', 'Prefer not to say'], true)) {
  $errors[] = 'Please select a gender option.';
}

if (!in_array($type, ['Suggestion', 'Complaint', 'Enquiry'], true)) {
  $errors[] = 'Please select a feedback type.';
}

if ($message === '' || mb_strlen($message) > 3000) {
  $errors[] = 'Please enter feedback (up to 3000 characters).';
}

$dateObject = DateTime::createFromFormat('Y-m-d\TH:i', $date);

if (!$dateObject || $dateObject->format('Y-m-d\TH:i') !== $date) {
  $errors[] = 'Please provide a valid date and time.';
}

if (!$errors) {
  try {
    $statement = $pdo->prepare("
      INSERT INTO feedback
        (name, email, gender, feedback_type, submitted_at, message)
      VALUES
        (:name, :email, :gender, :feedback_type, :submitted_at, :message)
    ");

    $statement->execute([
      'name' => $name,
      'email' => $email,
      'gender' => $gender,
      'feedback_type' => $type,
      'submitted_at' => $dateObject->format('Y-m-d H:i:s'),
      'message' => $message,
    ]);
  } catch (Throwable $exception) {
    $errors[] = 'The feedback could not be saved. Please try again.';
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Feedback response — PawPedia</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <main class="section">
    <div class="container" style="max-width: 760px;">
      <a class="brand" href="index.php">
        <span class="brand-mark" aria-hidden="true">🐾</span>
        <span>Paw<span class="brand-accent">Pedia</span></span>
      </a>

      <?php if ($errors): ?>
        <section class="care-card" style="margin-top: 30px;">
          <p class="eyebrow">Please check your form</p>
          <h1 style="font-size: 2rem;">We couldn’t submit your feedback</h1>

          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= escape($error) ?></li>
            <?php endforeach ?>
          </ul>

          <a class="button button-primary" href="index.php#feedback">
            Return to feedback form
          </a>
        </section>
      <?php else: ?>
        <section class="care-card" style="margin-top: 30px;">
          <p class="eyebrow">Thank you for helping us improve</p>
          <h1 style="font-size: 2rem;">Feedback received!</h1>
          <p>Your feedback has been saved to the PawPedia database.</p>

          <dl class="dialog-facts">
            <div>
              <dt>Name</dt>
              <dd><?= escape($name) ?></dd>
            </div>

            <div>
              <dt>Email</dt>
              <dd><?= escape($email) ?></dd>
            </div>

            <div>
              <dt>Gender</dt>
              <dd><?= escape($gender) ?></dd>
            </div>

            <div>
              <dt>Feedback type</dt>
              <dd><?= escape($type) ?></dd>
            </div>

            <div>
              <dt>Date and time</dt>
              <dd><?= escape($dateObject->format('F j, Y \a\t g:i A')) ?></dd>
            </div>

            <div style="grid-column: 1 / -1;">
              <dt>Feedback</dt>
              <dd><?= nl2br(escape($message)) ?></dd>
            </div>
          </dl>

          <a class="button button-primary" href="index.php">
            Back to PawPedia
          </a>
        </section>
      <?php endif ?>
    </div>
  </main>
</body>
</html>