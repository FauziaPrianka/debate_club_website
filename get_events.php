<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "debate_club_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional limit parameter (default: show all)
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 0;

// Base query
$query = "SELECT title, description, event_date, venue, register_link 
          FROM events 
          ORDER BY event_date DESC";

// Apply limit only if requested
if ($limit > 0) {
    $query .= " LIMIT " . $limit;
}

$result = $conn->query($query);
$events = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ✅ Clean and format data
        $events[] = [
            'title' => htmlspecialchars($row['title']),
            'description' => nl2br(htmlspecialchars($row['description'])),
            'event_date' => date("F j, Y", strtotime($row['event_date'])),
            'venue' => htmlspecialchars($row['venue']),
            'register_link' => htmlspecialchars($row['register_link'])
        ];
    }
}

$conn->close();

// ✅ Return JSON data
header('Content-Type: application/json');
echo json_encode($events);
?>
