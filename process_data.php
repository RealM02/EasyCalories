<?php
$dbHost = 'auth-db555.hstgr.io';
$dbUsername = 'u206492809_admin';
$dbPassword = 'contraEasy1';
$dbName = 'u206492809_easycalories';

// Create a database connection
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Start the session
session_start();

// Get the form data
$id_cliente = $_POST['id_cliente'];
$ultima_fecha_ingreso = $_POST['ultima_fecha_ingreso'];

// Function to generate a random ID using auto-increment in the database
function generateRandomID($table, $column, $mysqli)
{
    // Insert a dummy record to generate the auto-incremented ID
    $sql = "INSERT INTO $table ($column) VALUES (NULL)";
    if (!$mysqli->query($sql)) {
        die("Error inserting data to generate random ID: " . $mysqli->error);
    }

    // Get the last inserted ID
    $randomID = $mysqli->insert_id;

    // Delete the dummy record
    $sql = "DELETE FROM $table WHERE $column = $randomID";
    if (!$mysqli->query($sql)) {
        die("Error deleting dummy record: " . $mysqli->error);
    }

    return $randomID;
}

// Assuming you have a database connection established, insert the data
if (!empty($_SESSION['productList'])) {
    // Generate a unique ID for id_lista and id_historial
    $id_lista = generateRandomID('historial', 'id_lista', $mysqli);
    $id_historial = generateRandomID('detalle_historial', 'id_historial', $mysqli);

    // Insert the data into the historial table
    foreach ($_SESSION['productList'] as $product) {
        $horario_comida = $_POST['horario_comida']; // Assuming you have the value of horario_comida from the form
        $id_alimento = $product['id_alimento'];
        $res_calorico = $product['contenido_k'];

        // Insert the data into the historial table
        $sql = "INSERT INTO historial (horario_comida, id_alimento, id_lista, res_calorico) 
                VALUES ('$horario_comida', $id_alimento, $id_lista, $res_calorico)";
        if (!$mysqli->query($sql)) {
            die("Error inserting data into historial table: " . $mysqli->error);
        }

        // Insert the data into the detalle_historial table
        $sql = "INSERT INTO detalle_historial (id_cliente, id_historial, id_lista, ultima_fecha_ingreso) 
                VALUES ($id_cliente, $id_historial, $id_lista, '$ultima_fecha_ingreso')";
        if (!$mysqli->query($sql)) {
            die("Error inserting data into detalle_historial table: " . $mysqli->error);
        }
    }

    // Clear the productList session after successfully inserting into the database
    unset($_SESSION['productList']);
}

// Close the database connection
$mysqli->close();

// Redirect to home.php
header("Location: home.php");
exit();
?>