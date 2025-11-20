<?php
include "db_connect.php";

// prevent warnings (the page checks these later)
$success = "";
$error = "";

if (isset($_POST['add'])) {
    $title       = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $event_date  = $conn->real_escape_string($_POST['event_date']);
    $venue       = $conn->real_escape_string($_POST['venue']);

    // STEP 1: Insert event first (without register_link)
    $sql = "INSERT INTO events (title, description, event_date, venue)
            VALUES ('$title', '$description', '$event_date', '$venue')";

    if ($conn->query($sql) === TRUE) {

        // STEP 2: get event auto ID
        $event_id = $conn->insert_id;

        // STEP 3: auto-generate registration link
        $generated_link = "event_registration.php?event_id=" . $event_id;

        // STEP 4: save the generated link
        $update = "UPDATE events SET register_link = '$generated_link' WHERE id = $event_id";
        $conn->query($update);

        echo "<script>alert('🎉 Event Added Successfully!'); window.location='manage_events.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ Error: " . addslashes($conn->error) . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Event</title>
<style>
   body {
    font-family: Arial, sans-serif;
    background: #F1F8E9;
    margin: 0;
    display: flex;
    justify-content: center;
    padding: 40px 0;
}

.container {
    background: white;
    width: 480px;
    padding: 28px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    overflow-y: auto;
    border: 1px solid #d0e4c6;
}

h2 {
    text-align: center;
    color: #1B5E20;
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    margin-top: 15px;
    display: block;
    color: #1B5E20;
}

input,
textarea {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #9ccc65;
    margin-top: 6px;
    font-size: 15px;
    background: #f9fff5;
    transition: 0.2s;
}

input:focus,
textarea:focus {
    border-color: #1B5E20;
    outline: none;
    box-shadow: 0 0 5px rgba(27, 94, 32, 0.4);
}

textarea { resize: vertical; }

button {
    width: 100%;
    padding: 13px;
    background: #1B5E20;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 17px;
    cursor: pointer;
    margin-top: 22px;
    font-weight: bold;
    letter-spacing: 0.5px;
    transition: 0.2s;
}
button:hover {
    background: #144519;
}

.back {
    margin-top: 16px;
    display: block;
    text-align: center;
    padding: 11px;
    background: #c2660aff;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 15px;
    transition: 0.2s;
}
.back:hover {
    background: #2c2c2c;
}

.msg-success {
    color: #1B5E20;
    background: #d8f5d4;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
}

.msg-error {
    color: #b71c1c;
    background: #ffd8d8;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
}

</style>
</head>
<body>

<div class="container">
    <h2>➕ Add New Event</h2>

    <?php if ($success) echo "<p class='msg-success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='msg-error'>$error</p>"; ?>

    <form method="POST">
        <label>Event Title</label>
        <input type="text" name="title" placeholder="Enter event title" required>

        <label>Description</label>
        <textarea name="description" rows="5" placeholder="Write event description" required></textarea>

        <label>Event Date</label>
        <input type="date" name="event_date" required>

        <label>Venue</label>
        <input type="text" name="venue" placeholder="Enter venue/location" required>

        

        <button type="submit" name="add">📌 Add Event</button>
    </form>

    <a class="back" href="manage_events.php">⬅ Back to Manage Events</a>
</div>

</body>
</html>
