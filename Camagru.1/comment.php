<?php
/////////////ALERT NEEDS TO SHOW ON CORRECT PAGE
session_start();

$comment = $_POST["comment"];
$imgID = $_SESSION["imgID"];

if (isset($_SESSION['username']))
{
 try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
		$stmt = $con->prepare("INSERT INTO `comments` (`imgID`, `comment`, `user`)
		VALUES(:imgID, :comment, :user)");
        $stmt->bindValue(':imgID', $imgID);
        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':user', $_SESSION['username']);
        $stmt->execute();
        $con = null;
	}
	catch (PDOException $e) {
		print "Error : ".$e->getMessage()."<br/>";
		die();
    } ;
    try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
		$stmt = $con->prepare("SELECT `chbx`, `E-mail` FROM `users` WHERE `userID` = :user");
        $stmt->bindValue(':user', $_SESSION['id']);
        $stmt->execute();
        $res = $stmt->fetch();
        $con = null;
	}
	catch (PDOException $e) {
		print "Error : ".$e->getMessage()."<br/>";
		die();
    }
   
       if ($res['chbx'])
    {
        
        $mail = $res['E-mail'];
        $message = 'SOMEONE COMMENTED ON ONE OF YOUR POSTS';
        $message = wordwrap($message, 100, "\r\n");
        mail($mail , 'NOTIFICATION' , $message);
    } 
} 
else
{
    header('Location: login.php'); 
     exit();
}
 header('Location: test.php'); 
?>