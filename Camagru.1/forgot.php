<?php session_start();
echo "DUMBASS.";

$mail = $_POST["email"];
echo "<br>".$mail;
function activeEmail($mail) {
$message = ' 
Click on link below to reset your password:
http://localhost:8080/new/Camagru/reset.php?email='.$mail;
$message = wordwrap($message, 100, "\r\n");
mail( $_POST['email'] , 'Activation link' , $message);
echo '<script>alert("Pls check email.")</script>';
}
try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT `userID` FROM `users` WHERE `E-mail` = :email");
    $stmt->bindValue(':email', $mail);
    $stmt->execute();
    $con=null;
    if ($stmt->rowCount() > 0)
    {
        activeEmail($mail);
    }
    else{
        echo '<script>alert("User does not exist.")</script>';
    }
}
catch (PDOException $e) {
    print "Error : ".$e->getMessage()."<br/>";
    die();
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
    <form action="forgot.php" method="post">
        <fieldset>
    <br><label for="email"><b>Email</b></label><br>
      <input type="text" placeholder="Enter Email" name="email" required><br>
        <br><input type=submit><button onclick="Cancel()">Cancel</button>
</fieldset>
    </form>
</body>
</html>

<script>
    function Cancel()
    {
        window.location.href = "index.php";
    }
    </script>