<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $conn->real_escape_string($_POST['name']);
  $uni_id = $conn->real_escape_string($_POST['uni_id']);
  $department = $conn->real_escape_string($_POST['department']);
  $semester = $conn->real_escape_string($_POST['semester']);

  // Handle photo upload
  $targetDir = __DIR__ . "/../admin/uploads/";
  if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  $photoName = time() . "_" . basename($_FILES["photo"]["name"]);
  $targetFile = $targetDir . $photoName;
  move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);

  // Generate Member ID
  $prefix = "MBR" . date("Y");
  $result = $conn->query("SELECT COUNT(*) AS total FROM members");
  $row = $result->fetch_assoc();
  $count = $row['total'] + 1;
  $member_id = $prefix . str_pad($count, 3, "0", STR_PAD_LEFT);

  // Insert into members table
  $sql = "INSERT INTO members (member_id, name, uni_id, department, semester, photo)
          VALUES ('$member_id', '$name', '$uni_id', '$department', '$semester', '$photoName')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>
      alert('🎉 Registration Successful! Your Member ID is: $member_id');
      window.location.href = document.referrer;
    </script>";
  } else {
    echo "<script>alert('Error: " . addslashes($conn->error) . "');</script>";
  }

  $conn->close();
}
?>
