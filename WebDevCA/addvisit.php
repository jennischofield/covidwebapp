<?php
session_start();
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('addvisit.html');
echo $content;

if(isset($_POST['submit'])){
    $y = htmlspecialchars($_REQUEST['y']);
    $date =htmlspecialchars($_REQUEST['date']);
    $x = htmlspecialchars($_REQUEST['x']);
    $duration = htmlspecialchars($_REQUEST['duration']);
    $time = htmlspecialchars($_REQUEST['time']);
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("Connection failed" . $conn->connect_error);
    }
    $id = $_SESSION['id'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $sql = "INSERT INTO visits(x,y,date, time, duration,id) VALUES(? ,? ,? ,? ,? ,? );";


  $statement = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($statement, $sql)){
      header("Location: ../addvisit.php?error=stmtfailed");
      exit();
  }
    $query = $conn->prepare($sql);
    $query->bind_param("ddssii", $x, $y, $date, $time, $duration, $id);
    $query->execute();
  
}
  
  

?>