<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin</title>
<style>
body{font-family:sans-serif;background:#f7e9f1;margin:0;padding:20px}

.back-btn{
  display:inline-block;
  background:#ff4d6d;
  color:white;
  padding:8px 15px;
  border-radius:15px;
  text-decoration:none;
  margin-bottom:20px;
  font-weight:bold;
}
.back-btn:hover{background:#ff1f4d}

.header-section{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:30px;
}

.header-section h2{margin:0}

form{background:#fff;padding:20px;border-radius:15px;width:100%;max-width:450px;margin:0 auto 30px;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
input,textarea{width:100%;margin-bottom:8px;padding:8px;border:1px solid #ddd;border-radius:5px;font-family:sans-serif;box-sizing:border-box}
button{background:#ff4d6d;color:white;padding:10px 20px;border:none;border-radius:8px;cursor:pointer;font-weight:bold;width:100%}
button:hover{background:#ff1f4d}

.grid-container{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:15px;
  padding:0
}

.card{
  background:#fff;
  border-radius:12px;
  box-shadow:0 2px 8px rgba(0,0,0,0.1);
  overflow:hidden;
  padding:0;
}

.card img{
  width:100%;
  height:180px;
  object-fit:cover;
  display:block
}

.card-content{
  padding:12px;
}

.card-content h4{
  margin:5px 0;
  font-size:14px;
  color:#333
}

.card-content small{
  display:block;
  font-size:11px;
  color:#666;
  margin-bottom:8px
}

.card-actions{
  display:flex;
  gap:5px;
  font-size:12px
}

.card-actions a{
  flex:1;
  text-align:center;
  padding:6px 5px;
  background:#ff4d6d;
  color:white;
  text-decoration:none;
  border-radius:5px
}

.card-actions a:hover{background:#ff1f4d}

.status-show{background:#4CAF50}
.status-show:hover{background:#45a049}

.status-hide{background:#ff9800}
.status-hide:hover{background:#e68900}
</style>
</head>
<body>

<div class="header-section">
  <h2>🐱 Admin - จัดการสายพันธุ์แมว</h2>
  <a href="index.php" class="back-btn">← กลับหน้าแรก</a>
</div>

<form method="post" enctype="multipart/form-data">
  <h3 style="margin-top:0;text-align:center">เพิ่มสายพันธุ์แมวใหม่</h3>
  <label>ชื่อไทย:</label>
  <input name="name_th" required>
  <label>ชื่ออังกฤษ:</label>
  <input name="name_en" required>
  <label>รายละเอียด:</label>
  <textarea name="description" style="height:60px"></textarea>
  <label>นิสัย:</label>
  <textarea name="characteristics" style="height:60px"></textarea>
  <label>การดูแล:</label>
  <textarea name="care_instructions" style="height:60px"></textarea>
  <label>รูป:</label>
  <input type="file" name="image" required accept="image/*">
  <button name="save">✓ บันทึก</button>
</form>

<?php
if(isset($_POST['save'])){
 $name_th=$_POST['name_th'];
 $name_en=$_POST['name_en'];
 $desc=$_POST['description'];
 $char=$_POST['characteristics'];
 $care=$_POST['care_instructions'];

 // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
 if(!is_dir('uploads')){
   mkdir('uploads',0777,true);
 }

 $img=$_FILES['image']['name'];
 $path="uploads/".time()."_".basename($img);
 if(move_uploaded_file($_FILES['image']['tmp_name'],$path)){
   $conn->query("INSERT INTO CatBreeds
   (name_th,name_en,description,characteristics,care_instructions,image_url)
   VALUES('$name_th','$name_en','$desc','$char','$care','$path')");
   echo "<p style='color:green;text-align:center'>บันทึกสำเร็จ</p>";
 }
}
?>

<h3>รายการแมว (<?php echo $conn->query("SELECT COUNT(*) as cnt FROM CatBreeds")->fetch_assoc()['cnt']; ?> อัน)</h3>

<div class="grid-container">
<?php
$res=$conn->query("SELECT * FROM CatBreeds");
while($row=$res->fetch_assoc()){
  $status = $row['is_visible'] ? "แสดง" : "ซ่อน";
  $statusClass = $row['is_visible'] ? "status-show" : "status-hide";
?>
<div class="card">
  <img src="<?=$row['image_url']?>" alt="<?=$row['name_th']?>">
  <div class="card-content">
    <h4><?=$row['name_th']?><br><small>(<?=$row['name_en']?>)</small></h4>
    <small><b>สถานะ:</b> <?=$status?></small>
    <div class="card-actions">
      <a href="edit.php?id=<?=$row['id']?>">✎ แก้ไข</a>
      <a href="toggle.php?id=<?=$row['id']?>" class="<?=$statusClass?>"><?=$status?></a>
      <a href="delete.php?id=<?=$row['id']?>" onclick="return confirm('ลบจริงหรือ?')">✕ ลบ</a>
    </div>
  </div>
</div>
<?php } ?>
</div>

</body>
</html>
