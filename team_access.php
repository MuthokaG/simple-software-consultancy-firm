<?php
// Start the session to store login state
session_start();

// Database credentials
$host = 'localhost';  
$dbname = 'software_consultancy_firm'; 
$username = 'root'; 
$password = ''; 

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM logins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching row was found
    if ($result->num_rows > 0) {
        // Successful login, redirect to team_page.html
        header("Location: team_page.html");
        exit();
    } else {
        // Login failed, redirect back to the login page with an error
        echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = 'team_access.html';</script>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
