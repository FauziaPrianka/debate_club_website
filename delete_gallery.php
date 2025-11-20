<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

$id = $_GET['id'];

// fetch image file name from db
$sql = "SELECT image_path FROM gallery WHERE id = $id";
$result = mysqli_query($conn, $sql);
$img = mysqli_fetch_assoc($result);

if ($img && !empty($img['image_path'])) {
    $file = "uploads/" . $img['image_path'];
    if (file_exists($file)) {
        unlink($file); // delete image from folder
    }
}

// delete record from DB
mysqli_query($conn, "DELETE FROM gallery WHERE id = $id");
header("Location: manage_gallery.php");
exit();
?>
