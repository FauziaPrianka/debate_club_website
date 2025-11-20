<?php
include "db_connect.php";
$id = $_GET['id'];

// fetch existing data
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM executive_members WHERE id=$id"));

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];

    // Keep old photo if new one isn't uploaded
    $photo = $data['photo'];

    // If new photo uploaded
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . "_" . $_FILES['photo']['name'];

        // Upload to correct folder
        move_uploaded_file($_FILES['photo']['tmp_name'], "../admin/uploads/" . $photo);
    }

    mysqli_query($conn, "UPDATE executive_members 
        SET name='$name', role='$role', department='$department', photo='$photo'
        WHERE id=$id");

    header("Location: executive_members.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Executive Member</title>
<style>
body {
    font-family: Arial;
    background: #F1F8E9;
    margin: 0;
    padding: 40px;
}
h2 {
    text-align: center;
    color: #1B5E20;
    margin-bottom: 30px;
}
.form-container {
    width: 460px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(0,0,0,0.15);
}
label {
    font-weight: bold;
    margin-bottom: 6px;
    display: block;
}
input {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    width: 48%;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    color: white;
}
.update-btn {
    background: #1B5E20;
}
.update-btn:hover {
    background: #145017;
}
.cancel-btn {
    background: #d32f2f;
}
.cancel-btn:hover {
    background: #b71c1c;
}
.photo-box {
    text-align: center;
    margin-bottom: 15px;
}
img {
    border-radius: 6px;
    width: 110px;
}
</style>
</head>
<body>

<h2>✏ Edit Executive Member</h2>

<div class="form-container">
<form method="POST" enctype="multipart/form-data">

    <label>Name</label>
    <input type="text" name="name" value="<?= $data['name'] ?>" required>

    <label>Role</label>
    <input type="text" name="role" value="<?= $data['role'] ?>" required>

    <label>Department</label>
    <input type="text" name="department" value="<?= $data['department'] ?>" required>

    <div class="photo-box">
        <label>Current Photo</label>
        <?php if($data['photo']) { ?>
            <img src="../admin/uploads/<?= $data['photo'] ?>"><br>
        <?php } else { echo "No Photo"; } ?>
    </div>

    <label>Update Photo</label>
    <input type="file" name="photo">

    <div style="display:flex; justify-content: space-between; margin-top: 10px;">
        <button type="submit" name="update" class="update-btn">Update</button>
        <a href="executive_members.php" style="width:48%; text-decoration:none;">
            <button type="button" class="cancel-btn">Cancel</button>
        </a>
    </div>

</form>
</div>

</body>
</html>
