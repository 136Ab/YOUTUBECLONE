<?php
session_start();
include "db.php";
$videos = $conn->query("SELECT videos.*, users.username FROM videos JOIN users ON videos.user_id=users.id ORDER BY views DESC LIMIT 12");
?>
<!DOCTYPE html>
<html>
<head>
<title>YouTube Clone</title>
<style>
body{font-family:Arial;margin:0;background:#111;color:#fff}
header{background:#202020;padding:15px;color:#fff;display:flex;justify-content:space-between;align-items:center}
header h1{color:red;margin:0}
header a{color:#fff;margin:0 10px;text-decoration:none}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px;padding:20px}
.card{background:#222;border-radius:8px;overflow:hidden;cursor:pointer}
.card img{width:100%;height:150px;object-fit:cover}
.card h3{margin:10px}
.card p{margin:0 10px 10px;font-size:13px;color:#aaa}
</style>
</head>
<body>
<header>
  <h1>YouTube</h1>
  <div>
    <?php if(isset($_SESSION['user_id'])): ?>
      <a href="upload.php">Upload</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="signup.php">Signup</a>
    <?php endif; ?>
  </div>
</header>

<div class="grid">
<?php while($row=$videos->fetch_assoc()): ?>
  <div class="card" onclick="window.location.href='video.php?id=<?=$row['id']?>'">
    <img src="uploads/<?=$row['thumbnail']?>" alt="thumb">
    <h3><?=htmlspecialchars($row['title'])?></h3>
    <p>By <?=$row['username']?> | <?=$row['views']?> views</p>
  </div>
<?php endwhile; ?>
</div>
</body>
</html>
