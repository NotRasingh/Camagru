<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <link rel="icon" href="img/logotest.png">
    <script src="js/myjs.js"></script>

</head>

<body>
<div id="id01" class="modal">  
  <form class="modal-content animate" action="login.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="usn"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="usn" required>

      <label for="pwd"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pwd" required>
        
      <button type="submit">Login</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw"><a href="forgot.php">Forgot password?</a></span>
    </div>
  </form>
</div>




<div class="navbar">
    <?php
    if(isset($_SESSION['loggedin']))
    {
        echo " <span id='open' onclick='openNav()'>&#9776; </span>";
        echo "<button id='logout' onclick='logout()' class='loginbtn'>Logout</button>";
    }
    else
    {
        echo "<a href=signup.php ><button class='registerbtn'>Register</button></a>";
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
    $stmt = $con->prepare("SELECT * FROM `gallery`");
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

/* function showmodal() {
    document.getElementById("id01").style.display = "block";
} */

</script>