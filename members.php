<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

// Fetch all members
$members = mysqli_query($conn, "SELECT * FROM members ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Members</title>
<style>
    body {
    font-family: Arial, sans-serif;
    background: #F1F8E9;
    padding: 25px;
    margin: 0;
}

h2 {
    margin-bottom: 18px;
    color: #1B5E20;
    font-size: 28px;
    font-weight: 700;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

th {
    background: #1B5E20;
    color: white;
    padding: 12px;
    font-size: 15px;
    letter-spacing: 0.5px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #d0e4c6;
    text-align: center;
    font-size: 15px;
    color: #2e3d2b;
}

tr:hover {
    background: #e8f4df;
}

img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid #c5e1a5;
}

.delete-btn {
    padding: 7px 14px;
    background: #d32f2f;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}
.delete-btn:hover {
    background: #b71c1c;
}

</style>
</head>
<body>

<h2>👥 All Members</h2>

<table>
<tr>
    <th>ID</th>
    <th>Member ID</th>
    <th>Name</th>
    <th>University ID</th>
    <th>Department</th>
    <th>Semester</th>
    <th>Photo</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($members)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['member_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['uni_id'] ?></td>
    <td><?= $row['department'] ?></td>
    <td><?= $row['semester'] ?></td>
    <td>
        <img src="uploads/<?= $row['photo'] ?>" alt="Photo">

    <td>
        <a class="delete-btn" href="delete_member.php?id=<?= $row['id'] ?>" 
        onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
