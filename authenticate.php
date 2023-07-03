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

    // Check if password is at least 8 characters long
    if (strlen($password) < 8) {
        echo '<script>alert("Password should be at least 8 characters long."); window.location.href = "index.php";</script>';
        exit;
    }

    // Prepare the query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User exists, check password
        $row = $result->fetch_assoc();
        if ($password === $row['pass']) {
            // Successful login
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
            // Incorrect password
            echo '<script>alert("Email and password do not match."); window.location.href = "index.php";</script>';
            exit;
        }
    } else {
        // User does not exist, redirect to registration page
        header("Location: register.php");
        exit;
    }
}

$conn->close();
?>