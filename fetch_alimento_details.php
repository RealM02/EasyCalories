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

// Get the selected alimento ID from the request
$alimentoId = $_GET['alimento'];

// Prepare the query to fetch alimento details based on its ID
$stmt = $conn->prepare("SELECT * FROM alimentos WHERE id_alimentos = ?");
$stmt->bind_param("i", $alimentoId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the alimento details
    $alimentoDetails = $result->fetch_assoc();

    // Create a button with the desired action
    $buttonHTML = '<form method="POST" action="">
                        <input type="hidden" name="id" value="' . $alimentoDetails['id_alimentos'] . '">
                        <input type="hidden" name="nombre" value="' . $alimentoDetails['nombre'] . '">
                        <input type="hidden" name="contenido_k" value="' . $alimentoDetails['contenido_k'] . '">
                        <input type="hidden" name="id_categoria" value="' . $alimentoDetails['id_categoria'] . '">
                        <input type="hidden" name="energia_calorica_proteica" value="' . $alimentoDetails['energia_calorica_proteica'] . '">
                        <input type="hidden" name="energia_calorica_lipidica" value="' . $alimentoDetails['energia_calorica_lipidica'] . '">
                        <input type="hidden" name="energia_calorica_carbohidratos" value="' . $alimentoDetails['energia_calorica_carbohidratos'] . '">
                        <button type="submit" name="addToList" class="btn btn-primary">Agregar a la lista</button>
                    </form>';

    // Add the button HTML to the alimentoDetails array
    $alimentoDetails['buttonHTML'] = $buttonHTML;

    // Return the alimento details as JSON response
    header('Content-Type: application/json');
    echo json_encode($alimentoDetails);
} else {
    // No alimento found with the specified ID
    echo "No alimento found";
}

$stmt->close();
$conn->close();
?>
