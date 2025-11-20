<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

$success = "";
$error = "";

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $year = $_POST['year'];
    $position = $_POST['position'];
    $description = $_POST['description'];

    $image_name = "";

    // Upload image if selected
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
    }

    $query = "INSERT INTO achievements (title, year, position, description, image, created_at)
          VALUES ('$title', '$year', '$position', '$description', '$image_name', NOW())";


    if (mysqli_query($conn, $query)) {
        $success = "🎉 Achievement added successfully!";
    } else {
        $error = "❌ Failed to add achievement!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Achievement</title>
<style>
    body { 
        font-family: Arial; 
        background:#F1F8E9; 
        display:flex; 
        justify-content:center; 
        padding:30px 0; 
    }
    .container { 
        width:480px; 
        background:#e8f4df; 
        padding:25px; 
        border-radius:12px; 
        box-shadow:0 3px 12px rgba(0,0,0,0.15); 
        max-height:90vh; 
        overflow-y:auto; 
        border:3px solid #d0e4c6;
    }
    h2 { 
        text-align:center; 
        color:#1B5E20; 
    }
    input, textarea { 
        width:90%; 
        padding:12px; 
        border-radius:6px; 
        border:1px solid #a5c38c; 
        margin-top:6px; 
        background:#c5e1a5; 
    }
    label { 
        margin-top:10px; 
        font-weight:bold; 
        display:block; 
        color:#1B5E20;
    }
    button { 
        width:100%; 
        padding:13px; 
        background:#1B5E20; 
        color:white; 
        border:none; 
        border-radius:6px; 
        font-size:17px; 
        margin-top:15px; 
        cursor:pointer; 
        transition:.2s;
    }
    button:hover { 
        background:#164a19; 
    }
    .back { 
        display:block; 
        margin-top:15px; 
        text-align:center; 
        background:#c2660aff;; 
        color:white; 
        padding:10px; 
        border-radius:6px; 
        text-decoration:none; 
        transition:.2s;
    }
    .back:hover {
        background:#1B5E20;
    }
    .msg-success { 
        color:#1B5E20; 
        font-weight:bold; 
        text-align:center; 
    }
    .msg-error { 
        color:#d32f2f; 
        font-weight:bold; 
        text-align:center; 
    }
</style>

</head>
<body>

<div class="container">
<h2>➕ Add Achievement</h2>

<?php if ($success) echo "<p class='msg-success'>$success</p>"; ?>
<?php if ($error) echo "<p class='msg-error'>$error</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" required>

    <label>Year</label>
    <input type="number" name="year" required>

    <label>Position / Prize</label>
    <input type="text" name="position" required>

    <label>Description</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Image (optional)</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="add">📌 Add Achievement</button>
</form>

<a class="back" href="manage_achievements.php">⬅ Back to Achievements</a>
</div>

</body>
</html>
