<?php
session_start();
if (isset($_POST['mypostname']))
{
    try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT `chbx` FROM `users` WHERE `userID` = :user");
    $stmt->bindValue(':user', $_SESSION['id']);
    $stmt->execute();
    $res = $stmt->fetch();
    $con = null;
    echo $res["chbx"];
}
catch (PDOException $e) {
    print "Error : ".$e->getMessage()."<br/>";
    die();
}
}

if (isset($_POST['notify']))
{
    try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $stmt = $con->prepare("UPDATE `users` SET `chbx` = :chbx WHERE `userID` = :user");
        $stmt->bindValue(':user', $_SESSION['id']);
        $stmt->bindValue(':chbx', $_POST['notify']);
        $stmt->execute();
        $con = null;
    }
    catch (PDOException $e) {
        print "Error : ".$e->getMessage()."<br/>";
        die();
    }   
}


?>