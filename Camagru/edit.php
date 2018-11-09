<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <script src="editjs.js"></script>
</head>
<body>
    
    <form>
    <fieldset>
    Edit Username <br>
    <input type='text' id="uname" placeholder="current username"><br>
    <input type='text' id="newname" placeholder="New username"><br>
    <br><button type="submit">Change Username</button>
    </fieldset>
    </form>
    <br>
     <form>
    <fieldset>
    Edit Password <br>
    <input type='password' id="upass" placeholder="current password"><br>
    <input type='password' id="newpass" placeholder="new password"><br>
    <input type='password' id="connewpass" placeholder="Confirm new password"><br>
    <br><button type="submit">Change Password</button>
    </fieldset>
    </form>
    <br>
     <form>
    <fieldset>
    Edit Email<br>
    <input type='text' id="umail" placeholder="current email"><br>
    <input type='text' id="newmail" placeholder="new email"><br>
    <br><button type="submit">Change Email</button>
    </fieldset>
    </form>
    <br>
    <?php
    $user = $_SESSION['username'];
     try{
        $con = new PDO("mysql:host=localhost", "root", "123456");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->query("USE camagru");
        $stmt = $con->prepare("SELECT * FROM `users` WHERE `User` = :username");
        $stmt->bindValue(':username', $user);
        $stmt->execute();
        $res = $stmt->fetch();
        $con = null;
    }
    catch (PDOException $e) {
        print "Error : ".$e->getMessage()."<br/>";
        die();
    }
    echo "
        <input onclick='testfunc()' type='checkbox' id='chbx'  name='chbx'>
        <label for='chbx'>Receive notifications<label>
        ";
    /* if ($res["chbx"])
    {
        echo "
        <input type='checkbox' id='chbx'  name='chbx' checked>
        <label for='chbx'>Receive notifications<label>
        ";
    }
    else
    {
    echo 

    "
    <input type='checkbox' id='chbx' name='chbx' >
    <label for='chbx'>Receive notifications<label>
    ";
    } */

    // echo "<script>checkcheck();</script>";
    //NEED TO POST CHECBOX VALUE TO PHP USING AJAX OR SUMN
    ?>

</body>
</html>

<script>
    var box = document.getElementById("chbx");
    window.onload = function() {
        //alert(box.value);
        checkcheck();
       

    }
    function testfunc()
{
    var xhr = new XMLHttpRequest();
   var url = "ajaxfuncs.php";
    if (box.checked)
    {
        var notify = 1;
    }
    else
    {
        var notify = 0;
    }
    var newvars="notify="+notify;
   xhr.open("POST", url, true);
   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(newvars);  
}
       // cbx.addEventListener("change", notifsub(cbx), false);
    /* if (box.checked)
     {
         alert(box.value);
     }
     else
     {
         alert(box.value);
        alert("NAH."); 
     } */

     //checkcheck

</script>