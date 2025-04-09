<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $schoolID = trim($_POST['schoolID']);
    $password = trim($_POST['password']);

    // Try Admin Login (Plain Text Comparison)
    $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE admin_username = ?");
    $stmt->bind_param("s", $schoolID);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
        if ($password === $admin['admin_password']) {
            $_SESSION['admin_username'] = $admin['admin_username'];
            $_SESSION['is_admin'] = true;

            $adminName = $admin['admin_username'];
            echo "<script>alert('Welcome Admin, $adminName!'); window.location.href = 'cpanel.php';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect admin password!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        // Try Student Login (Plain Text Comparison)
        $stmt = $conn->prepare("SELECT * FROM login WHERE schoolID = ?");
        $stmt->bind_param("s", $schoolID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ($user['status'] == 0) {
                echo "<script>alert('You already voted, see you next SSG election.'); window.location='login.php';</script>";
                exit();
            }

            if ($password === $user['password']) {
                $_SESSION['schoolID'] = $user['schoolID'];
                $_SESSION['logged_in'] = true;

                echo "<script>
                    localStorage.setItem('showSuccessModal', 'true');
                    window.location.href = 'index.html';
                </script>";
                exit();
            } else {
                echo "<script>alert('Incorrect student password!'); window.location.href='login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid School ID or Password!'); window.location.href='login.php';</script>";
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="images/sis.png" alt="Stratford International School Logo">
    </div>
    <div class="right">
      <h2>WELCOME TO SIS VOTING SYSTEM</h2>
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="schoolID">School ID</label>
          <input type="text" id="schoolID" name="schoolID" placeholder="Enter School ID" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" required>
        </div>
        <div class="form-footer">
          <div></div>
          <a href="#">Forgot Password?</a>
        </div>
        <button class="login-btn" type="submit" name="login">LOGIN</button>
      </form>
    </div>
  </div>
  
</body>
</html>