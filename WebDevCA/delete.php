<?php
session_start();
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);


    $num = $_REQUEST['q'];
    echo $num;
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("Connection failed" . $conn->connect_error);
    }
    $sql = "DELETE FROM visits WHERE visitid = '$num'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
      } else {
        echo "Error deleting record: " . $conn->error;
      }

$conn->close();
