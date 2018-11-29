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
 if (isset($_POST['value']))
 {
    try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $stmt = $con->prepare("SELECT * FROM `gallery` LIMIT 12 OFFSET $_POST[value]");
        $stmt->execute();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                         echo ' 
                            
                                <img onclick="showpicmodal(this.src,this.id)" id='.$row['imgID'].' src="img/gallery/'.$row["img"].'" height="200px" width="200px" class="img-thumnail" />  
                            
                         ';  
                    }  
            }
            catch (PDOException $e) {
                print "Error : ".$e->getMessage()."<br/>";
                die();
            }
 }

 if (isset($_POST["length"]))
 {
    try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $stmt = $con->prepare("SELECT * FROM `gallery`");
        $stmt->execute();
        $num = $stmt->rowCount();
    }
            catch (PDOException $e) {
                print "Error : ".$e->getMessage()."<br/>";
                die();
            }
            echo $num;
 }

?>