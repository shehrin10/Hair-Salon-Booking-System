<?php
// contactus.php

// 1) Start session before anything else
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Flash‐message helper & POST handler
function redirect_with($msg, $to = 'contactus.php') {
    $_SESSION['flash'] = $msg;
    header("Location: $to");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'send') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $message = trim($_POST['message'] ?? '');

    // Simple validation
    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
        redirect_with("Please fill in all fields with valid data.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'send') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $message = trim($_POST['message'] ?? '');

  if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
    redirect_with("Please fill in all fields with valid data.");
  }

  // ----- INSERT INTO DATABASE -----
  require_once 'config.php';  // loads $pdo

  $stmt = $pdo->prepare("
    INSERT INTO contacts (name, email, message)
    VALUES (:name, :email, :message)
  ");
  $stmt->execute([
    ':name'    => $name,
    ':email'   => $email,
    ':message' => $message
  ]);
  // --------------------------------

  redirect_with("Message sent! We’ll be in touch shortly.");
}

    redirect_with("Message sent! We’ll be in touch shortly.");
}

// 3) Pull & clear flash
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<?php include 'includes/header.php'; ?>

<?php if ($flash): ?>
  <div class="container mt-4">
    <div class="alert alert-success">
      <?= htmlspecialchars($flash) ?>
    </div>
  </div>
<?php endif; ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Contact Us</h1>
    <form action="contactus.php" method="post">
      <!-- tells PHP this is the form submission -->
      <input type="hidden" name="action" value="send">

      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="text"
          id="name"
          name="name"
          class="form-control"
          required
          value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
        >
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-control"
          required
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
        >
      </div>

      <div class="form-group">
        <label for="message">Message:</label>
        <textarea
          id="message"
          name="message"
          rows="5"
          class="form-control"
          required
        ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
      </div>

      <button class="btn btn-success">Send</button>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
