<?php
// Database connection details
$dbHost = 'auth-db555.hstgr.io';
$dbUsername = 'u206492809_admin';
$dbPassword = 'contraEasy1';
$dbName = 'u206492809_easycalories';

// Create a connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch alimentos based on the selected category
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];

    // Prepare a statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT id_alimentos, nombre FROM alimentos WHERE id_categoria = ?");
    $stmt->bind_param("i", $categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    $alimentos = array();
    while ($row = $result->fetch_assoc()) {
        $alimentos[] = $row;
    }

    echo json_encode($alimentos);
}

$stmt->close();
$conn->close();
?>
