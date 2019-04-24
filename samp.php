<?php
// echo "Hi Info"; exit;
// $servername = "10.162.87.138";
// $username = "sprpaysez";
// $password = "Sp@aysezLinux@123";
// $dbname = "suprpaysez";

$servername = "10.162.104.214";
$username = "pguat";
$password = "pguat";
$dbname = "suprpaysez";

// echo $servername.'=>'.$username.'=>'.$password.'=>'.$dbname; 
// exit;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// echo $conn->connect_error; exit;

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} else {
echo "Connected";
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "id: " . $row["id"]. " - Name: " . $row["username"]. "<br>";
}
} else {
echo "0 results";
}
$conn->close();