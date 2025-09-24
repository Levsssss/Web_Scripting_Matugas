<?php
$message = ""; // store feedback message here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : "";
    $country = $_POST['country'];

    // Validation
    $errors = [];
    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($gender) || empty($country)) {
        $errors[] = "All fields are required!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // Check duplicate username
    $userFile = "users.txt";
    if (file_exists($userFile)) {
        $users = file($userFile, FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            $userDetails = explode("|", $user);
            if ($userDetails[2] === $username) {
                $errors[] = "Username already exists!";
                break;
            }
        }
    }

    if (empty($errors)) {
        $data = $fullname . "|" . $email . "|" . $username . "|" . $password . "|" . $gender . "|" . $hobbies . "|" . $country . PHP_EOL;
        file_put_contents($userFile, $data, FILE_APPEND);
        $message = "<p class='success'>Registration Successful!</p>";
    } else {
        foreach ($errors as $error) {
            $message .= "<p class='error'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Registration Form</h2>
    <form method="POST" action="">

      <label>Full Name</label>
      <input type="text" name="fullname">

      <label>Email Address</label>
      <input type="email" name="email">

      <label>Username</label>
      <input type="text" name="username">

      <label>Password</label>
      <input type="password" name="password">

      <label>Confirm Password</label>
      <input type="password" name="confirm_password">

      <label>Gender</label>
      <div class="radio-group">
        <label><input type="radio" name="gender" value="Male"> Male</label>
        <label><input type="radio" name="gender" value="Female"> Female</label>
      </div>

      <label>Hobbies</label>
      <div class="checkbox-group">
        <label><input type="checkbox" name="hobbies[]" value="Reading"> Reading</label>
        <label><input type="checkbox" name="hobbies[]" value="Gaming"> Gaming</label>
        <label><input type="checkbox" name="hobbies[]" value="Sports"> Sports</label>
      </div>

      <label>Country</label>
      <select name="country">
        <option value="">--Select--</option>
        <option>Philippines</option>
        <option>USA</option>
        <option>UK</option>
        <option>Canada</option>
      </select>

      <button type="submit">Register</button>

      <p class="login-text"><span>Already Registered?</span> <a href="login.php">Login here</a></p>

      <!-- ✅ Show message BELOW the Already Registered part -->
      <div class="message-box">
        <?php if (!empty($message)) echo $message; ?>
      </div>

    </form>
  </div>
</body>
</html>
