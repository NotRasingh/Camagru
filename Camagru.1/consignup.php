<?php
///////////////////////////////////////ALERTS NEED TO BE ON SIGN UP PPAGE SOMEHOW
session_start();
    require_once('config/database.php');

    $user = $_POST['user'];
    $pass = $_POST['newpass'];
    $confirm = $_POST['confirm'];
    $mail = $_POST['email'];
    if (strlen($pass) < 6)
    {
       
        echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
         echo '<script type="text/javascript">alert("Password must be at least 6 characters")</script>';
         exit();
    }
    else if (strcmp($pass,$confirm))
    {
        echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
        echo '<script>alert("Passwords do not match")</script>';
        exit();
    }
    else if (strlen($user) <= 3 || strlen($user) >= 25)
    {
        echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
        echo '<script>alert("User name must be between 3 and 25 characters")</script>';
        exit();
    }
    else if (!(preg_match('/[A-Z]/', $pass)))
    {
       echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
        echo '<script>alert("Password must contain at least one capital letter")</script>';
        exit();
    }
    else if (!(filter_var($mail, FILTER_VALIDATE_EMAIL)))
    {
        echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
        echo '<script>alert("Please enter a valid email address")</script>';
        exit();
    }
        try{
            $con = new PDO("mysql:host=localhost", "root", "123456");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->query("USE camagru");
            $stmt = $con->prepare("SELECT `userID` FROM `users` WHERE `E-mail` = :email");
            $stmt->bindValue(':email', $mail);
            $stmt->execute();
            $con = null;
            if ($stmt->rowCount() > 0)
            {
                echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
                echo '<script>alert("Email address already exists in database")</script>';
                exit();
            }
        }
        catch (PDOException $e) {
            print "Error : ".$e->getMessage()."<br/>";
            die();
        }
        try{
            $con = new PDO("mysql:host=localhost", "root", "123456");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->query("USE camagru");
            $stmt = $con->prepare("SELECT `userID` FROM `users` WHERE `User` = :username");
            $stmt->bindValue(':username', $user);
            $stmt->execute();
            $con = null;
            if ($stmt->rowCount() > 0)
            {
                echo "<meta http-equiv='refresh' content='0,url=signup.php'>";
                echo '<script>alert("Username taken.")</script>';
                exit();
            }
        }
        catch (PDOException $e) {
            print "Error : ".$e->getMessage()."<br/>";
            die();
        }
try{
        $token = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890!$()*";
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $encrypt = password_hash($pass, PASSWORD_BCRYPT);
		$stmt = $con->prepare("INSERT INTO `users` (`User`, `Pass`, `E-mail`, `Active`, `token`)
		VALUES(:user, :pass, :email, '0', :token)");
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':pass', $encrypt);
        $stmt->bindValue(':email', $mail);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $con = null;
     
	}
	catch (PDOException $e) {
		print "Error : ".$e->getMessage()."<br/>";
		die();
    }
    
    activeEmail($token,$mail);
    function activEmail($token, $mail) {
    $message = ' 
    Click on link below to activate account:
    http://localhost:8080/new/Camagru/active.php?token='.$token.'&email='.$mail;
    $message = wordwrap($message, 100, "\r\n");
    mail( $_POST['email'] , 'Activation link' , $message);
    echo '<script>alert("Pls check email.")</script>';
    }
 

?>
