<?php
$conn = new mysqli("localhost", "root", "", "debate_club_db");

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Connection successful!";
}
?>
