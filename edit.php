<?php include 'db.php';
$id=$_GET['id'];
$data=$conn->query("SELECT * FROM CatBreeds WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>แก้ไขข้อมูลแมว</title>
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
h2{text-align:center}
form{background:#fff;padding:20px;border-radius:15px;width:100%;max-width:500px;margin:0 auto;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
input,textarea{width:100%;margin-bottom:8px;padding:8px;border:1px solid #ddd;border-radius:5px;font-family:sans-serif;box-sizing:border-box}
label{display:block;margin-top:10px;font-weight:bold;color:#333}
button{background:#ff4d6d;color:white;padding:10px 20px;border:none;border-radius:8px;cursor:pointer;font-weight:bold;width:100%}
button:hover{background:#ff1f4d}
.current-img{max-width:200px;border-radius:10px;margin:10px 0}
.cancel-btn{display:block;text-align:center;padding:10px;margin-top:10px;background:#ccc;color:#333;text-decoration:none;border-radius:8px}
.cancel-btn:hover{background:#999}
</style>
</head>
<body>

<a href="admin.php" class="back-btn">← กลับสู่ Admin</a>

<h2>✎ แก้ไขข้อมูลแมว</h2>

<form method="post" enctype="multipart/form-data">
  <label>ชื่อไทย:</label>
  <input name="name_th" value="<?=$data['name_th']?>" required>
  
  <label>ชื่ออังกฤษ:</label>
  <input name="name_en" value="<?=$data['name_en']?>" required>
  
  <label>รายละเอียด:</label>
  <textarea name="description" style="height:80px"><?=$data['description']?></textarea>
  
  <label>นิสัย:</label>
  <textarea name="characteristics" style="height:80px"><?=$data['characteristics']?></textarea>
  
  <label>การดูแล:</label>
  <textarea name="care_instructions" style="height:80px"><?=$data['care_instructions']?></textarea>
  
  <label>รูปปัจจุบัน:</label>
  <img src="<?=$data['image_url']?>" class="current-img" alt="<?=$data['name_th']?>">
  
  <label>อัปเดตรูปใหม่ (ไม่บังคับ):</label>
  <input type="file" name="image" accept="image/*">
  
  <button name="update">✓ บันทึกการเปลี่ยนแปลง</button>
  <a href="admin.php" class="cancel-btn">ยกเลิก</a>
</form>

<?php
if(isset($_POST['update'])){
 $name_th=$_POST['name_th'];
 $name_en=$_POST['name_en'];
 $desc=$_POST['description'];
 $char=$_POST['characteristics'];
 $care=$_POST['care_instructions'];

 if($_FILES['image']['name']!=""){
   // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
   if(!is_dir('uploads')){
     mkdir('uploads',0777,true);
   }
   
   $img=$_FILES['image']['name'];
   $path="uploads/".time()."_".basename($img);
   if(move_uploaded_file($_FILES['image']['tmp_name'],$path)){
     $conn->query("UPDATE CatBreeds SET image_url='$path' WHERE id=$id");
   }
 }

 $conn->query("UPDATE CatBreeds SET
 name_th='$name_th',
 name_en='$name_en',
 description='$desc',
 characteristics='$char',
 care_instructions='$care'
 WHERE id=$id");

 header("Location: admin.php");
}
?>
