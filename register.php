<?php
session_start();
include "db.php";

$error = "";
$success = "";

if(isset($_POST['username']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        $error = "Username already exist";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if(mysqli_query($conn, $sql)){
            $success = "Registered! Login ";
        } else {
            $error = "Error: ".mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Phonebook</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="auth-box">
    <h1 style="text-align:center; color:#6366f1; margin-bottom:10px;">📱 Phonebook</h1>
    <h2>Welcome to Phonebook</h2>
    <p class="subtitle">Manage your contacts with ease</p>
    <h3 style="color:#6366f1; margin-bottom:20px;">Register</h3>

    <?php 
    if($error) echo '<div class="error">'.$error.'</div>';
    if($success) echo '<div class="success">'.$success.'</div>';
    ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>
        
        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Register" class="btn-primary">
    </form>

    <p style="text-align:center; margin-top:20px; color:#6b7280;">
        Already have an account? <a href="index.php" style="color:#6366f1; text-decoration:none; font-weight:600;">Login here</a>
    </p>
</div>
</body>
</html>
