<?php
session_start();
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
$content = file_get_contents('reportinfection.html');
echo $content;
if(isset($_POST['submit'])){
    
      
      $date = htmlspecialchars($_REQUEST['date']);
      $time =  htmlspecialchars($_REQUEST['time']);
      $id = $_SESSION["id"];
      $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
      if($conn -> connect_error){
          die("Connection failed" . $conn->connect_error);
      }
     
     
      $id = $_SESSION['id'];
      $sql = "SELECT date,time,duration,x,y,id FROM visits WHERE id = '$id'";
      
      $result = $conn->query($sql);
      
        // output data of each row
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
            $data = array(
                "x" => $row['x'],
                "y" => $row['y'],
                "date" => $row['date'],
                "time" => $row['time'] . ":00",
                "duration" => $row['duration']
            );
            $infectedid = $row['id'];
            $infecteddate = $row['date'];
            $infectedtime = $row['time'];
            $sql2 = "INSERT INTO infections (id, infected_date, infected_time) VALUES ('$infectedid', '$infecteddate', '$infectedtime')";
            $conn -> query($sql2);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/report');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $endresult = curl_exec($ch);
        }
        
    }
}


?>