<?php
// Establish a database connection using the appropriate credentials
$dbHost = 'auth-db555.hstgr.io';
$dbUsername = 'u206492809_admin';
$dbPassword = 'contraEasy1';
$dbName = 'u206492809_easycalories';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the id_alimento from the request parameters
$idAlimento = $_GET['id_alimento'];

// Construct the SQL query to select the nombre column from the alimentos table
$sql = "SELECT nombre FROM alimentos WHERE id_alimentos = $idAlimento";

// Execute the SQL query and fetch the result
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Encode the fetched data as JSON and return it as the response
echo json_encode($row);

// Close the database connection
$conn->close();
?>

