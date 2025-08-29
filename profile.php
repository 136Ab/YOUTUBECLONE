<?php
session_start();
include "db.php";
if(!isset($_SESSION['user_id'])){ echo "<script>window.location.href='login.php';</script>"; exit; }

$uid=$_SESSION['user_id'];
$user=$conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$videos=$conn->query("SELECT * FROM videos WHERE user_id=$uid ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<style>
body{font-family:Arial;background:#111;color:#fff;margin:0}
.container{padding:20px}
.card{background:#222;margin:10px;padding:10px;border-radius:5px}
</style>
</head>
<body>
<div class="container">
  <h1><?=$user['username']?>'s Profile</h1>
  <h3>Your Videos</h3>
  <?php while($v=$videos->fetch_assoc()): ?>
    <div class="card" onclick="window.location.href='video.php?id=<?=$v['id']?>'">
      <p><b><?=$v['title']?></b> - <?=$v['views']?> views</p>
    </div>
  <?php endwhile; ?>
</div>
</body>
</html>
