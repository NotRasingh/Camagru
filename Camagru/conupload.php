<?php
session_start();
$id = $_SESSION['id'];
if(isset($_POST['insert']))
{
    $file = basename($_FILES["image"]["name"]);
    $path = "img/gallery/".$file;
    copy($_FILES["image"]["tmp_name"], $path);
    echo $path;
    try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
		$stmt = $con->prepare("INSERT INTO `gallery` (`userID`, `img`)
		VALUES(:user, :img)");
        $stmt->bindValue(':user', $id);
        $stmt->bindValue(':img', $file);
        $stmt->execute();
        $con = null;
        echo "<script>alert('DONE!')</script>";
        $_POST['insert'] = null;
	}
	catch (PDOException $e) {
		print "Error : ".$e->getMessage()."<br/>";
		die();
	}
}
Header('Location: index.php');
?>