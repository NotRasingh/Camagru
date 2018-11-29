<?php
session_start();
$imgsrc = explode("/", $_SESSION["url"]); ////filename cannot contain foward slash
$_SESSION['img'] = $imgsrc[7];
 try{
     $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `gallery` WHERE `img`= :img"); /////
    $stmt->bindParam(':img', $imgsrc[7]);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $_SESSION['imgID'] = $row['imgID'];
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
     <div class="container">
    <table style="float:center">
    <td>
    <form  method="post" action="comment.php">
        <?php
         echo '<img height="500" width="500" class="img-thumnail" id="img01" src=img/gallery/'.$imgsrc[7].'>';
        ?>
    
    <input type="hidden" name="imgID" id="hidden">
    </td>
    <td>
    <div style="border-style: ridge;background-color: white;height:10cm;width:8cm;overflow:auto">
    <ul>
      <?php
 try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `comments` WHERE `imgID`= :img");
    $stmt->bindParam(':img', $_SESSION['imgID']);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        
        echo $row['user'].': '.htmlentities($row['comment']).'<br>';
    }
}
        catch (PDOException $e) {
            print "Error : ".$e->getMessage()."<br/>";
            die();
        }
    ?> 
    </ul>
</div>
  <input style="width: 200"type="text" name="comment" placeholder="Enter Comment" required>
  <?php
    echo '<input type=hidden name="imgID" value='.$_SESSION['imgID'].'>';
  ?>
  
    <input type="submit">
    </form>
    </td>
    </table>
    <form action="like.php" method ="post">
    <button type="submit" class="btn btn-default btn-sm">
         <img src="img/test.png"height="20" width="20"> Like
        </button>
        </form>
       <?php
         try{
    $con = new PDO("mysql:host=localhost", "root", "123456");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->query("USE camagru");
    $stmt = $con->prepare("SELECT * FROM `likes` WHERE `imgID`= :img");
    $stmt->bindParam(':img', $_SESSION['imgID']);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num == 1)
        echo ' <label>'.$num.' Like</label>';
    else
       echo ' <label>'.$num.' Likes</label>'; 
}
        catch (PDOException $e) {
            print "Error : ".$e->getMessage()."<br/>";
            die();
        }
        try{
            $con = new PDO("mysql:host=localhost", "root", "123456");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->query("USE camagru");
            $stmt = $con->prepare("SELECT `userID` FROM `gallery` where imgID=:id");
            $stmt->bindParam(':id', $_SESSION['imgID']);
            $stmt->execute();
            $res = $stmt->fetch();
            if ($res["userID"] == $_SESSION['id'])
            {
                echo "<br> 
                <form action=delete.php method='POST'>
                <input type='hidden' value='".$_SESSION['imgID']."' name='imgID'>
                <button><b>DELETE</b></button>
                </form>";
                ////NEED TO SEND INFO THROUGH TO DELETE SPECIFIED IMAGE 
            }
            $con=null;
        }
                catch (PDOException $e) {
                    print "Error : ".$e->getMessage()."<br/>";
                    die();
                }
        ?>
</body>
</html>