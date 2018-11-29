<?php
/////////////ALERT NEEDS TO SHOW ON CORRECT PAGE
session_start();
if (isset($_SESSION['username']))
{
try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $encrypt = password_hash($pass, PASSWORD_BCRYPT);
		$stmt = $con->prepare("INSERT INTO `likes` (`imgID`, `UserID`)
		VALUES(:img, :user)");
        $stmt->bindValue(':img', $_SESSION['imgID']);
        $stmt->bindValue(':user', $_SESSION['id']);
        $stmt->execute();
        $con = null;
	}
	catch (PDOException $e) {
		print "Error : ".$e->getMessage()."<br/>";
		die();
	}
}
    else
{
    echo '<script>alert("Please sign in to like")</script>';
}
header('Location: info.php');
?>