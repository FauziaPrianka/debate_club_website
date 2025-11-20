<?php
header('Content-Type: application/json');
include 'db_connect.php';

$sql = "SELECT id, name, department, role, photo FROM moderator LIMIT 1";
$result = $conn->query($sql);

$response = [];

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Full path
    $photoPath = "../admin/uploads/" . $row['photo'];

    // If file not found, use default
    if (!file_exists($photoPath) || empty($row['photo'])) {
        $photoPath = "assets/images/default_user.png";
    }

    $row['photo'] = $photoPath;

    $response[] = $row;
}

echo json_encode($response);
$conn->close();
?>
