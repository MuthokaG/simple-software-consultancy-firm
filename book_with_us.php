<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data and trim any extra spaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $consultation_date = $_POST['consultation_date'];
    $message = trim($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($consultation_date)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='book_with_us.html';</script>";
        exit();
    }

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "software_consultancy_firm";  

    // Create MySQL connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the bookings table 
    $sql = "INSERT INTO client_bookings (name, email, phone, consultation_date, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare was successful
    if ($stmt === false) {
        die("MySQL prepare statement error: " . $conn->error);
    }

    // Bind the parameters to the prepared statement
    $stmt->bind_param("sssss", $name, $email, $phone, $consultation_date, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Success, redirect to homepage
        echo "<script>alert('Your consultation has been successfully booked! We will contact you soon.'); window.location.href='homepage.html';</script>";
    } else {
        // On error, show the MySQL error message
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='book_with_us.html';</script>";
    }

    // Close the prepared statement and the MySQL connection
    $stmt->close();
    $conn->close();
}
?>
