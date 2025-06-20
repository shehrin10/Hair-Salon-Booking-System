<?php include 'includes/header.php'; ?>
<?php
// log.php
require_once 'config.php';

// Flash helper
function redirect_with($msg, $to='log.php') {
  $_SESSION['flash'] = $msg;
  header("Location: $to");
  exit;
}

// ——— Registration ———
if (($_POST['action'] ?? '') === 'register') {
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $pass     = $_POST['password'];
  $confirm  = $_POST['confirm'];

  // Basic validation
  if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
    redirect_with("Please complete all fields and use a valid email / min 6-char password.");
  }
  if ($pass !== $confirm) {
    redirect_with("Passwords did not match.");
  }
  // Check for existing user
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    redirect_with("That email is already registered.");
  }
  // Insert new user
  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
  $stmt->execute([$name, $email, $hash]);
  redirect_with("Registration successful! Please sign in now.");
}

// ——— Login ———
if (($_POST['action'] ?? '') === 'login') {
  $email = trim($_POST['email']);
  $pass  = $_POST['password'];

  $stmt = $pdo->prepare("SELECT id,name,password FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($pass, $user['password'])) {
    // Login success
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    header("Location: index.php");
    exit;
  } else {
    redirect_with("Invalid email or password.");
  }
}

// ——— Display form ———
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign In / Sign Up</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="padding-top:0px;">

<div class="container">
  <?php if($flash): ?>
    <div class="alert alert-info"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="row">
    <!-- Sign In -->
    <div class="col-md-6">
      <h3>Sign In</h3>
      <form method="post">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Sign In</button>
      </form>
    </div>

    <!-- Sign Up -->
    <div class="col-md-6">
      <h3>Sign Up</h3>
      <form method="post">
        <input type="hidden" name="action" value="register">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password (min 6 chars)</label>
          <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm" class="form-control" required>
        </div>
        <button class="btn btn-success">Sign Up</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
<?php include 'includes/footer.php'; ?>
