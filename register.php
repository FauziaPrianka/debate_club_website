<?php
// Show any PHP errors (for debugging during development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session (optional but useful later)
session_start();

// Connect to your database
$conn = new mysqli("localhost", "root", "", "debate_club_db"); // change to your actual DB name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Optional: Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered! Try logging in.'); window.location.href='signin.html';</script>";
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // Registration successful — redirect to sign-in page
        echo "<script>alert('Registration successful! Please sign in.'); window.location.href='signin.html';</script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
