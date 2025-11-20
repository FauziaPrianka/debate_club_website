<?php
session_start();
include "db_connect.php";

$result = mysqli_query($conn, "SELECT * FROM executive_members ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Executive Members</title>
<style>
    body { font-family: Arial; background: #F1F8E9; margin: 0; padding: 25px; }

    h2 { text-align: center; color: #1B5E20; margin-bottom: 20px; font-size: 28px; }

    table { width: 95%; margin: 0 auto; border-collapse: collapse; background: white; }
    th { background: #1B5E20; color: white; padding: 12px; }
    td { padding: 12px; border-bottom: 1px solid #ccc; text-align: center; }

    img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }

    .add-btn {
        background: #1B5E20;
        color: white;
        padding: 10px 18px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-left: 2.5%;
        margin-bottom: 15px;
    }
    .add-btn:hover { background: #145017; }

    .edit-btn {
        color: #1B5E20;
        font-weight: bold;
        text-decoration: none;
    }
    .edit-btn:hover { text-decoration: underline; }

    .delete-btn {
        color: white;
        background: #D32F2F;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    .delete-btn:hover { background: #B71C1C; }
</style>
</head>
<body>

<h2>Executive Members</h2>
<a href="add_executive.php" class="add-btn">+ Add Member</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Role</th>
    <th>Department</th>
    <th>Photo</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['role'] ?></td>
    <td><?= $row['department'] ?></td>
    <td>
        <?php if($row['photo']) { ?>
            <img src="../admin/uploads/<?= $row['photo'] ?>" alt="Photo">
        <?php } else { echo "No Photo"; } ?>
    </td>
    <td>
        <a class="edit-btn" href="edit_executive.php?id=<?= $row['id'] ?>">✏ Edit</a> &nbsp;
        <a class="delete-btn" href="delete_executive.php?id=<?= $row['id'] ?>"
           onclick="return confirm('Delete this member?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
