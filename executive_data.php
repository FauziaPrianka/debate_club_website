<?php
include 'db_connect.php';

$sql = "SELECT * FROM executive_members ORDER BY id ASC";
$result = $conn->query($sql);

$members = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    // Keep only the image file name
    if (!empty($row['photo'])) {
        $row['photo'] = basename($row['photo']);
    }

    $members[] = $row;
  }
}

header("Content-Type: application/json");
echo json_encode($members);
$conn->close();
?>
