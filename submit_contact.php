<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Simple server-side validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='contact.html';</script>";
        exit;
    }

    // Database connection
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "software_consultancy_firm"; 
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo "<script>alert('Connection failed: " . $conn->connect_error . "'); window.location.href='contact.html';</script>";
        exit;
    }

    // Prepare SQL query to insert data
    $sql = "INSERT INTO contact_messages (sender_name, sender_email, message) VALUES (?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "<script>alert('SQL Error: Could not prepare statement.'); window.location.href='contact.html';</script>";
        exit;
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='contact.html';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
