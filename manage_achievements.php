<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
$achievements = mysqli_query($conn, "SELECT * FROM achievements ORDER BY year DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Achievements</title>
<style>
    body {
        font-family: Arial;
        background:#e8f4df;
        padding:25px;
        margin:0;
    }
    h2 {
        color:#1B5E20;
        margin-bottom:18px;
        font-size:26px;
        font-weight:700;
    }

    a.btn {
        padding:10px 18px;
        background:#1B5E20;
        color:white;
        text-decoration:none;
        border-radius:6px;
        font-size:15px;
        font-weight:600;
        display:inline-block;
        transition:0.25s;
        margin-bottom:15px;
    }
    a.btn:hover {
        background:#14471a;
    }

    table {
        width:100%;
        border-collapse:collapse;
        background:#F1F8E9;
        border-radius:8px;
        overflow:hidden;
        margin-top:10px;
    }

    th {
        background:#c5e1a5;
        color:#1B5E20;
        padding:13px;
        font-size:15px;
        text-transform:uppercase;
        border-bottom:2px solid #b7d897;
    }

    td {
        padding:12px;
        border-bottom:1px solid #d0e4c6;
        font-size:14px;
        text-align:center;
    }

    tr:hover {
        background:#d0e4c6;
    }

    img {
        width:75px;
        height:75px;
        border-radius:8px;
        object-fit:cover;
        transition:0.25s;
        cursor:pointer;
    }
    img:hover {
        transform:scale(1.08);
    }

    /* Action Buttons */
    .edit {
        background:#4CAF50;
        margin-right:4px;
    }
    .edit:hover {
        background:#3a8b3e;
    }
    .delete {
        background:#d32f2f !important;
        font-weight:600;
    }
    .delete:hover {
        background:#b71c1c !important;
    }
</style>
</head>
<body>

<h2>🏆 Manage Achievements</h2>

<a class="btn" href="add_achievement.php">➕ Add New Achievement</a>

<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Year</th>
    <th>Position</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($achievements)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['year'] ?></td>
    <td><?= $row['position'] ?></td>

    <td>
        <?php if (!empty($row['image'])) { ?>
            <img src="uploads/<?= $row['image'] ?>" onclick="window.open('uploads/<?= $row['image'] ?>','_blank')" />
        <?php } else { ?>
            <span style="color:gray;font-style:italic;">No Image</span>
        <?php } ?>
    </td>

    <td>
        <a class="btn edit" href="edit_achievement.php?id=<?= $row['id'] ?>">✏ Edit</a>
        <a class="btn delete"
           href="delete_achievement.php?id=<?= $row['id'] ?>"
           onclick="return confirm('Are you sure you want to delete this achievement?');">
           🗑 Delete
        </a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
