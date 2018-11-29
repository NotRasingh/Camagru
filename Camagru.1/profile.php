<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <script src="js/myjs.js"></script>
</head>
<body>
<div class="navbar">
    <?php
    if(isset($_SESSION['loggedin']))
    {
        echo " <span id='open' onclick='openNav()'>&#9776; </span>";
        echo "<button id='logout' onclick='logout()' class='loginbtn'>Logout</button>";
         echo "<button id='test' onclick='edit()' class='loginbtn'>Edit Profile</button>";
    }
    else
    {
        echo "<button onclick='register()' class='registerbtn'>Register</button>";
        echo "<button  onclick='showmodal()' class='loginbtn'>Login</button>";
    }
    ?>
</div>

<div id="mySidenav" class="sidenav" onload="shownav()"> 
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="profile.php">My Profile</a> 
    <a href="upload.php">Upload</a>   
</div>
<br><br>
<div style="margin:auto;width:610px">
<?php
try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `gallery` where userID=:id");
    $stmt->bindParam(':id', $_SESSION['id']);
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
?>
    </div>
</body>
</html>

<script>

function edit(){
    window.location.href = 'edit.php';
}


function showpicmodal(_src, theid){

var img = document.getElementById(theid);
var modalImg = document.getElementById("img01");

const form = document.createElement('form');
form.action = 'test.php';
form.method = 'post';

const homeInput = document.createElement('input');
homeInput.type = 'hidden';
homeInput.name = 'src';
homeInput.value = _src;
form.appendChild(homeInput);
document.body.appendChild(form);
form.submit();
document.getElementById("id02").style.display = "block";
}

modal = document.getElementById("id02");
window.onclick = function(event) {
if (event.target == modal) {
   modal.style.display = "none";
}
}

</script>