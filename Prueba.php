<?php
session_start();
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

// User ID and historial to search for
$idCliente = $_SESSION['client_id'];  

// SQL query to fetch the top 10 most repeated id_alimento records for id_client = 13
$sql = "SELECT dh.id_alimento, COUNT(dh.id_alimento) AS repeticiones, a.nombre
        FROM historial_completo dh
        JOIN alimentos a ON dh.id_alimento = a.id_alimentos
        WHERE dh.id_cliente = $idCliente
        GROUP BY dh.id_alimento, a.nombre
        ORDER BY repeticiones DESC
        LIMIT 10";

$tenp = $conn->query($sql);

// Query to retrieve the last 5 records from historial
$query = "SELECT id_historial, ultima_fecha_ingreso FROM historial_completo WHERE id_cliente = $idCliente ORDER BY ultima_fecha_ingreso DESC LIMIT 5";
$hfive = $conn->query($query);

// Query to retrieve the last 5 records for alimentos
$query = "SELECT hc.id_alimento, hc.ultima_fecha_ingreso, a.nombre
FROM historial_completo hc
INNER JOIN alimentos a ON hc.id_alimento = a.id_alimentos
WHERE hc.id_cliente = 13
ORDER BY hc.ultima_fecha_ingreso DESC
LIMIT 5";
$afive = $conn->query($query);

// Query to fetch categories
$categoryQuery = "SELECT id_categoria, descripcion FROM categoria_alimentos";
$categoryResult = $conn->query($categoryQuery);

// Query to fetch alimentos based on selected category
$alimentosQuery = "SELECT id_alimentos, nombre FROM alimentos WHERE id_categoria = ?";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="user_g.png">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand">
      <img src="Logo.png" class="navbar-brand" alt="Logo" style="width: 9rem;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item mr-2">
          <a href="#productListModal" data-toggle="modal" class="nav-link text-primary">
            <i class="bi bi-list-check" style="font-size: 2rem;"></i>
          </a>
        </li>
        <li class="nav-item mr-2">
          <form action="" method="GET" class="form-inline">
            <div class="form-group">
              <input type="text" class="form-control" name="search" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
          </form>
        </li>
        <li class="nav-item mr-2">
          <a href="#historialModal" data-toggle="modal" class="nav-link text-primary">
            Historial
          </a>
        </li>
        <li class="nav-item">
          <a href="#profileModal" data-toggle="modal" class="nav-link text-primary">
            <i class="bi bi-person" style="font-size: 2rem;"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Profile Modal -->
<div id="profileModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Display user image here -->
                        <img src="user_g.png" class="img-fluid" alt="User Image">
                    </div>
                    <div class="col-md-8">
                        <!-- Display user information here -->
                        <?php
                        $fullName = $_SESSION['name'] . ' ' . $_SESSION['last_name_m'] . ' ' . $_SESSION['last_name_p'];
                        ?>
                        <h5>ID: <?php echo $_SESSION['client_id']; ?></h5>
                        <h5>Nombre: <?php echo $fullName; ?></h5>
                        <!-- Add more user information if needed -->
                    </div>
                </div>

<!-- Display top 10 most repeated id_alimento records from detalle_historial -->
<h5>Top 10 alimentos más consumidos:</h5>
<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th class="text-center">Número de consumos</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Display the fetched records
        if ($tenp->num_rows > 0) {
            while ($row = $tenp->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td class='text-center'>" . $row["repeticiones"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>
                    <td colspan='2'>
                        <div class='alert alert-warning' role='alert'>
                            No se encontro información
                        </div>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>
<!-- End of displaying top 10 most repeated id_alimento records -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- Add additional buttons if needed -->
            </div>
        </div>
    </div>
</div>

<!-- Historial Modal -->
<div id="historialModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historialModalLabel">Historial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-6">
                        <h5>Últimos 5 registros en el historial:</h5>
                        <hr>
                        <p>Selecciona un historial para revisar las listas de ese día.</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Historial</th>
                                    <th>Última Fecha de Ingreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Iterate over the retrieved rows and display the data
                                while ($row = $hfive->fetch_assoc()) {
                                    echo "<tr class='clickable-row historial-row' style='cursor: pointer;' data-toggle='modal' data-target='#modal_lista'>";
                                    echo "<td> Historial <span class='historial-id'>" . $row['id_historial'] . "</span></td>";
                                    echo "<td>" . $row['ultima_fecha_ingreso'] . "</td>";
                                    echo "</tr>";
                                }

                                // Check if any records were found
                                if ($hfive->num_rows == 0) {
                                    echo "<tr>
                                            <td colspan='2'>
                                                <div class='alert alert-warning' role='alert'>
                                                    No se encontró información
                                                </div>
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


<div class="col-md-6">
    <h5>Últimos 5 productos consumidos:</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Iterate over the retrieved rows and display the data
            while ($row = $afive->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "</tr>";
            }

            // Check if any records were found
if ($hfive->num_rows == 0) {
    echo "<tr>
            <td colspan='2'>
                <div class='alert alert-warning' role='alert'>
                    No se encontro información
                </div>
            </td>
        </tr>";
}
            ?>
        </tbody>
    </table>
</div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- Add additional buttons if needed -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Lista -->
<div class="modal fade" id="modal_lista" tabindex="-1" role="dialog" aria-labelledby="modal_lista_i" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_lista_i">Historial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th>ID Lista</th>
                <th>ID Alimento</th>
              </tr>
            </thead>
            <tbody id="modal-lista-body"></tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Carrousel -->
<div class="container my-2">
  <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" data-interval="5000">
        <div class="row">
          <div class="col">
            <img src="dato1.png" class="d-block w-100" alt="Image 1">
          </div>
          <div class="col">
            <img src="dato2.png" class="d-block w-100" alt="Image 2">
          </div>
        </div>
      </div>
      <div class="carousel-item" data-interval="5000">
        <div class="row">
          <div class="col">
            <img src="dato2.png" class="d-block w-100" alt="Image 2">
          </div>
          <div class="col">
            <img src="dato3.png" class="d-block w-100" alt="Image 3">
          </div>
        </div>
      </div>
      <div class="carousel-item" data-interval="5000">
        <div class="row">
          <div class="col">
            <img src="dato3.png" class="d-block w-100" alt="Image 3">
          </div>
          <div class="col">
            <img src="dato4.png" class="d-block w-100" alt="Image 4">
          </div>
        </div>
      </div>
      <div class="carousel-item" data-interval="5000">
        <div class="row">
          <div class="col">
            <img src="dato4.png" class="d-block w-100" alt="Image 4">
          </div>
          <div class="col">
            <img src="dato5.png" class="d-block w-100" alt="Image 5">
          </div>
        </div>
      </div>
      <div class="carousel-item" data-interval="5000">
        <div class="row">
          <div class="col">
            <img src="dato5.png" class="d-block w-100" alt="Image 5">
          </div>
          <div class="col">
            <img src="dato6.png" class="d-block w-100" alt="Image 6">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Resultado con Dropdown -->
<div class="container mt-4">
        <h3 class="text-center">Selecciona el alimento</h3>

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

<!-- Resultados barra de búsqueda -->
    <div class="container">

        <h2>Resultados</h2>

        <div id="food-details">
        <table id="food-table" class="table">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

        <table class="table">
            <tbody>
                <!-- Display search results here -->
                <?php

// Check if the product list exists in the session
if (isset($_POST['addToList'])) {
    // Get the product details from the form submission
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contenido_k = $_POST['contenido_k'];
    $id_categoria = $_POST['id_categoria'];
    $energia_calorica_proteica = $_POST['energia_calorica_proteica'];
    $energia_calorica_lipidica = $_POST['energia_calorica_lipidica'];
    $energia_calorica_carbohidratos = $_POST['energia_calorica_carbohidratos'];

    // Create an array with the product details
    $product = array(
        'id' => $id,
        'nombre' => $nombre,
        'contenido_k' => $contenido_k,
        'id_categoria' => $id_categoria,
        'energia_calorica_proteica' => $energia_calorica_proteica,
        'energia_calorica_lipidica' => $energia_calorica_lipidica,
        'energia_calorica_carbohidratos' => $energia_calorica_carbohidratos
    );

    // Add the product to the product list stored in the session
    $_SESSION['productList'][] = $product;

    // Set the success message in a session variable
    $_SESSION['successMessage'] = 'El producto se ha agregado correctamente a la lista.';
}


// Handle clearing the product list
if (isset($_POST['clearList'])) {
    $_SESSION['productList'] = array(); // Clear the product list
}

// Display the success message if it exists
if (!empty($_SESSION['successMessage'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['successMessage'] . '</div>';

    // Clear the success message after displaying it
    unset($_SESSION['successMessage']);
}

// Database connection
$dbHost = 'auth-db555.hstgr.io';
$dbUsername = 'u206492809_admin';
$dbPassword = 'contraEasy1';
$dbName = 'u206492809_easycalories';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    if (empty($search)) {
        echo '<div class="alert alert-dark" role="alert">No has ingresado ningún producto</div>';
    } else {
        // Prepare the query to search for alimentos
        $stmt = $conn->prepare("SELECT * FROM alimentos WHERE nombre LIKE ?");
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Contenido K</th>
                            <th>ID Categoría</th>
                            <th>Energía Calórica Proteica</th>
                            <th>Energía Calórica Lipídica</th>
                            <th>Energía Calórica Carbohidratos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_alimentos'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['contenido_k'] . "</td>";
                echo "<td>" . $row['id_categoria'] . "</td>";
                echo "<td>" . $row['energia_calorica_proteica'] . "</td>";
                echo "<td>" . $row['energia_calorica_lipidica'] . "</td>";
                echo "<td>" . $row['energia_calorica_carbohidratos'] . "</td>";
                echo '<td><form method="POST" action=""><input type="hidden" name="id" value="' . $row['id_alimentos'] . '"><input type="hidden" name="nombre" value="' . $row['nombre'] . '"><input type="hidden" name="contenido_k" value="' . $row['contenido_k'] . '"><input type="hidden" name="id_categoria" value="' . $row['id_categoria'] . '"><input type="hidden" name="energia_calorica_proteica" value="' . $row['energia_calorica_proteica'] . '"><input type="hidden" name="energia_calorica_lipidica" value="' . $row['energia_calorica_lipidica'] . '"><input type="hidden" name="energia_calorica_carbohidratos" value="' . $row['energia_calorica_carbohidratos'] . '"><button type="submit" name="addToList" class="btn btn-primary">Agregar a la lista</button></form></td>';
                echo "</tr>";
            }

            echo '</tbody>
                    </table>';
        } else {
            // No search results found
            echo '<div class="alert alert-danger" role="alert">No tenemos el artículo. <a href="mailto:your-email@example.com?subject=Agregar%20producto&body=Por%20favor%20agrega%20el%20siguiente%20producto:%0A%0ANombre%3A%20' . urlencode($search) . '">Haz clic aquí</a> para solicitar agregar el producto.</div>';
        }

        $stmt->close();
    }
} else {
    echo '<div class="alert alert-dark" role="alert">No has ingresado ningún producto</div>';
}

$conn->close();
?>
            </tbody>
        </table>
    </div>

<!-- Modal to display the product list -->
<div id="productListModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lista de Productos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="process_data2.php">
                    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
                    <input type="hidden" name="ultima_fecha_ingreso" value="<?php echo date('Y-m-d'); ?>">
                    
                    <div class="form-group">
                        <label for="horario_comida">Tipo de comida:</label>
                        <select class="form-control" id="horario_comida" name="horario_comida">
                            <option value="Desayuno">Desayuno</option>
                            <option value="Comida">Comida</option>
                            <option value="Cena">Cena</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Contenido K</th>
                                    <th>ID Categoría</th>
                                    <th>Energía Calórica Proteica</th>
                                    <th>Energía Calórica Lipídica</th>
                                    <th>Energía Calórica Carbohidratos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Display the product list here -->
                                <?php
                                // Display the product list from the session
                                if (!empty($_SESSION['productList'])) {
                                    foreach ($_SESSION['productList'] as $product) {
                                        echo "<tr>";
                                        echo "<td>" . $product['id'] . "</td>";
                                        echo "<td>" . $product['nombre'] . "</td>";
                                        echo "<td>" . $product['contenido_k'] . "</td>";
                                        echo "<td>" . $product['id_categoria'] . "</td>";
                                        echo "<td>" . $product['energia_calorica_proteica'] . "</td>";
                                        echo "<td>" . $product['energia_calorica_lipidica'] . "</td>";
                                        echo "<td>" . $product['energia_calorica_carbohidratos'] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Display the sum of contenido_k -->
                    <?php
                    $sum = 0;
                    if (!empty($_SESSION['productList'])) {
                        foreach ($_SESSION['productList'] as $product) {
                            $sum += $product['contenido_k'];
                        }
                    }
                    echo '<p class="text-end"><strong>Suma de contenido:</strong> ' . $sum . '</p>';
                    ?>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success">Enviar a Base</button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="clearList" class="btn btn-danger">Borrar lista</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Boton con calorias -->
<div class="text-center">
    <?php
        $totalContenidoK = 0;
        if (!empty($_SESSION['productList'])) {
            foreach ($_SESSION['productList'] as $product) {
                $totalContenidoK += $product['contenido_k'];
            }
        }

        // Set CSS class based on $totalContenidoK value
        if ($totalContenidoK < 1599) {
            $buttonClass = 'btn btn-warning mb-5'; // Yellow background
        } elseif ($totalContenidoK >= 1600 && $totalContenidoK <= 2500) {
            $buttonClass = 'btn btn-success mb-5'; // Green background
        } else {
            $buttonClass = 'btn btn-danger mb-5'; // Red background
        }
    ?>
    <a href="#productListModal" data-toggle="modal" class="<?php echo $buttonClass; ?>">
        Contador de Calorías: <?php echo $totalContenidoK; ?>
    </a>
</div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
    $(document).on('hidden.bs.modal', '#modal_lista', function () {
        $('.modal-backdrop').addClass('show');
        $('#historialModal').removeClass('hide');
    });
    </script>

    <script>
    $(document).ready(function() {
        $('.historial-row').click(function() {
            var historialId = $(this).find('.historial-id').text();
            var modalTitle = "Historial " + historialId;
            $('#modal_lista_i').text(modalTitle);
        });
    });
    </script>
    
    <script>
  $(document).ready(function() {
    $('.historial-row').click(function() {
      var historialId = $(this).find('.historial-id').text();
      var modalTitle = "Historial " + historialId;
      $('#modal_lista_i').text(modalTitle);

      // Fetch data for the clicked id_historial
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "fetch_modal_lista.php?id_historial=" + historialId, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          var modalListaData = JSON.parse(xhr.responseText);
          var modalListaBody = document.getElementById("modal-lista-body");
          modalListaBody.innerHTML = ""; // Clear previous data

          // Iterate over the fetched data and create table rows
          modalListaData.forEach(function(row) {
            var tr = document.createElement("tr");
            var tdIdLista = document.createElement("td");
            var tdIdAlimento = document.createElement("td");
            tdIdLista.textContent = row.id_lista;
            tdIdAlimento.textContent = row.id_alimento;
            tr.appendChild(tdIdLista);
            tr.appendChild(tdIdAlimento);
            modalListaBody.appendChild(tr);
          });
        }
      };
      xhr.send();
    });
  });
</script>


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
                var buttonCell = row.insertCell();

                idCell.textContent = alimentoDetails.id_alimentos;
                nameCell.textContent = alimentoDetails.nombre;
                contenidoKCell.textContent = alimentoDetails.contenido_k;
                energiaProteicaCell.textContent = alimentoDetails.energia_calorica_proteica;
                energiaLipidicaCell.textContent = alimentoDetails.energia_calorica_lipidica;
                energiaCarbohidratosCell.textContent = alimentoDetails.energia_calorica_carbohidratos;

                // Insert the button HTML into the buttonCell
                buttonCell.innerHTML = alimentoDetails.buttonHTML;
            }
        };
        xhr.send();
    });
</script>

</body>
</html>