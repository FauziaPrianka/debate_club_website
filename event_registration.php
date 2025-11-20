<?php
include 'db_connect.php';

// Get event_name from URL
$event_name = $_GET['event_name'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Safely collect form data
  $event_name   = $conn->real_escape_string($_POST['event_name']);
  $name         = $conn->real_escape_string($_POST['name']);
  $email        = $conn->real_escape_string($_POST['email']);
  $phone        = $conn->real_escape_string($_POST['phone']);
  $department   = $conn->real_escape_string($_POST['department']);
  $semester     = $conn->real_escape_string($_POST['semester']);
  $university_id= $conn->real_escape_string($_POST['uni_id']);

  // Insert into database
  $sql = "INSERT INTO event_registrations 
  (event_name, name, email, phone, department, semester, university_id) 
  VALUES 
  ('$event_name', '$name', '$email', '$phone', '$department', '$semester', '$university_id')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('🎉 Registration Successful!'); window.location.href=document.referrer;</script>";
  } else {
    echo "<script>alert('❌ Error: " . addslashes($conn->error) . "');</script>";
  }

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Event Registration</title>
  <link rel="stylesheet" href="css/popup.css" />
</head>
<body>

  <!-- ========================= -->
  <!-- Popup Registration Form -->
  <!-- ========================= -->
  <div class="popup-form" id="eventPopup">
    <div class="event-popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <h2>🎓 Event Registration</h2>

      <form id="eventForm" method="POST" action="event_registration.php">


        <input type="hidden" name="event_name" value="<?php echo $event_name; ?>">


        <input type="text" name="name" placeholder="Enter your full name" required>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="phone" placeholder="Enter your phone number" required>

        <select name="department" required>
          <option value="">-- Select Department --</option>
          <option value="CSE">CSE</option>
          <option value="EEE">EEE</option>
          <option value="Civil">Civil</option>
          <option value="ENG">English</option>
          <option value="LAW">Law</option>
          <option value="BBA">BBA</option>
        </select>

        <select name="semester" required>
          <option value="">-- Select Semester --</option>
          <option value="1st">1st Semester</option>
          <option value="2nd">2nd Semester</option>
          <option value="3rd">3rd Semester</option>
          <option value="4th">4th Semester</option>
          <option value="5th">5th Semester</option>
          <option value="6th">6th Semester</option>
          <option value="7th">7th Semester</option>
          <option value="8th">8th Semester</option>
        </select>

        <input type="text" name="uni_id" placeholder="Enter your university ID" required>

        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
  </div>

  <script>
    // Popup control
    function closePopup() {
      document.getElementById("eventPopup").style.display = "none";
    }

    function openPopup() {
      document.getElementById("eventPopup").style.display = "flex";
    }
  </script>
</body>
</html>
