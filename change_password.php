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
    $newPassword = $_POST['newPassword'];

    // Validate password requirements
    $passwordRegex = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';
    if (!preg_match($passwordRegex, $newPassword)) {
        echo '<script>alert("La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número."); window.location.href = "index.php";</script>';
        exit;
    }

    // Prepare the query to update the password
    $stmt = $conn->prepare("UPDATE clientes SET pass = ? WHERE correo = ?");
    $stmt->bind_param("ss", $newPassword, $email);
    $stmt->execute();

    // Check if the password update was successful
    if ($stmt->affected_rows === 1) {
        // Password updated successfully
        echo '<script>alert("Contraseña cambiada exitosamente"); window.location.href = "index.php";</script>';
        exit;
    } else {
        // Password update failed
        echo '<script>alert("No se logró el cambio de contraseña"); window.location.href = "index.php";</script>';
        exit;
    }
}

$conn->close();
?>