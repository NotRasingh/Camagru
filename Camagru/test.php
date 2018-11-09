<?php
session_start();
if (isset($_POST['src']))
{
    $_SESSION['url'] = $_POST['src'];
}
header('Location: info.php');
?>