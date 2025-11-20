<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

if (!isset($_GET['id'])) {
    die("Achievement not found!");
}

$id = $_GET['id'];
$success = "";
$error = "";

// Fetch existing data
$result = mysqli_query($conn, "SELECT * FROM achievements WHERE id = $id LIMIT 1");
$ach = mysqli_fetch_assoc($result);

if (!$ach) {
    die("Achievement not found!");
}

// Update
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $year = $_POST['year'];
    $position = $_POST['position'];
    $description = $_POST['description'];

    $image_name = $ach['image']; // default old image

    // If new image selected
    if (!empty($_FILES['image']['name'])) {
        if ($image_name && file_exists("uploads/" . $image_name)) {
            unlink("uploads/" . $image_name); // delete old image
        }

        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
    }

    $query = "UPDATE achievements SET 
                title='$title',
                year='$year',
                position='$position',
                description='$description',
                image='$image_name'
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        $success = "Achievement updated successfully!";
        $ach = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM achievements WHERE id = $id"));
    } else {
        $error = "Error updating achievement!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Achievement</title>
<style>
    body { font-family: Arial; background:#e6eef7; display:flex; justify-content:center; padding:30px 0; }
    .container { width:500px; background:#fff; padding:25px; border-radius:12px; box-shadow:0 3px 12px rgba(0,0,0,0.15); max-height:90vh; overflow-y:auto; }
    h2 { text-align:center; color:#1e88e5; margin-bottom:15px; }
    label { font-weight:bold; margin-top:6px; display:block; }
    input, textarea { width:100%; padding:12px; margin-top:4px; border:1px solid #bbb; border-radius:6px; }
    button { width:100%; padding:12px; background:#1e88e5; color:white; border:none; border-radius:6px; font-size:17px; margin-top:15px; cursor:pointer; }
    button:hover { background:#0d6ac5; }
    .back { display:block; margin-top:15px; text-align:center; background:#424242; color:white; padding:10px; border-radius:6px; text-decoration:none; }
    img { width:130px; border-radius:8px; margin:10px 0; }
    .msg-success { color:green; font-weight:bold; text-align:center; }
    .msg-error { color:red; font-weight:bold; text-align:center; }
</style>
</head>
<body>

<div class="container">
<h2>✏ Edit Achievement</h2>

<?php if ($success) echo "<p class='msg-success'>$success</p>"; ?>
<?php if ($error) echo "<p class='msg-error'>$error</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" value="<?= $ach['title'] ?>" required>

    <label>Year</label>
    <input type="number" name="year" value="<?= $ach['year'] ?>" required>

    <label>Position</label>
    <input type="text" name="position" value="<?= $ach['position'] ?>" required>

    <label>Description</label>
    <textarea name="description" rows="4" required><?= $ach['description'] ?></textarea>

    <label>Current Image</label>
    <?php if ($ach['image']) { ?>
        <img src="uploads/<?= $ach['image'] ?>" alt="">
    <?php } else { echo "<p>No Image</p>"; } ?>

    <label>Upload New Image (optional)</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update">💾 Update Achievement</button>
</form>

<a class="back" href="manage_achievements.php">⬅ Back</a>
</div>

</body>
</html>
