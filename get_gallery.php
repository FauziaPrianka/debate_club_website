<?php
include 'db_connect.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 0;

$query = "SELECT * FROM gallery ORDER BY id DESC";
if ($limit > 0) {
  $query .= " LIMIT $limit";
}

$result = $conn->query($query);
$gallery = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Return only file name — no path
    $row['image_path'] = $row['image_path'];
    $gallery[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($gallery);
?>
