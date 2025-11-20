<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

$id = $_GET['id'];

$query = "DELETE FROM events WHERE id=$id";

if (mysqli_query($conn, $query)) {
    header("Location: manage_events.php?deleted=1");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
