<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vote Topics | Admin Panel</title>

<style>
/* ----- GLOBAL LAYOUT ----- */
body {
  font-family: Arial, sans-serif;
  background: #F1F8E9;
  margin: 0;
  padding: 0;
}

.container {
  width: 90%;
  margin: auto;
  padding: 30px 0;
}

/* ----- PAGE TITLE ----- */
h2 {
  text-align: center;
  color: #1B5E20;
  font-size: 32px;
  margin-bottom: 30px;
  font-weight: bold;
}

/* ----- TABLE DESIGN ----- */
table {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
}

th {
  background: #1B5E20;
  color: white;
  padding: 12px;
  font-size: 18px;
}

td {
  padding: 14px;
  border-bottom: 1px solid #d0e4c6;
  font-size: 17px;
}

tr:nth-child(even) {
  background: #e8f4df;
}

/* ----- BUTTONS ----- */
.btn {
  display: inline-block;
  padding: 10px 18px;
  text-decoration: none;
  border-radius: 5px;
  font-size: 16px;
  font-weight: bold;
  transition: 0.3s;
}

/* Add New Topic */
.btn-add {
  background: #1B5E20;
  color: white;
}
.btn-add:hover {
  background: #388E3C;
}

/* Action Buttons */
.action-btn {
  padding: 7px 14px;
  margin: 2px;
  border-radius: 4px;
  font-weight: bold;
  text-decoration: none;
  font-size: 15px;
  transition: 0.3s;
}

/* Edit Button */
.edit {
  background: #1B5E20;
  color: white;
}
.edit:hover {
  background: #4c784fff
}

/* Delete Button */
.delete {
  background: #d32f2f;
  color: white;
}
.delete:hover {
  background: #b71c1c;
}
</style>

</head>
<body>

<div class="container">
  <h2>Vote Topics</h2>

  <a href="add_vote_topic.php" class="btn btn-add">+ Add New Topic</a>
  <br><br>

  <table>
    <tr>
      <th>ID</th>
      <th>Topic Title</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM votes_topics ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['topic_title']; ?></td>
        <td><?= $row['created_at']; ?></td>
        <td>
          <a href="edit_vote_topic.php?id=<?= $row['id'] ?>" class="action-btn edit">Edit</a>
          <a href="delete_vote_topic.php?id=<?= $row['id'] ?>" class="action-btn delete"
             onclick="return confirm('Are you sure you want to delete this topic?');">
             Delete
          </a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

</body>
</html>
