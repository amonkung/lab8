<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin</title>
<style>
body{font-family:sans-serif;background:#f7e9f1}
form{background:#fff;padding:20px;border-radius:15px;width:500px;margin:20px auto}
input,textarea{width:100%;margin-bottom:8px}
table{width:95%;margin:auto;background:#fff}
img{width:80px}
</style>
</head>
<body>

<h2 align="center">🐱 Admin - จัดการสายพันธุ์แมว</h2>

<form method="post" enctype="multipart/form-data">
ชื่อไทย: <input name="name_th" required>
ชื่ออังกฤษ: <input name="name_en" required>
รายละเอียด: <textarea name="description"></textarea>
นิสัย: <textarea name="characteristics"></textarea>
การดูแล: <textarea name="care_instructions"></textarea>
รูป: <input type="file" name="image" required>
<button name="save">บันทึก</button>
</form>

<?php
if(isset($_POST['save'])){
 $name_th=$_POST['name_th'];
 $name_en=$_POST['name_en'];
 $desc=$_POST['description'];
 $char=$_POST['characteristics'];
 $care=$_POST['care_instructions'];

 $img=$_FILES['image']['name'];
 $path="uploads/".$img;
 move_uploaded_file($_FILES['image']['tmp_name'],$path);

 $conn->query("INSERT INTO CatBreeds
 (name_th,name_en,description,characteristics,care_instructions,image_url)
 VALUES('$name_th','$name_en','$desc','$char','$care','$path')");
}
?>

<table border="1" cellpadding="8">
<tr>
<th>รูป</th><th>ชื่อ</th><th>สถานะ</th><th>จัดการ</th>
</tr>
<?php
$res=$conn->query("SELECT * FROM CatBreeds");
while($row=$res->fetch_assoc()){
?>
<tr>
<td><img src="<?=$row['image_url']?>"></td>
<td><?=$row['name_th']?></td>
<td><?=$row['is_visible']?"แสดง":"ซ่อน"?></td>
<td>
<a href="edit.php?id=<?=$row['id']?>">แก้ไข</a> |
<a href="toggle.php?id=<?=$row['id']?>">ซ่อน/แสดง</a> |
<a href="delete.php?id=<?=$row['id']?>">ลบ</a>
</td>
</tr>
<?php } ?>
</table>

</body>
</html>
