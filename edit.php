<?php include 'db.php';
$id=$_GET['id'];
$data=$conn->query("SELECT * FROM CatBreeds WHERE id=$id")->fetch_assoc();
?>

<form method="post" enctype="multipart/form-data">
ชื่อไทย: <input name="name_th" value="<?=$data['name_th']?>">
ชื่ออังกฤษ: <input name="name_en" value="<?=$data['name_en']?>">
รายละเอียด: <textarea name="description"><?=$data['description']?></textarea>
นิสัย: <textarea name="characteristics"><?=$data['characteristics']?></textarea>
การดูแล: <textarea name="care_instructions"><?=$data['care_instructions']?></textarea>
รูปใหม่: <input type="file" name="image">
<button name="update">อัปเดต</button>
</form>

<?php
if(isset($_POST['update'])){
 $name_th=$_POST['name_th'];
 $name_en=$_POST['name_en'];
 $desc=$_POST['description'];
 $char=$_POST['characteristics'];
 $care=$_POST['care_instructions'];

 if($_FILES['image']['name']!=""){
   $img=$_FILES['image']['name'];
   $path="uploads/".$img;
   move_uploaded_file($_FILES['image']['tmp_name'],$path);
   $conn->query("UPDATE CatBreeds SET image_url='$path' WHERE id=$id");
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
