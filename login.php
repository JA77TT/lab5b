<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Connect dengan database
    $conn = new mysqli('localhost', 'root', '', 'lab_5b');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // untuk cari dalam database
    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session 
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // link ke display page
            header('Location: display.php');
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Matric number not found.";
    }

    $conn->close();
}
?>

<!-- Login Form -->
<form method="post">
    Matric Number: <input type="text" name="matric" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="registration.html">Register here</a>.</p>
