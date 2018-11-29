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
<!--     <script src="js/myjs.js"></script>
  -->   <script src="js/pic.js"></script>
<!--     <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />  -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/pic.css" />
    <style>
/*         video{
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
    // transform: translate(-50%,-50%); 
    //-ms-transform: translate(-50%,-50%); 
} */

        </style>
</head>
<body > <!-- onload="Webcam()" -->

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
<!-- <div id="overlay" class="overlay" onclick="off()">
        <img height='100px' class="text" width='100px' id="emoji1" name="emoji1" src="">
        </div>

    <canvas height="480px" width="640px" id="snap"></canvas>
    <input type="button" id="takesnap" value="Capture Image"/> -->
    <div class="top_container">
			<div id="overlay" class="overlay">
				<img class="text" height='100px' width='100px' id="emoji1" name="emoji1" onclick="off()">
				<img onclick="off2()" class="text" height='100px' width='100px' id="emoji2" name="emoji2"  >
			</div>
			<div class="video">
            <video height="480px" width="640px" id="video" autoplay></video>
				<img class="uploaded_image" height='375px' width='500px' id="uploaded_image" name="uploaded_image">
			</div>
			<div class="emo_list">
			<img id="e1" src="img/stickers/1.jpeg" height='50px' width='50px' style="margin: 19px">
			<img id="e2" src="img/stickers/2.png" height='50px' width='50px' style="margin: 19px">
			<img id="e3" src="img/stickers/3.jpeg" height='50px' width='50px' style="margin: 19px">
			<img id="e4" src="img/stickers/4.png" height='50px' width='50px' style="margin: 19px">
			<img id="e5" src="img/stickers/5.jpeg" height='50px' width='50px' style="margin: 19px">
			<img id="e6" src="img/stickers/6.png" height='50px' width='50px' style="margin: 19px">
			<br>
			</div>
			<button id="photo_button" class="button">Take Photo</button>
			<button id="Uploadbtn" class="button">Upload</button>
			<input type="file" id="fileupload" style="display: none" accept="image/*">
			<canvas id="canvas2"></canvas>
			<button id="save_photo" class="button">save</button>
			<canvas id="canvas"></canvas>
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
/* var videoElement = document.getElementById("webcamfeed");
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
} */

/* captureSnap.addEventListener("click", function(){

    // var othercanvas = document.getElementById("snap"); 
    var context = canvas.getContext('2d');
    context.drawImage(videoElement, 0, 0, 640, 480, 0, 0, 640, 480) ;

}); */

/* function save(){
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
} */

/**************************************************************************/
function off() {
		document.getElementById("emoji1").style.visibility = "hidden";
		document.getElementById("emoji1").removeAttribute('src');

	}
	function off2() {
		document.getElementById("emoji2").style.visibility = "hidden";
		document.getElementById("emoji2").removeAttribute('src');

	}

	emo1 = document.getElementById("e1");
	emo2 = document.getElementById("e2");
	emo3 = document.getElementById("e3");
	emo4 = document.getElementById("e4");
	emo5 = document.getElementById("e5");
	emo6 = document.getElementById("e6");
/* 	emo7 = document.getElementById("e7");
	emo8 = document.getElementById("e8");
	emo9 = document.getElementById("e9");
	emo10 = document.getElementById("e10"); */
	
	emo1.addEventListener("click", function(){switchsrc(emo1);}, false);
	emo2.addEventListener("click", function(){switchsrc(emo2);}, false);
	emo3.addEventListener("click", function(){switchsrc(emo3);}, false);
	emo4.addEventListener("click", function(){switchsrc(emo4);}, false);
	emo5.addEventListener("click", function(){switchsrc(emo5);}, false);
	emo6.addEventListener("click", function(){switchsrc(emo6);}, false);
/* 	emo7.addEventListener("click", function(){switchsrc(emo7);}, false);
	emo8.addEventListener("click", function(){switchsrc(emo8);}, false);
	emo9.addEventListener("click", function(){switchsrc(emo9);}, false);
	emo10.addEventListener("click", function(){switchsrc(emo10);}, false); */

	function switchsrc(emonew)
	{
		document.getElementById("emoji1").style.visibility = "visible";
		if (document.getElementById("emoji1").hasAttribute("src"))
		{
			document.getElementById("emoji2").style.visibility = "visible";
			var emoswitch = document.getElementById("emoji2");
		}
		else
		{
			var emoswitch = document.getElementById("emoji1");
		}
		var ovl = document.getElementById("overlay");
		switch (emonew.id)
		{
			case "e1" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "10px";
				emoswitch.style.left = "10px";
				break;
			case "e2" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "10px";
				emoswitch.style.left = "200px";
				break;
			case "e3" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "10px";
				emoswitch.style.left = "400px";
				break;
			case "e4" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "100px";
				emoswitch.style.left = "10px";
				break;
			case "e5" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "100px";
				emoswitch.style.left = "200px";
				break;
			case "e6" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "100px";
				emoswitch.style.left = "400px";
				break;
/* 			case "e7" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "250px";
				emoswitch.style.left = "10px";
				break;
			case "e8" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "250px";
				emoswitch.style.left = "200px";
				break;
			case "e9" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "250px";
				emoswitch.style.left = "400px";
				break;
			case "e10" :
				emoswitch.setAttribute('src', emonew.src);
				emoswitch.style.top = "100px";
				emoswitch.style.left = "200px";
				break; */
		}
	} 
/**************************************************************************/
/* function off() {
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
} */
/* window.onload = function () {

let width = 500,
    height = 0,
    streaming = false;

video = document.getElementById('video');
const canvas1 = document.getElementById('canvas');
const canvas2 = document.getElementById('canvas2');
const photo_button = document.getElementById('photo_button');
const save_photo = document.getElementById('save_photo');
const uploadbtn = document.getElementById('Uploadbtn');

navigator.mediaDevices.getUserMedia({ video: true, audio: false })

    .then(function (stream) {
        video.srcObject = stream;
        video.play();
    })

    .catch(function (err) {
        console.log(`Error: ${err}`);
    });

video.addEventListener('canplay', function (e) {
    if (!streaming) {

        height = video.videoHeight / (video.videoWidth / width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        canvas2.setAttribute('width', width);
        canvas2.setAttribute('height', height);

        streaming = true;
    }
}, false);

photo_button.addEventListener('click', function (e) {
    document.getElementById("save_photo").style.display = "block";
    document.getElementById("canvas2").style.display = "block";
    takepicture();
    preview();
    e.preventDefault()
}, false);

save_photo.addEventListener('click', function (e) {
    savepic();
    e.preventDefault();
}, false);
canvas2.addEventListener('click', function (e) {
    document.getElementById("canvas2").style.display = "none";
    document.getElementById("save_photo").style.display = "none";
    e.preventDefault();
}, false);


function takepicture() {
    const context1 = canvas1.getContext('2d');

    if (width && height) {
        canvas1.width = width;
        canvas1.height = height;
        context1.drawImage(video, 0, 0, width, height);

    }
}
function preview() {
    const context2 = canvas2.getContext('2d');
    if (width && height) {
        canvas2.width = width;
        canvas2.height = height;
        context2.drawImage(video, 0, 0, width, height);
        if (document.getElementById("emoji1").hasAttribute("src")) {
            var emoji1 = document.getElementById("emoji1");
            var left = parseInt(emoji1.style.left);
            var top = parseInt(emoji1.style.top);
            context2.drawImage(emoji1, left, top, 100, 100);
        }
        if (document.getElementById("emoji2").hasAttribute("src")) {
            var emoji2 = document.getElementById("emoji2");
            var left2 = parseInt(emoji2.style.left);
            var top2 = parseInt(emoji2.style.top);
            context2.drawImage(emoji2, left2, top2, 100, 100);
        }
    }
}

function savepic() {
    var dataURL = canvas.toDataURL();
    var emoji = document.getElementById("emoji1").src;
    const form = document.createElement('form');
    form.action = 'webcamupload.php';
    form.method = 'post';
    const myogimage = document.createElement('input');
    const myoverlay = document.createElement('input');
    myogimage.type = 'hidden';
    myogimage.name = 'img64';
    myogimage.value = dataURL;
    myoverlay.type = 'hidden';
    myoverlay.name = 'emoji64';
    myoverlay.value = emoji;
    if (document.getElementById("emoji2").hasAttribute("src")) {
        var emoji2 = document.getElementById("emoji2").src;
        const myoverlay2 = document.createElement('input');
        myoverlay2.type = 'hidden';
        myoverlay2.name = 'emoji64_2';
        myoverlay2.value = emoji2;
        form.appendChild(myoverlay2);
    }
    form.appendChild(myogimage);
    form.appendChild(myoverlay);
    document.body.appendChild(form);
    form.submit();
}

uploadbtn.addEventListener('click', function () {
    imageupload = document.getElementById("fileupload");
    imageupload.click();
    imageupload.addEventListener('change', function () {
        if (imageupload.files && imageupload.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('uploaded_image').setAttribute('src', e.target.result);
                document.getElementById('uploaded_image').style.display = "block";
                document.getElementById('video').style.display = "none";
                video = document.getElementById('uploaded_image');
            };
            reader.readAsDataURL(imageupload.files[0]);
        }
    });

}, false);
}


 */
</script>