<?php
include 'db_connect.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM votes_topics WHERE id=$id");
header("Location: votes_topics.php");
?>
