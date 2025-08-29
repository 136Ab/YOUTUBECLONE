<?php
session_start();
include "db.php";
if(!isset($_SESSION['user_id'])){
  echo "<script>alert('Login first!'); window.location.href='login.php';</script>";
  exit;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $title=$_POST['title'];
  $desc=$_POST['description'];
  $cat=$_POST['category'];
  $uid=$_SESSION['user_id'];

  $videoName=time()."_".basename($_FILES['video']['name']);
  $thumbName=time()."_".basename($_FILES['thumbnail']['name']);

  move_uploaded_file($_FILES['video']['tmp_name'],"uploads/".$videoName);
  move_uploaded_file($_FILES['thumbnail']['tmp_name'],"uploads/".$thumbName);

  $stmt=$conn->prepare("INSERT INTO videos(user_id,title,description,filename,thumbnail,category) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param("isssss",$uid,$title,$desc,$videoName,$thumbName,$cat);
  if($stmt->execute()){
    echo "<script>alert('Video uploaded!'); window.location.href='index.php';</script>";
  }else{
    echo "<script>alert('Error uploading video');</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Video</title>
<style>
body{font-family:Arial;background:#111;color:#fff;text-align:center}
form{background:#222;padding:20px;margin:40px auto;width:400px;border-radius:8px}
input,textarea,select{width:100%;padding:10px;margin:10px 0;border:none;border-radius:5px}
button{padding:10px 20px;background:red;color:#fff;border:none;border-radius:5px;cursor:pointer}
button:hover{background:#cc0000}
</style>
</head>
<body>
<h1>Upload Video</h1>
<form method="post" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Title" required>
  <textarea name="description" placeholder="Description"></textarea>
  <input type="text" name="category" placeholder="Category">
  <input type="file" name="video" accept="video/*" required>
  <input type="file" name="thumbnail" accept="image/*" required>
  <button type="submit">Upload</button>
</form>
</body>
</html>
