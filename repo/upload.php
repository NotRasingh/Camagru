<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Upload Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <script src="js/myjs.js"></script>
    <style>
        video{
    display: inline-block;
    background-color:grey;
    height: 480px;
    width: 640px;
}
canvas{
    display:inline-block;
    background-color: lightgray;
    height: 480px;
    width: 640px;
}

#overlay {
    position: absolute;
    display: none;
    width: 20%;
    height: 20%;
    top: 100;
    left: 60;
    right: 70;
    bottom: 30;
    z-index: 2;
   
    
    cursor: pointer;

}

#text{
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: white;
    /* transform: translate(-50%,-50%); */
    /* -ms-transform: translate(-50%,-50%); */
}

        </style>
</head>
<body onload="Webcam()">

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
<br>
<div style="float:right;border: solid;width:200px;height:608px;margin:auto"> 
<?php
try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `gallery` where userID=:id ORDER BY imgID DESC LIMIT 3");
    $stmt->bindParam(':id', $_SESSION['id']);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                     echo '  
                     <img src="img/gallery/'.$row["img"].'" height="200px" width="200px" class="img-thumnail" />  
                     ';  
                }  
        }
        catch (PDOException $e) {
            print "Error : ".$e->getMessage()."<br/>";
            die();
        }
?>
</div>
<div id="mySidenav" class="sidenav" onload="shownav()"> 
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="profile.php">My Profile</a> 
    <a href="upload.php">Upload</a>   
</div>
<br>
<div id="overlay" class="overlay" onclick="off()">
        <img height='100px' class="text" width='100px' id="emoji1" name="emoji1" src="">
        </div>
<video height="480px" width="640px" id="webcamfeed" autoplay></video>
    <canvas height="480px" width="640px" id="snap"></canvas>
    <input type="button" id="takesnap" value="Capture Image"/>
    <button onclick=save() name="submit" id="save" value="Save Image">Save</button>
<div>
    <img id="1" src="img/stickers/1.jpeg">
    <img id="2" src="img/stickers/2.png">
    <img id="3" src="img/stickers/3.jpeg">
    <img id="4" src="img/stickers/4.png">
    <img id="5" src="img/stickers/5.jpeg">
    <img id="6" src="img/stickers/6.png">
</div>
<p>OR</p>
<hr>
    <div class="container" style="width:500px;" action="conupload.php">
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <br>
        <input type="submit" name="insert" id="insert" value="insert">
    </form>
</div>
</body>
</html>

<script>
var videoElement = document.getElementById("webcamfeed");
var captureSnap = document.getElementById("takesnap");
var canvas = document.getElementById("snap");

function getUserMedia(){
    if(navigator.getUserMedia){
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia
        || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        
    } else {
        navigator.getUserMedia = navigator.mediaDevices.getUserMedia;
    }
    return navigator.getUserMedia;
}

    function Webcam(){
    var media = getUserMedia();
    if(media){
        navigator.getUserMedia({video: { width: 640, height: 480}, audio: false}, function(stream){
            
            videoElement.src = window.URL.createObjectURL(stream);
            
        }, function(error){
            //Catch errors and print to the console
            console.log("There was an error in GetUserMedia!!!");
            console.log(error);
        });
    }
}

captureSnap.addEventListener("click", function(){

    /* var othercanvas = document.getElementById("snap"); */
    var context = canvas.getContext('2d');
    context.drawImage(videoElement, 0, 0, 640, 480, 0, 0, 640, 480) ;

});

function save(){
     var othercanvas = document.getElementById('snap');
    var dataURL = othercanvas.toDataURL();
    const form = document.createElement('form');
form.action = 'webcamupload.php';
form.method = 'post';

const homeInput = document.createElement('input');
homeInput.type = 'hidden';
homeInput.name = 'img64';
homeInput.value = dataURL;
const sticker = document.createElement('input');
sticker.type = 'hidden';
sticker.name = 'sticker';
sticker.value = document.getElementById("emoji1").src;
form.appendChild(homeInput);
form.appendChild(sticker);
document.body.appendChild(form);
form.submit(); 
}
/**************************************************************************/
function off() {
    document.getElementById("overlay").style.display = "none";
}

  s1 = document.getElementById("1");
  s1.addEventListener("click", function(){switchsrc(s1);}, false);
  s2 = document.getElementById("2");
  s2.addEventListener("click", function(){switchsrc(s2);}, false);
  s3 = document.getElementById("3");
  s3.addEventListener("click", function(){switchsrc(s3);}, false);
  s4 = document.getElementById("4");
  s4.addEventListener("click", function(){switchsrc(s4);}, false);
  s5 = document.getElementById("5");
  s5.addEventListener("click", function(){switchsrc(s5);}, false);
  s6 = document.getElementById("6");
  s6.addEventListener("click", function(){switchsrc(s6);}, false);
function switchsrc(sticker)
{
    document.getElementById("overlay").style.display = "block";
    var emoswitch = document.getElementById("emoji1");
    var ovl = document.getElementById("overlay");
    switch (sticker.id)
    {
        case "1" :
            emoswitch.setAttribute('src', sticker.src);

            ovl.style.paddingTop = "180px";
            ovl.style.paddingLeft = "30px";
            break;
            case "2" :
        emoswitch.setAttribute('src', sticker.src);
            ovl.style.paddingTop = "170px";
            ovl.style.paddingLeft = "70px";
            break;
            case "3" :
        emoswitch.setAttribute('src', sticker.src);
            ovl.style.paddingTop = "170px";
            ovl.style.paddingLeft = "70px";
            break;
            case "4" :
        emoswitch.setAttribute('src', sticker.src);
            ovl.style.paddingTop = "170px";
            ovl.style.paddingLeft = "70px";
            break;
            case "5" :
        emoswitch.setAttribute('src', sticker.src);
            ovl.style.paddingTop = "170px";
            ovl.style.paddingLeft = "70px";
            break;
        case "6" :
        emoswitch.setAttribute('src', sticker.src);
            ovl.style.paddingTop = "170px";
            ovl.style.paddingLeft = "70px";
            break;
    }
}
</script>