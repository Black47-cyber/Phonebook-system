<?php
session_start();
include "db.php";

$error = "";

if(isset($_POST['username']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn,$sql);

    if($result && mysqli_num_rows($result) == 1)
    {
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $error = "Incorrect password";
        }
    }
    else
    {
        $error = "Username doesn't exist";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Phonebook</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="auth-box">
    <h1 style="text-align:center; color:#6366f1; margin-bottom:10px;">📱 Phonebook</h1>
    <h2>Welcome to Phonebook</h2>
    <p class="subtitle">Manage your contacts with ease</p>
    <h3 style="color:#6366f1; margin-bottom:20px;">Login</h3>

    <?php if($error) echo '<div class="error">'.$error.'</div>';?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Login" class="btn-primary">
    </form>

    <p style="text-align:center; margin-top:20px; color:#6b7280;">
        Don't have an account? <a href="register.php" style="color:#6366f1; text-decoration:none; font-weight:600;">Register here</a>
    </p>
</div>
</body>
</html>
