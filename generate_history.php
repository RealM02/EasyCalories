<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected meal and products
    $meal = $_POST['meal'];
    $products = $_POST['products'];
    
    // Get current date
    $date = date('Y-m-d');
    
    // Store the history entry in a file
    $history = "$date - $meal: " . implode(', ', $products) . PHP_EOL;
    file_put_contents('history.txt', $history, FILE_APPEND);
}
?>
