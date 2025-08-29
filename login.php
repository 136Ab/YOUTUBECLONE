<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id,username,password FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        $stmt->bind_result($id,$username,$hashed);
        $stmt->fetch();
        if(password_verify($password,$hashed)){
            $_SESSION['user_id']=$id;
            $_SESSION['username']=$username;
            echo "<script>alert('Login Successful!'); window.location.href='index.php';</script>";
        }else{
            echo "<script>alert('Invalid Password');</script>";
        }
    }else{
        echo "<script>alert('Email not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{font-family:Arial;background:#111;color:#fff;text-align:center}
form{background:#222;padding:20px;border-radius:10px;display:inline-block;margin-top:50px}
input{padding:10px;margin:10px;width:250px;border:none;border-radius:5px}
button{padding:10px 20px;background:red;color:#fff;border:none;border-radius:5px;cursor:pointer}
button:hover{background:#cc0000}
</style>
</head>
<body>
<h1>Login</h1>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>Don’t have account? <a href="signup.php" style="color:#f55">Signup</a></p>
</body>
</html>
