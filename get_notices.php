<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
$notices = [];

while ($row = $result->fetch_assoc()) {
  $notices[] = $row;
}

echo json_encode($notices);
?>
