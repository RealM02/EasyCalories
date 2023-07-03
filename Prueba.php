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

// Query to fetch categories
$categoryQuery = "SELECT id_categoria, descripcion FROM categoria_alimentos";
$categoryResult = $conn->query($categoryQuery);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dropdown Example</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Dropdown Example</h1>

        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-select">
                        <option value="">Selecciona una categoría</option>
                        <?php
                        if ($categoryResult->num_rows > 0) {
                            while ($row = $categoryResult->fetch_assoc()) {
                                echo '<option value="' . $row['id_categoria'] . '">' . $row['descripcion'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="mb-3">
                    <label for="alimentos" class="form-label">Alimentos:</label>
                    <select id="alimentos" name="alimentos" class="form-select">
                        <option value="">Selecciona primero una categoría</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <div id="food-details">
        <h2>Food Details</h2>
        <table id="food-table" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contenido K</th>
                    <th>Energía Calórica Proteica</th>
                    <th>Energía Calórica Lipídica</th>
                    <th>Energía Calórica Carbohidratos</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        var alimentosDropdown = document.getElementById("alimentos");
        var categoriaDropdown = document.getElementById("categoria");

        categoriaDropdown.addEventListener("change", function() {
            var selectedCategoria = this.value;
            alimentosDropdown.innerHTML = ""; // Clear previous options

            // Fetch alimentos based on selected category
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_alimentos.php?categoria=" + selectedCategoria, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var alimentos = JSON.parse(xhr.responseText);
                    alimentos.forEach(function(alimento) {
                        var option = document.createElement("option");
                        option.text = alimento.nombre;
                        option.value = alimento.id_alimentos;
                        alimentosDropdown.add(option);
                    });
                }
            };
            xhr.send();
        });

        alimentosDropdown.addEventListener("change", function() {
            var selectedAlimento = this.value;

            // Clear previous table data
            var tableBody = document.querySelector("#food-table tbody");
            tableBody.innerHTML = "";

            // Fetch food item details based on selected food item
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_alimento_details.php?alimento=" + selectedAlimento, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var alimentoDetails = JSON.parse(xhr.responseText);
                    var row = tableBody.insertRow();
                    var idCell = row.insertCell();
                    var nameCell = row.insertCell();
                    var contenidoKCell = row.insertCell();
                    var energiaProteicaCell = row.insertCell();
                    var energiaLipidicaCell = row.insertCell();
                    var energiaCarbohidratosCell = row.insertCell();

                    idCell.textContent = alimentoDetails.id_alimentos;
                    nameCell.textContent = alimentoDetails.nombre;
                    contenidoKCell.textContent = alimentoDetails.contenido_k;
                    energiaProteicaCell.textContent = alimentoDetails.energia_calorica_proteica;
                    energiaLipidicaCell.textContent = alimentoDetails.energia_calorica_lipidica;
                    energiaCarbohidratosCell.textContent = alimentoDetails.energia_calorica_carbohidratos;
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>
