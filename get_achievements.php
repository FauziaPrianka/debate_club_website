<?php
include 'db_connect.php';

// If a limit is passed, use it — otherwise show all
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 0;

if ($limit > 0) {
    $query = "SELECT * FROM achievements ORDER BY year DESC LIMIT $limit";
} else {
    $query = "SELECT * FROM achievements ORDER BY year DESC";
}

$result = $conn->query($query);
$achievements = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $achievements[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($achievements);
?>
