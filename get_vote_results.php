<?php
include 'db_connect.php';

//  JSON
header('Content-Type: application/json');

// topics and their vote counts
$result = $conn->query("
  SELECT t.id, t.topic_title, COUNT(v.id) AS votes
  FROM votes_topics t
  LEFT JOIN votes v ON t.id = v.topic_id
  GROUP BY t.id, t.topic_title
  ORDER BY t.id ASC
");

//  JSON data
$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = [
    'topic_title' => $row['topic_title'],
    'votes' => (int)$row['votes']
  ];
}

// Output JSON
echo json_encode($data);
?>
