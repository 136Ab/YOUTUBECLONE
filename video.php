<?php
session_start();
include "db.php";

if(!isset($_GET['id'])){ die("Video not found"); }
$vid=(int)$_GET['id'];

$conn->query("UPDATE videos SET views=views+1 WHERE id=$vid");

$video=$conn->query("SELECT v.*,u.username FROM videos v JOIN users u ON v.user_id=u.id WHERE v.id=$vid")->fetch_assoc();

if(!$video){ die("Video not found"); }

if(isset($_POST['like']) && isset($_SESSION['user_id'])){
    $uid=$_SESSION['user_id'];
    $conn->query("INSERT IGNORE INTO likes(user_id,video_id) VALUES($uid,$vid)");
}
if(isset($_POST['comment']) && isset($_SESSION['user_id'])){
    $uid=$_SESSION['user_id'];
    $text=htmlspecialchars($_POST['comment']);
    $stmt=$conn->prepare("INSERT INTO comments(user_id,video_id,comment) VALUES(?,?,?)");
    $stmt->bind_param("iis",$uid,$vid,$text);
    $stmt->execute();
}

$likes=$conn->query("SELECT COUNT(*) c FROM likes WHERE video_id=$vid")->fetch_assoc()['c'];
$comments=$conn->query("SELECT c.*,u.username FROM comments c JOIN users u ON c.user_id=u.id WHERE c.video_id=$vid ORDER BY c.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$video['title']?></title>
<style>
body{font-family:Arial;background:#111;color:#fff;margin:0}
.container{padding:20px}
video{width:100%;max-height:500px;background:#000}
h2{margin:10px 0}
button{padding:8px 16px;background:red;color:#fff;border:none;border-radius:5px;cursor:pointer;margin:5px}
button:hover{background:#cc0000}
.comment-box{background:#222;padding:10px;border-radius:5px;margin:10px 0}
.comment-box p{margin:0}
</style>
</head>
<body>
<div class="container">
  <video controls>
    <source src="uploads/<?=$video['filename']?>" type="video/mp4">
  </video>
  <h2><?=htmlspecialchars($video['title'])?></h2>
  <p>By <?=$video['username']?> | <?=$video['views']?> views</p>

  <form method="post">
    <button name="like">👍 Like (<?=$likes?>)</button>
  </form>

  <h3>Comments</h3>
  <?php if(isset($_SESSION['user_id'])): ?>
  <form method="post">
    <textarea name="comment" placeholder="Write a comment..." required></textarea><br>
    <button type="submit">Post Comment</button>
  </form>
  <?php else: ?>
  <p><a href="login.php" style="color:red">Login</a> to comment</p>
  <?php endif; ?>

  <?php while($c=$comments->fetch_assoc()): ?>
  <div class="comment-box">
    <p><b><?=$c['username']?>:</b> <?=$c['comment']?></p>
  </div>
  <?php endwhile; ?>
</div>
</body>
</html>
