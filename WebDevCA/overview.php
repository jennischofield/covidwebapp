
<?php
session_start();
$dbjson = file_get_contents("database.json");
$dbinfo = json_decode($dbjson);
?>
<html>
    <head>
        <title>COVID - 19 Contact Tracing</title>
        <link rel="stylesheet" href="loggedin.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function deleteRow(elem){
            
            var table = elem.parentNode.parentNode.parentNode;
            var rowCount = table.rows.length;
            // get the "<tr>" that is the parent of the clicked button
            var row = elem.parentNode.parentNode; 
            row.parentNode.removeChild(row); // remove the row
            }
            function deleteRowFromDataBase(id){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   console.log("Good");
                }
                };
                
                xmlhttp.open("GET", "delete.php?q=" + id, true);
                xmlhttp.send();
            }
        </script>   
    </head>
    <body>
       
        
        
       <div class="sidenav">
            <a href="homepage.php">Home</a>
            <a href="overview.php">Overview</a>
            <a href="addvisit.php">Add Visit</a>
            <a href="reportinfection.php">Report</a>
            <a href="settings.php">Settings</a>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <a href="index.php">Logout</a>
        </div>
        <div class="wrapper_left">
            <div id="website_title_container">
                <h1 id="website_title">
                    COVID - 19 Contact Tracing
                </h1>
            </div>
            <img class="watermarkunlocked" src="watermark.png">
                <?php
                $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
                // Check connection
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
                $id = $_SESSION["id"];
                $sql = "SELECT date,time,duration,x,y,visitid FROM visits WHERE id = '$id'";
                $result = $conn->query($sql);
                echo "<table><tr><th>Date</th><th>Time</th><th>Duration</th><th>X</th><th>Y</th></tr>";

                if ($result->num_rows > 0) {
                // output data of each row
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["duration"]."</td><td>".$row["x"]."</td><td>".$row["y"]."</td><td><img id = "."deleteit"." src="."cross.png"." onclick="."deleteRow(this);deleteRowFromDataBase(".$row["visitid"].")></td></tr>";
                }
                echo "</table>";
                } else {
                echo "0 results";
                }
                ?>           
    </div>
    </body>
    
    </html>