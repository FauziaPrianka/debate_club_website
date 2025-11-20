<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];

// Fetch old image
$result = mysqli_query($conn, "SELECT image FROM achievements WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if ($data['image'] && file_exists("uploads/" . $data['image'])) {
    unlink("uploads/" . $data['image']); // delete image
}

// delete database row
mysqli_query($conn, "DELETE FROM achievements WHERE id = $id");

header("Location: manage_achievements.php?msg=deleted");
exit();
?>
