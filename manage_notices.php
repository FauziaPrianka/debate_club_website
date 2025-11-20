<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

// ADD NOTICE
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];

    mysqli_query($conn, "INSERT INTO notices (title, description) VALUES ('$title', '$desc')");
    header("Location: manage_notices.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM notices WHERE id=$id");
    header("Location: manage_notices.php");
    exit();
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];

    mysqli_query($conn, "UPDATE notices SET title='$title', description='$desc' WHERE id=$id");
    header("Location: manage_notices.php");
    exit();
}

$notices = mysqli_query($conn, "SELECT * FROM notices ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Notices</title>

<style>
body { 
    font-family: Arial; 
    background: #F1F8E9; 
    margin: 0;
}
.container { 
    width: 92%; 
    margin: 35px auto; 
    background:#e8f4df; 
    padding:20px; 
    border-radius:12px;
    border: 2px solid #d0e4c6;
}
h2 {
    color:#1B5E20; 
    text-align:center;
    margin-bottom: 20px;
}

/* Add Notice Form */
form {
    background:#d0e4c6; 
    padding:18px; 
    margin-bottom:18px; 
    border-radius:10px;
}
input, textarea {
    width:90%; 
    padding:10px; 
    margin:8px 0; 
    border:1px solid #a5c38c;
    border-radius:6px;
    background:#c5e1a5;
}
button {
    padding:10px 18px; 
    border:none; 
    cursor:pointer; 
    border-radius:6px;
    background:#1B5E20; 
    color:white; 
    margin-top:5px;
}
button:hover {
    background:#164a19;
}

/* Table */
table { 
    width:100%; 
    border-collapse: collapse; 
    margin-top:25px; 
    background:white;
}
table, th, td { border:1px solid #a5c38c; }
th { 
    background:#1B5E20; 
    color:white; 
    padding:12px;
}
td { 
    padding:10px; 
    text-align:center;
}

/* Edit + Delete Buttons */
.actions a {
    display:inline-block;
    color:white;
    padding:8px 14px;
    border-radius:6px;
    text-decoration:none;
    margin-right:6px;
}
.edit { background:#1B5E20; margin-bottom:8px }
.edit:hover { background:#005c51; }

.delete { background:#d32f2f; }
.delete:hover { background:#b71c1c; }

/* EDIT POPUP */
#editBox { 
    display:none; 
    position:fixed; 
    top:15%; 
    left:32%; 
    width:36%; 
    background:#F1F8E9; 
    padding:25px; 
    border-radius:12px; 
    box-shadow:0 0 30px rgba(0,0,0,.4); 
    border:2px solid #d0e4c6;
}
#editBox h3 { color:#1B5E20; text-align:center; }

</style>
</head>
<body>

<div class="container">
<h2>📢 Notice Management</h2>

<!-- ADD NOTICE -->
<form method="POST">
  <h3>Add New Notice</h3>
  <input type="text" name="title" placeholder="Notice Title" required>
  <textarea name="description" placeholder="Notice Description" rows="3" required></textarea>
  <button type="submit" name="add">Add Notice</button>
</form>

<table>
<tr>
  <th>ID</th>
  <th>Title</th>
  <th>Description</th>
  <th>Notice Date</th>
  <th>Created At</th>
  <th>Action</th>
</tr>
<?php while ($row = mysqli_fetch_assoc($notices)) { ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['title'] ?></td>
  <td><?= $row['description'] ?></td>
  <td><?= $row['notice_date'] ?></td>
  <td><?= $row['created_at'] ?></td>
  <td class="actions">
    <a href="#" class="edit"
       onclick="editNotice(<?= $row['id'] ?>,'<?= htmlspecialchars($row['title']) ?>','<?= htmlspecialchars($row['description']) ?>')">Edit</a>
    <a href="?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this notice?');">Delete</a>
  </td>
</tr>
<?php } ?>
</table>

<!-- EDIT POPUP -->
<div id="editBox">
  <h3>Edit Notice</h3>
  <form method="POST">
    <input type="hidden" name="id" id="edit_id">
    <input type="text" name="title" id="edit_title" required>
    <textarea name="description" id="edit_description" rows="3" required></textarea>
    <br><br>
    <button type="submit" name="update">Update</button>
    <button type="button" onclick="document.getElementById('editBox').style.display='none'">Cancel</button>
  </form>
</div>

<script>
function editNotice(id, title, desc) {
    document.getElementById("editBox").style.display = "block";
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_description").value = desc;
}
</script>

</div>
</body>
</html>

