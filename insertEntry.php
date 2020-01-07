<?php
	$servername = "localhost";
    $username = "root";
    $password = "oakland";
    $dbname = "journal";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
        	die("Connection failed: " . $conn->error);
    	} 
    	echo "Connection Successful <br>";

	$eDate = $_POST['eDate'];
	$eTitle = $_POST['eTitle'];
	$eText = $_POST['eText'];
	$eURL = $_POST['eURL'];
	$eGroup = $_POST['eGroup'];

	$sql = "INSERT INTO entry(eDate, eTitle, eText, eURL, eGroup) VALUES " .
                "('$eDate', '$eTitle', '$eText', '$eURL', '$eGroup')";	

	echo "Running SQL statement - <br>" . $sql . "<br>";
	
	if ($conn->query($sql) === TRUE) 
	{
            echo "Record Inserted <br>";
        } 
	else 
	{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
?>
