<?php
include 'db_connect.php';
session_start();

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM votes_topics WHERE id=$id"));

if(isset($_POST['submit'])){
    $title = $_POST['topic_title'];
    mysqli_query($conn, "UPDATE votes_topics SET topic_title='$title' WHERE id=$id");
    header("Location: vote_topics.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Vote Topic</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #F1F8E9;
    margin: 0;
    padding: 0;
}

.container {
    width: 45%;
    background: #ffffff;
    margin: 60px auto;
    padding: 30px 35px;
    border-radius: 10px;
    box-shadow: 0px 0px 12px rgba(0,0,0,0.12);
    border: 2px solid #d0e4c6;
}

h2 {
    text-align: center;
    color: #1B5E20;
    margin-bottom: 25px;
    font-size: 30px;
}

label {
    font-size: 18px;
    color: #1B5E20;
}

input[type="text"] {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 6px;
    border: 1px solid #c5e1a5;
    font-size: 17px;
    background: #e8f4df;
}
input[type="text"]:focus {
    border-color: #1B5E20;
    outline: none;
}

/* Submit Button */
button {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    background: #1B5E20;
    color: white;
    font-size: 18px;
    margin-top: 18px;
    font-weight: bold;
    transition: 0.3s;
}
button:hover {
    background: #388E3C;
}

/* Back Button */
.back-btn {
    display: inline-block;
    padding: 10px 16px;
    background: #d32f2f;
    color: #fff;
    border-radius: 5px;
    margin-top: 18px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
.back-btn:hover {
    background: #b71c1c;
}
</style>
</head>
<body>

<div class="container">
    <h2>Edit Vote Topic</h2>

    <form method="POST">
        <label>Topic Title:</label><br>
        <input type="text" name="topic_title" value="<?= $data['topic_title'] ?>" required><br>

        <button type="submit" name="submit">Update Topic</button>
    </form>

    <a href="vote_topics.php" class="back-btn">← Back to Vote Topics</a>
</div>

</body>
</html>
