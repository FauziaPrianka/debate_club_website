<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
$gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Gallery</title>
<style>
    body {
        font-family: Arial;
        background:#e8f4df;
        padding:25px;
        margin:0;
    }
    h2 {
        color:#1B5E20;
        margin-bottom:20px;
    }

    .top-btn {
        background:#1B5E20;
        padding:10px 18px;
        color:white;
        text-decoration:none;
        border-radius:6px;
        font-size:15px;
        display:inline-block;
        margin-bottom:20px;
        transition:0.25s;
    }
    .top-btn:hover {
        background:#14471a;
    }

    table {
        width:100%;
        border-collapse: collapse;
        background:#F1F8E9;
        border-radius:8px;
        overflow:hidden;
        margin-top:10px;
    }
    th {
        background:#c5e1a5;
        color:#1B5E20;
        padding:12px;
        font-size:15px;
        text-transform: uppercase;
    }
    td {
        padding:12px;
        border-bottom:1px solid #d0e4c6;
        text-align:center;
        font-size:14px;
    }
    tr:hover {
        background:#d0e4c6;
    }

    img {
        width:130px;
        height:95px;
        object-fit:cover;
        border-radius:6px;
        transition:0.25s;
        cursor:pointer;
    }
    img:hover {
        transform: scale(1.08);
    }

    .no-img {
        font-style: italic;
        color: gray;
    }

    .action-btn {
        padding:7px 15px;
        border-radius:5px;
        text-decoration:none;
        font-size:14px;
        display:inline-block;
        color:white;
        transition:0.25s;
    }
    .delete {
        background:#d32f2f;
        font-weight:bold;
    }
    .delete:hover {
        background:#b71c1c;
    }
</style>
</head>
<body>

<h2>🖼 Manage Gallery</h2>

<a class="top-btn" href="add_gallery.php">➕ Add New Image</a>

<table>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Uploaded At</th>
    <th>Actions</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($gallery)) { ?>
<tr>
    <td><?= $row['id'] ?></td>

<td>
<?php
$file = "uploads/" . $row['image_path'];
if (!empty($row['image_path']) && file_exists($file)) { ?>
    <img src="<?= $file ?>" onclick="window.open('<?= $file ?>','_blank')" alt="Gallery">
<?php } else { ?>
    <span class="no-img">No Image</span>
<?php } ?>
</td>





    <td><?= date("d M, Y — h:i A", strtotime($row['uploaded_at'])) ?></td>

    <td>
        <a class="action-btn delete"
           href="delete_gallery.php?id=<?= $row['id'] ?>"
           onclick="return confirm('Delete this image permanently?');">
           🗑 Delete
        </a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
