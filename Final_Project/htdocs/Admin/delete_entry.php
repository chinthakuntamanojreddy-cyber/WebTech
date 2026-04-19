<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['table'])) {
    $id = intval($_POST['id']);
    $allowedTables = ['Bus_entry', 'Auto_entry'];  // whitelist tables
    $table = $_POST['table'];

    if (!in_array($table, $allowedTables)) {
        echo "Invalid table.";
        exit;
    }

    $sql = "DELETE FROM $table WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'Error deleting record: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}
?>
