<?php
session_start();

// Database connection parameters
$servername = "127.0.0.1:3307"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "routeskin"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve email and password from form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute SQL statement using prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a user with the given email exists
if ($result->num_rows == 1) {
    // Fetch user data
    $row = $result->fetch_assoc();
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Password is correct, create session and redirect to questionnaire
        $_SESSION['email'] = $email;
        header("Location: knowyourskin.html");
        exit();
    } else {
        // Password is incorrect
        echo "Invalid email or password";
    }
} else {
    // No user found with the given email
    echo "Invalid email or password";
}

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>

