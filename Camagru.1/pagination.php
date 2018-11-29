<?php session_start();
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