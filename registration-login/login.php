<?php
$file = "users.txt";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $message = "Both fields are required!";
    } else {
        $users = file($file, FILE_IGNORE_NEW_LINES);
        $found = false;

        foreach ($users as $user) {
            $data = explode("|", $user);
            // FIX: Removed md5(), compare plain text password
            if ($data[2] === $username && $data[3] === $password) {
                $found = true;
                $fullname = $data[0];
                break;
            }
        }

        if ($found) {
            $message = "Welcome, $fullname!";
        } else {
            $message = "Invalid username or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel="stylesheet" href="style.css">
  <script src="validation.js"></script>
</head>
<body>
  <div class="form-container">
    <h2>Login Form</h2>
    <!-- Show popup message -->
    <?php if (!empty($message)): ?>
      <div class="message-box <?= strpos($message, 'Welcome') !== false ? 'success' : 'error' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="post" onsubmit="return validateLogin()">
      <label>Username</label>
      <input type="text" name="username" id="login_username">

      <label>Password</label>
      <input type="password" name="password" id="login_password">

      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="registration.php">Register here</a></p>
  </div>
</body>
</html>
