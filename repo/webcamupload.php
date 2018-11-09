<?php
session_start();
$data = explode( ',', $_POST["img64"] );
$test = base64_decode($data[1]);
$sticker = $_POST["sticker"];
try
{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `gallery` ORDER BY `imgID` DESC LIMIT 1");
    $stmt->bindParam(':img', $_SESSION['imgID']);
    $stmt->execute();
    $num = $stmt->fetch();
    $newimgID = $num["imgID"] + 1 ;
}
catch (PDOException $e) 
{
    print "Error : ".$e->getMessage()."<br/>";
    die();
}

file_put_contents("img/gallery/".$newimgID.".png", $test);
$dest = imagecreatefrompng("img/gallery/".$newimgID.".png");
$src = imagecreatefrompng($sticker);
$width = ImageSx($src);
$height = ImageSy($src);
$x = $width/2; $y = $height/2;
ImageCopyResampled($dest,$src,0,0,0,0,$x,$y,$width,$height);
imagepng($dest,"img/gallery/".$newimgID.".png");

try{
    $id = $_SESSION['id'];
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("INSERT INTO `gallery` (`userID`, `img`)
    VALUES(:user, :img)");
    $stmt->bindValue(':user', $id);
    $stmt->bindValue(':img', $newimgID.".png");
    $stmt->execute();
    $con = null;
}
catch (PDOException $e) 
{
    print "Error : ".$e->getMessage()."<br/>";
    die();
}

header('Location: index.php');
?>
