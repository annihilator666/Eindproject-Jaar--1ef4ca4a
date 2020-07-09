<?php

session_start();

require 'vendor/autoload.php';
include 'Mail.Send.Class.php';
require 'load.php';
if (!isset($_SESSION['user_email'])) {
    header("Location: https://projects.bit-academy.nl/~stam/login/index.php");   
}
if (isset($_SESSION['access_level'])) {

?>
<!DOCTYPE html>
<html>
<head>
<title>S.T.A.M</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="output.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&display=swap" rel="stylesheet"> 
    <link href="output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
</head>
<body class="text-white flex h-screen w-screen justify-center stam-gradient bit-font">
    <img class="background-image"src="media/time-lapse-photo-of-stars-on-night-924824.jpg">
    <form method="POST" class="my-5 w-4/5">
        <div class="grid grid-cols-12 min-width- gap-1 p-5 box-color rounded-md">
            <div class="land-mark col-span-12 flex justify-center">S.T.A.M mail form</div>
            <input id="search_data" autocomplete="off" class="p-2 my-3 col-span-10 bit-font input-color" name="email" type="text" placeholder="Email adres (seperate with ',')" required>
            <?php
                if ($_SESSION['access_level'] === 'student' || $_SESSION['access_level'] === 'admin') {
                    ?>
                
                    <div class="col-span-2 flex items-center text-4xl">
                        <input type="checkbox" value="3" name="shuttle3" class="land-mark"/>
                        <label class="text-lg mx-2" for="shuttle3">shuttle 3</label>
                    </div>
                    <?php
                }
            ?>
            <div id="auto_fill" class='autofill flex flex-wrap col-span-12 overflow-hidden z-10'></div>
            
            
            <input class="p-2 my-1 col-span-9 bit-font input-color" name="subject" type="subject" placeholder="Onderwerp" required> 
            <div class="col-span-1 flex justify-center text-white p-1 text-2xl">
                <input type="hidden" name="includeReminder" value='true'>
                <i class="fas fa-calendar-check text-6xl" id="cal_icon"></i>
            </div>
            <button class="col-span-2 cursor-pointer rounded-md button-submit" type="submit" name="sendemail" >
                <i class="text-2xl fas fa-paper-plane"></i>
            </button>
            <textarea class="border-2 p-2 my-1 col-span-12 input-color bit-font" name="msg" placeholder="text field" rows="4" required></textarea>
                
            
        </div>
        <div id="icsCreator" class="grid grid-cols-2 gap-3 p-5">
            <div class="flex items-baseline rounded-md justify-between p-5 box-color">
                <label class="underline" for="setDate">Datum: </label>
                <input class="border-2 text-2xl p-2 bit-font input-color" type="date"name="setDate">
            </div>
            <div class="flex items-baseline rounded-md justify-between p-5 box-color">
                <label class="underline" for="repeat">Herhaal wekelijks tot: </label>
                <input class="border-2 text-2xl p-2 bit-font input-color" type="date" name="repeat">
            </div>
            <div class="flex items-baseline rounded-md justify-between p-5 box-color">
                <label class="underline" for="setStartTime">start Tijd (12:00:AM/PM): </label>
                <input class="border-2 text-2xl p-2 bit-font input-color" type="time" name="setStartTime">
            </div>
            <div class="flex items-baseline rounded-md justify-between p-5 box-color">
                <label class="underline" for="setEndTime">eind Tijd (12:00:AM/PM): </label>
                <input class="border-2 text-2xl p-2 bit-font input-color" type="time" name="setEndTime">
            </div>
        </div>
    </form>
    
<script src="js_functions.js"></script>
</body>
</html>
<?php
}
