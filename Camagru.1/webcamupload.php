<?php
session_start();
$data = explode( ',', $_POST["img64"] );
$test = base64_decode($data[1]);
$sticker = $_POST["sticker"];
$x;
$y;
$pos1;
$pos2;
$height;
$width;
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

/* file_put_contents("img/gallery/".$newimgID.".png", $test); */
file_put_contents("img/gallery/".$newimgID.".png", $test);
    $dest= imagecreatefrompng("img/gallery/".$newimgID.".png");
    if(!empty($_POST["emoji64"]))
    {
        echo '<script>alert("IN YR LOOP")</script>';
        $emo = explode ('new/Camagru/',$_POST["emoji64"]);   
        $src = imagecreatefrompng($emo[1]);
        $width = ImageSx($src);
        $height = ImageSy($src);
        pic_position($emo);
        ImageCopyResampled($dest,$src,$pos2,$pos1,0,0,$x,$y,$width,$height);
    }
    
    if(!empty($_POST["emoji64_2"]))
    {
        $emo2 = explode ('new/Camagru/',$_POST["emoji64_2"]);
        $src = imagecreatefrompng($emo2[1]);
        $width = ImageSx($src);
        $height = ImageSy($src);
        pic_position($emo2);
        ImageCopyResampled($dest,$src,$pos2,$pos1,0,0,$x,$y,$width,$height);
    }
    
    imagepng($dest, "img/gallery/".$newimgID.".png");

    function pic_position($emo)
    {
        global $x, $y, $width, $height, $pos1, $pos2;

        switch ($emo[1])
        {
            case "img/stickers/1.jpeg" :
                $pos1 = 10;
                $pos2 = 10;
                $x = $width/3; $y = $height/3;
                break;
            case "img/stickers/2.png" :
                $pos1 = 10;
                $pos2 = 200;
                $x = $width/3; $y = $height/3;
                break;
            case "img/stickers/3.jpeg" :
                $pos1 = 10;
                $pos2 = 400;
                $x = $width/3; $y = $height/3;
                break;
            case "img/stickers/4.png" :
                $pos1 = 100;
                $pos2 = 10;
                $x = $width/3; $y = $height/3;
                break;
            case "img/stickers/5.jpeg" :
                $pos1 = 100;
                $pos2 = 200;
                $x = $width/3; $y = $height/3;
                break;
            case "img/stickers/6.png" :
                $pos1 = 100;
                $pos2 = 400;
                $x = $width/4; $y = $height/4;
                break;
        }
    }

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
