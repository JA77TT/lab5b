<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'lab_5b');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the data into the users table
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='login.php'>Click here to login</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
