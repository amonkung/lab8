<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>สายพันธุ์แมว</title>
<style>
body{font-family:sans-serif;background:#fff0f6;margin:0}
h1{text-align:center;color:#ff4d6d;margin-top:60px}

/* ปุ่ม admin */
.admin-btn{
  position:fixed;
  top:15px;
  right:15px;
  background:#ff4d6d;
  color:white;
  padding:10px 18px;
  border-radius:20px;
  text-decoration:none;
  box-shadow:0 4px 10px rgba(0,0,0,0.2);
  font-weight:bold;
}
.admin-btn:hover{
  background:#ff1f4d;
}

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:20px;
  padding:20px
}
.card{
  background:#fff;
  border-radius:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.1);
  overflow:hidden
}
.card img{
  width:100%;
  height:200px;
  object-fit:cover
}
.card .content{
  padding:15px
}
</style>
</head>
<body>

<!-- ปุ่มไปหน้า admin -->
<a href="admin.php" class="admin-btn">⚙ Admin</a>

<h1>🐾 สายพันธุ์แมว</h1>

<div class="grid">
<?php
$res=$conn->query("SELECT * FROM CatBreeds WHERE is_visible=1");
while($row=$res->fetch_assoc()){
?>
<div class="card">
  <img src="<?=$row['image_url']?>">
  <div class="content">
    <h3><?=$row['name_th']?> (<?=$row['name_en']?>)</h3>
    <p><b>รายละเอียด:</b> <?=$row['description']?></p>
    <p><b>นิสัย:</b> <?=$row['characteristics']?></p>
    <p><b>การดูแล:</b> <?=$row['care_instructions']?></p>
  </div>
</div>
<?php } ?>
</div>

</body>
</html>
