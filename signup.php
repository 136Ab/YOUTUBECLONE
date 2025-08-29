<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error: Email or Username already exists!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
<style>
body{font-family:Arial;background:#111;color:#fff;text-align:center}
form{background:#222;padding:20px;border-radius:10px;display:inline-block;margin-top:50px}
input{padding:10px;margin:10px;width:250px;border:none;border-radius:5px}
button{padding:10px 20px;background:red;color:#fff;border:none;border-radius:5px;cursor:pointer}
button:hover{background:#cc0000}
</style>
</head>
<body>
<h1>Create Account</h1>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Signup</button>
</form>
<p>Already have an account? <a href="login.php" style="color:#f55">Login</a></p>
</body>
</html>
