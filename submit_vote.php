<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $member_id = $conn->real_escape_string($_POST['member_id']);
  $topic_id = (int)$_POST['topic_id'];

  // Check if member exists (optional, to verify valid member)
  $check = $conn->query("SELECT * FROM members WHERE member_id='$member_id'");
  if ($check->num_rows === 0) {
    echo "invalid";
    exit;
  }

  // Check if already voted
  $already = $conn->query("SELECT * FROM votes WHERE member_id='$member_id'");
  if ($already->num_rows > 0) {
    echo "already";
    exit;
  }

  // Record new vote
  $insert = $conn->query("INSERT INTO votes (member_id, topic_id) VALUES ('$member_id', $topic_id)");
  echo $insert ? "success" : "error";
}
?>
