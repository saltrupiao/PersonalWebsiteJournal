<!DOCTYPE html>
<html>

<head>
    <title> My First PHP/MySQL Page </title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

    </style>
</head>

<body>
    <h1> List of Students </h1>
    <?php
        $servername = "localhost";  // Will typically be localhost since PHP and MySQL       
        $username = "root";
        $password = "oakland";
        $dbname = "university";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
    //Lines 16-20 - from conn to the end of the if, can be written as
    // !$conn->connect_error || die("connection failed");
    
        // Control reaching here means thread is not dead -- successful connection
        echo "Connected successfully <br>";
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table>"; //Create table
            echo "<thead><tr><td>GID</td><td>Name</td><td>Email</td><td>Phone</td><td>Level</td></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["GID"] . "</td>" . "<td>" . $row["Name"] . "</td>" . "<td>" . $row["Email"] . "</td>" . "<td>" . $row["Phone"] . "</td>" . "<td>" . $row["Level"] . "</td></tr><br>";
            }
            echo "</table>"; //Close table
            } else {
            echo "No Student Records Found <br>";
        }
        $conn->close();
    ?>
</body>

</html>
