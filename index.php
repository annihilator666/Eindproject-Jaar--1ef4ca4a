<?php
session_start();

if (!isset($_SESSION['access_level'])) {
    header("Location: login/index.php");   
}
else  {
    header("Location: sendmail/bitmail/index.php"); 
}

