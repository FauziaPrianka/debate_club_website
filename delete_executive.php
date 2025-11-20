<?php
include "db_connect.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM executive_members WHERE id=$id");
header("Location: executive_members.php");
exit();
?>
