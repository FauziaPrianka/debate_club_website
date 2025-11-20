<?php
header('Content-Type: application/json');
include 'db_connect.php';

$sql = "SELECT name, department, semester, photo FROM members";
$result = $conn->query($sql);

$members = [];

while ($row = $result->fetch_assoc()) {

    if (!empty($row['photo']) && file_exists("../admin/uploads/" . $row['photo'])) {
        $photoPath = "../admin/uploads/" . $row['photo'];
    } else {
        $photoPath = "assets/images/default.png";
    }

    $members[] = [
        'name' => $row['name'],
        'department' => $row['department'],
        'semester' => $row['semester'],
        'photo' => $photoPath
    ];
}

echo json_encode($members);
$conn->close();
?>
