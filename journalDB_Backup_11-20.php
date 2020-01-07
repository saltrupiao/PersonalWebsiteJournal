<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <?php

        session_start();
    
        //include "function.php";
    
        if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
        {
            echo $_SESSION['login'];
            header ("Location: ./login.html");
        }


        $servername = "localhost";
        $username = "root";
        $password = "oakland";
        $dbname = "journal";
	    $conn = new mysqli($servername, $username, $password, $dbname);

        
        //connectToDB();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully (".$conn->host_info.")";
        echo "<br>";
        
        // Show rows
        $sql = "SELECT * FROM entry";
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) 
            {
                $eDate = $row["eDate"];
                echo  "eDate: " . $eDate . "  - eName: " . $row["eName"] . 
                    " - eTitle: " . $row["eTitle"] . 
    		          " - eText: " . $row["eText"] . "- eURL: " . $row["eURL"] . "- eGroup: " . $row["eGroup"] . "<br><br>";
            }
        } else 
        {
            echo "0 results";
        }
        $conn->close();
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
