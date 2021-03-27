<?php
if(session_status() === PHP_SESSION_ACTIVE){
    session_destroy();
}
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('login.html');
echo $content;
if(isset($_POST['submit'])){
    session_start();
    $username = htmlspecialchars($_REQUEST['uname']);
    $password =htmlspecialchars($_REQUEST['psw']);
    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
    if($conn -> connect_error){
        die("Connection failed" . $conn->connect_error);
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $result = $conn->query("SELECT * FROM user_info WHERE username = '$username'");
    
    $rows = $result->fetch_assoc();
    $correct_password = $rows['password'];
    if($result== FALSE ){
        echo "Invalid Login";
    }else{
        if(password_verify($password, $correct_password)){
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $rows['id'];
            header('Location: ./homepage.php');
        }else{
            echo "Invalid Login";
        }


        $conn->close();
}



}

?>