<?php
// db_connection.php
//Universal across each team member

// Default Database credentials
$host = 'localhost';        
$username = 'root';         
$password = '';             
$database = 'dolphin_crm';  

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
