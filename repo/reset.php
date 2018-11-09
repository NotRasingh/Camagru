<?php
session_start();
var_dump($_POST);
if (isset($_GET["email"]))
    {
        $_SESSION["forgot"] = $_GET["email"];
    }
    $mail =  $_SESSION["forgot"] ;
$pass = $_POST["newpass"];
$new = $_POST["confirm"];
echo "MAIL." .$mail."<br>";
if (isset($_POST["confirm"]))
{
try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT `userID` FROM `users` WHERE `E-mail` = :email");
    $stmt->bindValue(':email', $mail);
    $stmt->execute();
    $con = null;
    echo "COUNT: ".$stmt->rowCount();
    if ($stmt->rowCount() > 0)
    {
        if (strcmp($pass,$new))
        {
            echo "<script>alert('Passwotds do not match');</script>";
        }
        else
        {
            $con = new PDO("mysql:host=localhost", "root", "123456");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->query("USE camagru");
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            echo "test";
            $stmt = $con->prepare("UPDATE `users` SET `Pass`=:pass WHERE `E-mail` = :email");
            $stmt->bindValue(':email', $mail);
            $stmt->bindValue(':pass', $pass);
            $stmt->execute();
            $con=null;
 /*            echo "<meta http-equiv='refresh' content='0,url=index.php'>"; */
            echo '<script>alert("Your password has been changed successfully")</script>';
        }
    }
}
catch (PDOException $e) {
    print "Error : ".$e->getMessage()."<br/>";
    die();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="reset.php" method="post">
        <fieldset>
        <br><label for="newpass"><b>Password</b></label><br>
      <input type="password" placeholder="Enter Password" name="newpass" required><br>
      <br><label for="confirm"><b>Repeat Password</b></label><br>
      <input type="password" placeholder="Repeat Password" name="confirm" required><br>
      <br><button type="submit">Reset Password</button>
        </fieldset>
    </form>
</body>
</html>