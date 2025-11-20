<?php
session_start();
include "db_connect.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Wrong password!";
        }
    } else {
        $error = "❌ Admin username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | CCN-UST Debate Club</title>

  <style>
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background: #F1F8E9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      width: 380px;
      padding: 40px 35px;
      border-radius: 14px;
      background: #ffffff;
      border: 1px solid #c8e6c9;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-box h2 {
      margin-bottom: 22px;
      color: #1B5E20;
      font-size: 26px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .login-box input {
      width: 92%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: 2px solid #c8e6c9;
      outline: none;
      font-size: 15px;
      background: #fafff5;
      transition: 0.3s;
    }

    .login-box input:focus {
      border-color: #1B5E20;
      box-shadow: 0 0 0 2px rgba(27, 94, 32, 0.25);
      background: white;
    }

    .login-box button {
      width: 95%;
      padding: 12px;
      margin-top: 15px;
      background: #1B5E20;
      color: white;
      border: none;
      font-size: 17px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.28s;
      font-weight: 500;
    }

    .login-box button:hover {
      background: #14491a;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(27, 94, 32, 0.35);
    }

    .error {
      color: #d50000;
      background: rgba(213, 0, 0, 0.12);
      padding: 8px;
      border-radius: 6px;
      margin-bottom: 15px;
      font-weight: 500;
      font-size: 14px;
      border: 1px solid rgba(213, 0, 0, 0.25);
    }

    @media (max-width: 430px) {
      .login-box {
        width: 88%;
        padding: 30px 22px;
      }
      .login-box h2 {
        font-size: 22px;
      }
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>🔐 Admin Login</h2>

  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="password" name="password" placeholder="Enter Password" required>
    <button type="submit" name="login">Login</button>
  </form>
</div>

</body>
</html>
