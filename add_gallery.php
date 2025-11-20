<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
$success = ""; 
$error = "";

if (isset($_POST['upload'])) {

    // Correct input field name: "image"
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    if ($image != "") {

        // Unique filename
        $fileName = time() . "_" . $image;
        $path = "uploads/" . $fileName;

        if (move_uploaded_file($tmp, $path)) {

            // Insert into DB (column: image_path)
            mysqli_query(
                $conn,
                "INSERT INTO gallery(image_path, uploaded_at) VALUES('$fileName', NOW())"
            );

            $success = "Image uploaded successfully!";
        } else {
            $error = "Error uploading file!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Gallery Image</title>
<style>
    body {
        font-family: Arial;
        background: #F1F8E9;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px;
        margin: 0;
    }

    .box {
        background: white;
        width: 430px;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0px 8px 22px rgba(0,0,0,0.12);
        text-align: center;
    }

    h2 {
        margin-top: 0;
        color: #1B5E20;
        font-weight: bold;
        margin-bottom: 15px;
    }

    input[type="file"] {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #c8c8c8;
        background: #fafafa;
        margin-bottom: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #1B5E20;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.25s;
    }
    button:hover { background: #104016; }

    .back {
        display: block;
        background: #c78015;
        text-decoration: none;
        color: white;
        padding: 10px;
        border-radius: 7px;
        margin-top: 16px;
        transition: 0.25s;
    }
    .back:hover { background: #2d2d2d; }

    .success, .error {
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 12px;
        font-weight: bold;
    }
    .success {
        background: #C8E6C9;
        color: #1B5E20;
        border: 1px solid #1B5E20;
    }
    .error {
        background: #FFCDD2;
        color: #B71C1C;
        border: 1px solid #B71C1C;
    }
</style>
</head>
<body>

<div class="box">
    <h2>➕ Upload Image</h2>

    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <a href="manage_gallery.php" class="back">⬅ Back to Gallery</a>
</div>

</body>
</html>
