<?php
session_start();
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('settings.html');
echo $content;
if(isset($_POST['submit'])){
    $window = htmlspecialchars($_REQUEST["window"]);
    $distance = htmlspecialchars($_REQUEST["distance"]);
    $windowcookie = "window";
    $distancecookie = "distance";
    setcookie($windowcookie, $window, time() + (86400 * 30), "/" );
    setcookie($distancecookie, $distance, time() + (86400 * 30), "/");
    
}
?>