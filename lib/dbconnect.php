<?php
$servername = "localhost";
$username = "username";
$dbname = "sql";

// Create connection
$conn = new mysqli($servername, $username, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//$sql = "INSERT INTO Players (username) VALUES ('John','B')";
 //$sql="INSERT INTO Players (username) VALUES ('Joe','W')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
