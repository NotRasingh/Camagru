<?php
session_start();
var_dump($_POST);
try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("DELETE FROM `gallery` WHERE `imgID` = :img");
    $stmt->bindValue(':img', $_POST['imgID']);
    $stmt->execute();
    $con = null;
}
catch (PDOException $e) {
    print "Error : ".$e->getMessage()."<br/>";
    die();
}
echo "<meta http-equiv='refresh' content='0,url=index.php'>";
echo '<script type="text/javascript">alert("Posts has been successfully deleted.")</script>';
?>