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

// Fetch alimento details based on the selected food item
if (isset($_GET['alimento'])) {
    $alimento = $_GET['alimento'];

    // Prepare a statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT id_alimentos, nombre, contenido_k, energia_calorica_proteica, energia_calorica_lipidica, energia_calorica_carbohidratos FROM alimentos WHERE id_alimentos = ?");
    $stmt->bind_param("i", $alimento);
    $stmt->execute();
    $result = $stmt->get_result();

    $alimentoDetails = $result->fetch_assoc();

    echo json_encode($alimentoDetails);
}

$stmt->close();
$conn->close();
?>

