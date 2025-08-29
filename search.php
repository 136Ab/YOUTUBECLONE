<?php
session_start();
include "db.php";
$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$videos = $conn->query("SELECT v.*,u.username FROM videos v JOIN users u ON v.user_id=u.id WHERE v.title LIKE '%$q%' OR v.category LIKE '%$q%'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<style>
body{font-family:Arial;background:#111;color:#fff}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px;padding:20px}
.card{background:#222;border-radius:8px;overflow:hidden;cursor:pointer}
.card img{width:100%;height:150px;object-fit:cover}
.card h3{margin:10px}
.card p{margin:0 10px 10px;font-size:13px;color:#aaa}
</style>
</head>
<body>
<h1 style="padding:20px">Search Results for "<?=$q?>"</h1>
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
