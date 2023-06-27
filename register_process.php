<?php
// Database connection
$dbHost = 'auth-db555.hstgr.io';
$dbUsername = 'u206492809_admin';
$dbPassword = 'contraEasy1';
$dbName = 'u206492809_easycalories';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $apellido_m = $_POST['apellido_m'];
    $apellido_p = $_POST['apellido_p'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellido_m, apellido_p, correo, pass) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $apellido_m, $apellido_p, $email, $password);
        if ($stmt->execute()) {
            // Registration successful
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Email ya existe escoje otro.";
    }
}

$conn->close();
?>
