<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Manage Events</title>
<style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background:#F1F8E9;
        padding:35px;
        margin:0;
    }

    h2 {
        margin-bottom:20px;
        color:#1B5E20;
        font-size:28px;
        font-weight:600;
    }

    .top-btn {
        background:#1B5E20;
        padding:11px 19px;
        color:#fff;
        text-decoration:none;
        border-radius:6px;
        font-size:16px;
        transition:.25s;
        font-weight:500;
    }
    .top-btn:hover { background:#15481A; }

    table {
        width:100%;
        border-collapse:collapse;
        margin-top:25px;
        background:white;
        border-radius:12px;
        overflow:hidden;
        box-shadow:0 5px 20px rgba(0,0,0,0.15);
    }

    th {
        background:#1B5E20;
        color:white;
        padding:14px;
        font-size:16px;
        letter-spacing:.5px;
    }

    td {
        padding:13px;
        border-bottom:1px solid #e6e6e6;
        font-size:15px;
    }

    .desc {
        max-width:280px;
        max-height:60px;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:pre-line;
    }

    a.action-btn {
        padding:7px 13px;
        text-decoration:none;
        color:white;
        border-radius:6px;
        font-size:14px;
        margin-right:6px;
        display:inline-block;
        transition:.25s;
    }

    .edit { background:#2E7D32; margin-bottom:10px }
    .edit:hover { background:#1B5E20; }

    .delete { background:#D32F2F; }
    .delete:hover { background:#B71C1C; }

    tr:hover { background:#EAF6E5; transition:.25s; }
</style>
</head>

<body>

<h2>📌 Manage Events</h2>

<a class="top-btn" href="add_event.php">➕ Add New Event</a>

<table>
    <tr>
        <th>ID</th>
        <th>Event Title</th>
        <th>Description</th>
        <th>Date</th>
        <th>Venue</th>
        <th>Register Link</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($events)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td class="desc"><?= $row['description'] ?></td>
        <td><?= $row['event_date'] ?></td>
        <td><?= $row['venue'] ?></td>
        <td>
            <?php if (!empty($row['register_link'])) { ?>
                <a href="<?= $row['register_link'] ?>" target="_blank">Open Link</a>
            <?php } else { echo "No Link"; } ?>
        </td>
        <td>
            <a class="action-btn edit" href="edit_event.php?id=<?= $row['id'] ?>">Edit</a>
            <a class="action-btn delete"
                href="delete_event.php?id=<?= $row['id'] ?>"
                onclick="return confirm('Are you sure you want to delete this event?');">
                Delete
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
