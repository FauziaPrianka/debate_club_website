<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

// ADD MODERATOR
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $dept = $_POST['department'];
    $role = $_POST['role'];

    // photo upload
    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];

    $fileName = time() . "_" . $photoName;  // filename only
    $target = "uploads/" . $fileName;
    move_uploaded_file($photoTmp, $target);

    $query = "INSERT INTO moderator (name, department, role, photo) 
              VALUES ('$name', '$dept', '$role', '$fileName')";
    mysqli_query($conn, $query);
    header("Location: moderator_management.php");
    exit();
}

// DELETE MODERATOR
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $getImg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT photo FROM moderator WHERE id=$id"));
    if ($getImg) {
        $filePath = "uploads/" . $getImg['photo'];
        if (file_exists($filePath)) unlink($filePath);
    }
    mysqli_query($conn, "DELETE FROM moderator WHERE id=$id");
    header("Location: moderator_management.php");
    exit();
}

// UPDATE MODERATOR
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dept = $_POST['department'];
    $role = $_POST['role'];

    if (!empty($_FILES['photo']['name'])) {
        $photoName = $_FILES['photo']['name'];
        $photoTmp = $_FILES['photo']['tmp_name'];
        
        $fileName = time() . "_" . $photoName;  // filename only
        $target = "uploads/" . $fileName;
        move_uploaded_file($photoTmp, $target);
        $photoUpload = ", photo = '$fileName'";
    } else {
        $photoUpload = "";
    }

    mysqli_query($conn, "UPDATE moderator SET 
                        name='$name',
                        department='$dept',
                        role='$role'
                        $photoUpload
                        WHERE id=$id");
    header("Location: moderator_management.php");
    exit();
}

$moderators = mysqli_query($conn, "SELECT * FROM moderator ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Moderator Management</title>
<style>
/* Your CSS unchanged */
body {
    font-family: Arial, sans-serif;
    background: #F1F8E9;
    margin: 0;
}
.container { width: 92%; margin: 35px auto; }
h2 { margin-bottom: 18px; color: #1B5E20; font-size: 30px; font-weight: 700; }
form { margin-bottom: 25px; background: #ffffff; padding: 22px; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.15); }
form h3 { color: #1B5E20; margin-bottom: 12px; }
input, select { width: 92%; padding: 10px; margin: 7px 0; border-radius: 6px; border: 1px solid #b5c9ad; font-size: 15px; }
button { padding: 10px 18px; border: none; cursor: pointer; background: #1B5E20; color: white; font-size: 15px; font-weight: 600; border-radius: 6px; transition: 0.2s; }
button:hover { background: #154a17; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.14); }
th { background: #1B5E20; color: white; padding: 12px; font-size: 15px; }
td { padding: 12px; text-align: center; border-bottom: 1px solid #d3e6c5; color: #2f3928; font-size: 15px; }
tr:hover { background: #e9f4dd; }
img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #cfe6bd; }
.actions a { color: white; padding: 6px 13px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; }
.edit { background: #18700aff; }
.edit:hover { background: #45ac55ff; }
.delete { background: #d32f2f; }
.delete:hover { background: #b71c1c; }
#editBox { display: none; background: #ffffff; padding: 25px; position: fixed; top: 12%; left: 30%; width: 38%; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,.5); }
#editBox button[type="button"] { background: #9e9e9e; }
#editBox button[type="button"]:hover { background: #7d7d7d; }
</style>
</head>
<body>
<div class="container">

<h2>🧑‍🏫 Moderator Management</h2>

<!-- ADD MODERATOR -->
<form method="POST" enctype="multipart/form-data">
  <h3>Add Moderator</h3>
  <input type="text" name="name" placeholder="Name" required>
  <input type="text" name="department" placeholder="Department" required>
  <input type="text" name="role" placeholder="Role" required>
  <input type="file" name="photo" required>
  <button type="submit" name="add">Add Moderator</button>
</form>

<table>
<tr>
  <th>ID</th>
  <th>Photo</th>
  <th>Name</th>
  <th>Department</th>
  <th>Role</th>
  <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($moderators)) { ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><img src="uploads/<?= $row['photo'] ?>"></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['department'] ?></td>
  <td><?= $row['role'] ?></td>
  <td class="actions">
    <a href="#" class="edit" onclick="editModerator(<?= $row['id'] ?>,'<?= $row['name'] ?>','<?= $row['department'] ?>','<?= $row['role'] ?>')">Edit</a>
    <a href="?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this moderator?');">Delete</a>
  </td>
</tr>
<?php } ?>
</table>

<!-- EDIT POPUP -->
<div id="editBox">
  <h3>Edit Moderator</h3>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" id="edit_id">
    <input type="text" name="name" id="edit_name" required>
    <input type="text" name="department" id="edit_department" required>
    <input type="text" name="role" id="edit_role" required>
    <input type="file" name="photo">
    <br><br>
    <button type="submit" name="update">Update</button>
    <button type="button" onclick="document.getElementById('editBox').style.display='none'">Cancel</button>
  </form>
</div>

<script>
function editModerator(id, name, dept, role) {
  document.getElementById("editBox").style.display = "block";
  document.getElementById("edit_id").value = id;
  document.getElementById("edit_name").value = name;
  document.getElementById("edit_department").value = dept;
  document.getElementById("edit_role").value = role;
}
</script>

</div>
</body>
</html>
