<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

// Fetch counts from database
$eventsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM events"))['total'];
$membersCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM members"))['total'];
$moderatorCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM moderator"))['total'];
$executiveCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM executive_members"))['total'];
$galleryCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM gallery"))['total'];
$achievementCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM achievements"))['total'];
$noticeCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices"))['total'];
$votesCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM votes_topics"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | CCN-UST Debate Club</title>

<style>
  body {
    font-family: 'Poppins', Arial, sans-serif;
    background: #F1F8E9;
    margin: 0;
  }

  .header {
    background: transparent;
    color: white;
    padding: 18px 35px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .header h2 { margin: 0; font-size: 23px; color:#1B5E20}

  .logout {
    background: #c62828;
    padding: 8px 16px;
    text-decoration: none;
    color: white;
    border-radius: 6px;
    font-size: 15px;
    transition: .25s;
  }
  .logout:hover { background: #b71c1c; }

  .container {
    padding: 40px 35px;
    text-align: center;
  }

  .container h2 {
    font-size: 28px;
    color: #1B5E20;
    margin-bottom: 6px;
  }

  .container p {
    color: #4d4d4d;
    font-size: 17px;
  }

  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 25px;
    margin-top: 45px;
  }

  .card {
    background: white;
    padding: 26px 22px;
    border-radius: 14px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.18);
    text-decoration: none;
    transition: .28s;
    border-left: 6px solid #1B5E20;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 26px rgba(0, 0, 0, 0.32);
  }

  .card h3 {
    margin: 0 0 12px 0;
    font-size: 21px;
    font-weight: 600;
    color: #1B5E20;
  }

  .card p {
    margin: 0;
    font-size: 37px;
    font-weight: 700;
    color: #000;
  }
</style>
</head>
<body>

<div class="header">
  <h2>⚡ Admin Dashboard</h2>
  <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">
  <h2>Welcome, <b><?php echo $_SESSION['admin_username']; ?></b> 👋</h2>
  <p>Select a section below to manage the website.</p>

  <div class="card-container">

    <a class="card" href="manage_events.php">
      <h3>📌 Events</h3>
      <p><?= $eventsCount ?></p>
    </a>

    <a class="card" href="members.php">
      <h3>👥 Members</h3>
      <p><?= $membersCount ?></p>
    </a>

    <a class="card" href="moderator_management.php">
      <h3>🧑‍🏫 Moderators</h3>
      <p><?= $moderatorCount ?></p>
    </a>

    <a class="card" href="executive_members.php">
      <h3>🧑‍💼 Executive Members</h3>
      <p><?= $executiveCount ?></p>
    </a>

    <a class="card" href="manage_gallery.php">
      <h3>🖼 Gallery</h3>
      <p><?= $galleryCount ?></p>
    </a>

    <a class="card" href="manage_achievements.php">
      <h3>🏆 Achievements</h3>
      <p><?= $achievementCount ?></p>
    </a>

    <a class="card" href="manage_notices.php">
      <h3>📢 Notices</h3>
      <p><?= $noticeCount ?></p>
    </a>

    <a class="card" href="votes_topics.php">
      <h3>🗳 Vote Topics</h3>
      <p><?= $votesCount ?></p>
    </a>

  </div>
</div>

</body>
</html>
