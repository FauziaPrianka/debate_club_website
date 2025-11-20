<?php
include "db_connect.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM members WHERE id = $id");
header("Location: members.php");
exit();
?>
