<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <style>
        body
        {
           background-image : url("img/bg.jpg");
           align-content: center;
        }
        form
        {
            padding: 150px;
            font-display: white;
             margin:auto;
             display:table;
             text-align: left;
        }
        </style>
</head>
<body>
    <form action="consignup.php" method="post">
        <fieldset>
        <b>Username</b>
        <br><input type="text" name="user" placeholder="Enter Username" required><br>
       <br><label for="email"><b>Email</b></label><br>
      <input type="text" placeholder="Enter Email" name="email" required><br>
      <br><label for="newpass"><b>Password</b></label><br>
      <input type="password" placeholder="Enter Password" name="newpass" required><br>
      <br><label for="confirm"><b>Repeat Password</b></label><br>
      <input type="password" placeholder="Repeat Password" name="confirm" required><br>
      <br><button type="submit">Sign Up</button>
    </fieldset>
</form>
</body>
</html>