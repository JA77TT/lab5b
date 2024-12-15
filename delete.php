<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// connect dengan database
$conn = new mysqli('localhost', 'root', '', 'lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    $sql = "DELETE FROM users WHERE matric='$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully. <a href='display_users.php'>Go back</a>";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
