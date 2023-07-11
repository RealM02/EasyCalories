<?php
// process_data2.php

// Retrieve the form data
$id_cliente = $_POST['id_cliente'];
$ultima_fecha_ingreso = $_POST['ultima_fecha_ingreso'];
$horario_comida = $_POST['horario_comida'];

// Perform database operations to insert data into the tables
// Use the appropriate SQL queries and database functions for your specific database management system

// Initialize the variables
$nextId1 = ''; // Initialize $nextId1
$nextId2 = ''; // Initialize $nextId2
$sum = 0; // Initialize $sum
$product = null; // Initialize $product

// Insert data into the 'historial' table
$query1 = "INSERT INTO historial (id_historial, id_cliente, ultima_fecha_ingreso) VALUES ('$nextId1', '$id_cliente', '$ultima_fecha_ingreso')";
// Execute the query

// Insert data into the 'detalle_historial' table
$query2 = "INSERT INTO detalle_historial (id_cliente, id_lista, horario_comida, res_calorico, id_alimento) VALUES ('$id_cliente', '$nextId2', '$horario_comida', '$sum', '{$product['id']}')";
// Execute the query

?>
