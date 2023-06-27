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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE correo = ? AND pass = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Successful login
        $row = $result->fetch_assoc();
        $clientId = $row['id_cliente'];
        $name = $row['nombre'];
        $lastNameM = $row['apellido_m'];
        $lastNameP = $row['apellido_p'];
        $creationDate = $row['fecha_creacion'];
        $active = $row['activo'];

        // Store user data in session or perform desired actions

        // Redirect to home page
        header("Location: home.php");
        exit;
    } else {
        // Invalid login
        header("Location: register.php");
        exit;
    }
}

$conn->close();
?>