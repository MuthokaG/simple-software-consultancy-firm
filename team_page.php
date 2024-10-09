<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "software_consultancy_firm";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// View records
if (isset($_POST['view_bookings'])) {
    $result = $conn->query("SELECT * FROM client_bookings");
    if ($result->num_rows > 0) {
        echo "<h2>Client Bookings</h2><ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>Booking ID: " . $row['id'] . " | Name: " . $row['name'] . " | Email: " . $row['email'] . "  | Phone Number: " . $row['phone'] . "  | Message: " . $row['message'] . "| Date: " . $row['submission_date'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No bookings found.";
    }
} elseif (isset($_POST['view_messages'])) {
    $result = $conn->query("SELECT * FROM contact_messages");
    if ($result->num_rows > 0) {
        echo "<h2>Contact Messages</h2><ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>Message ID: " . $row['id'] . "  | Email: " . $row['sender_email'] . "| Name: " . $row['sender_name'] . " | Message: " . $row['message'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No messages found.";
    }
}
// Update client booking
if (isset($_POST['update_booking'])) {
    // Ensure all necessary fields are set
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['consultation_date'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $consultation_date = $_POST['consultation_date'];
        $email = $_POST['email'];

        // Update query - make sure to use the correct column names in your table
        $stmt = $conn->prepare("UPDATE client_bookings SET name=?, phone=?, consultation_date=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $consultation_date, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Record updated successfully!'); window.location.href='team_page.html';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "'); window.location.href='team_page.html';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Missing required fields.'); window.location.href='team_page.html';</script>";
    }
}

// View bookings
if (isset($_POST['view_bookings'])) {
    $result = $conn->query("SELECT * FROM client_bookings");
    if ($result->num_rows > 0) {
        echo "<h2>Client Bookings</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Booking ID: " . $row['id'] . " | Name: " . $row['name'] . " | Phone: " . $row['phone'] . " | Consultation Date: " . $row['consultation_date'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No bookings found.";
    }
}
// Delete booking or message
if (isset($_POST['delete_booking'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM client_bookings WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
       echo "<script>alert('Booking deleted successfully!'); window.location.href='team_page.html';</script>";
    } else {
        echo "<script>alert('Error deleting booking: '. $conn->error); window.location.href='team_page.html';</script>";
    }
} elseif (isset($_POST['delete_message'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM contact_messages WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
       echo "<script>alert('Message deleted successfully!'); window.location.href='team_page.html';</script>";
    } else {
        echo "Error deleting message: " . $conn->error; echo "<script>alert('Error deleting message: ' . $conn->error'); window.location.href='team_page.html';</script>";
    }
}

$conn->close();
?>
