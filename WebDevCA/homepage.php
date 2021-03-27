
<html>
    <head>
        <title>COVID - 19 Contact Tracing</title>
        <link rel="stylesheet" href="homepage.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function addMarker(x, y){
                var image = document.createElement("IMG");
                image.src = "marker_red.png";
                image.style.top = (y -image.height) + 'px';
                image.style.left = (x - (image.width/2)) + 'px';
                image.id = "marker";
                image.onclick= function(){giveDetails(x,y)};
                var parent = document.getElementById("map-wrapper");
                parent.appendChild(image);
            }
            function addMarkerBlack(x, y){
                var image = document.createElement("IMG");
                image.src = "marker_black.png";
                image.style.top = (y -image.height) + 'px';
                image.style.left = (x - (image.width/2)) + 'px';
                image.id = "marker";
                image.onclick= function(){giveDetails(x,y)};
                var parent = document.getElementById("map-wrapper");
                parent.appendChild(image);
            }
            function giveDetails(x,y){
                document.getElementById("popup").innerHTML = "X:" + x + "\nY:"+ y;
                console.log("click");
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
            <p id="heading">Status</p>
            <img class="watermarkunlocked" src="watermark.png">
            <hr class="horizontalLine">
            <div id="wrap-all">
            
                <p class="description">Hi <?php session_start(); echo $_SESSION['username']; ?>, you might have <br> had a connection to<br> the infected person at the <br>location shown in red</p>
                <p id = "popup" class= "description" ></p>
                <p class="instructions">Click on the marker to see<br> details about the infection.</p>
            
            <div id="map-wrapper">
                    <img class="map" style="width: 500px; height: auto;" id="map"src="exeter.jpeg">
                    <?php
                    
                    $dbjson = file_get_contents("database.json");
                    $dbinfo = json_decode($dbjson);
                    
                    $sql = "SELECT id FROM infections;";
                    $conn = new mysqli($dbinfo->servername, $dbinfo->username, $dbinfo->password,$dbinfo->dbname);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $infectionid = $row['id'];
                            $sql2 = "SELECT date,time,duration,x,y FROM visits WHERE id = '$infectionid'";
                            $result2 = $conn->query($sql2);
                            if($result2->num_rows >0){
                                //print all 
                                while($row2 = $result2->fetch_assoc()){
                                    echo "<script>addMarkerBlack(".$row2['x'].",".$row2['y'].")</script>";
                                }
                            }
                        }
                    }
                    if(!isset($_COOKIE["window"])){
                        $url = 'http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections_mock.php?ts=7';
                    }else{
                        $url = 'http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections_mock.php?ts='.($_COOKIE["window"]*7);
                    }
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $endresult = curl_exec($ch);
                    $arr = json_decode($endresult, true);
                    $distance = $_COOKIE["distance"];
                    foreach($arr as &$value){
                        echo "<script>addMarkerBlack(".$value['x'].",".$value['y'].")</script>";
                        foreach($arr as &$value2){
                            if(sqrt(pow(($value['x']-$value['y']),2)+pow(($value2['x']-$value2['y']),2)) <= $distance){
                                echo "<script>addMarker(".$value['x'].",".$value['y'].")</script>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        
    </body>
</html>