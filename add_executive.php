<?php
include "db_connect.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];

    $photo = "";

    // Upload photo if selected
    if (!empty($_FILES['photo']['name'])) {

        // Create unique file name
        $photo = time() . "_" . $_FILES['photo']['name'];

        // Correct upload folder
        $upload_dir = "../admin/uploads/";

        // Create folder if not exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move to server
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo)) {
            $photo = ""; // upload failed → store empty value
        }
    }

    mysqli_query($conn, "INSERT INTO executive_members(name, role, department, photo)
                         VALUES('$name', '$role', '$department', '$photo')");

    header("Location: executive_members.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Executive Member</title>
<style>
    body { font-family: Arial; background: #F1F8E9; margin: 0; padding: 40px; }
    h2 { text-align: center; color: #1B5E20; margin-bottom: 30px; }
    .form-container {
        width: 420px; margin: auto; background: white; padding: 25px;
        border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.15);
    }
    label { font-weight: bold; margin-bottom: 6px; display: block; }
    input {
        width: 100%; padding: 10px; margin-bottom: 18px;
        border: 1px solid #ccc; border-radius: 5px;
    }
    button {
        width: 100%; background: #1B5E20; color: white; font-size: 16px;
        padding: 12px; border: none; border-radius: 6px; cursor: pointer;
    }
    button:hover { background: #145017; }
    .back-link {
        display: block; text-align: center; margin-top: 18px;
        color: #1B5E20; font-weight: bold; text-decoration: none;
    }
    .back-link:hover { text-decoration: underline; }
</style>
</head>
<body>

<h2>➕ Add Executive Member</h2>

<div class="form-container">
<form method="POST" enctype="multipart/form-data">

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Role</label>
    <input type="text" name="role" required>

    <label>Department</label>
    <input type="text" name="department" required>

    <label>Photo</label>
    <input type="file" name="photo">

    <button type="submit" name="submit">Save Member</button>

</form>

<a href="executive_members.php" class="back-link">⬅ Back to Executive Members</a>
</div>

</body>
</html>
