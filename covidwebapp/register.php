<?php
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('register.html');
echo $content;
if(isset($_POST['submit'])){
  session_start();
    
    $firstname = htmlspecialchars($_REQUEST['firstname']);
    $surname =  htmlspecialchars($_REQUEST['surname']);
    $username = htmlspecialchars($_REQUEST['uname']);
    $password = password_hash(htmlspecialchars($_REQUEST['psw']), PASSWORD_BCRYPT);
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("Connection failed" . $conn->connect_error);
    }
    $sql = "INSERT INTO user_info(first_name, surname,username,password) VALUES (?, ?, ?, ?)";

    $statement = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($statement, $sql)){
        header("Location: ../addvisit.php?error=stmtfailed");
        exit();
    }
      $query = $conn->prepare($sql);
      $query->bind_param("ssss", $firstname, $surname, $username, $password);
      $query->execute();
      
      header('Location: ./index.php');
  



/*freeresultset*/
$result->free();
$conn->close();
}
?>