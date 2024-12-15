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

// dapatkan data dari table
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
}

// Update data user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully. <a href='display.php'>Go back</a>";
    } else {
        echo "Error updating user: " . $conn->error;
    }
    $conn->close();
    exit;
}

?>
<!--html coding-->
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>

        <label for="role">Access Level:</label>
        <select id="role" name="role" required>
            <option value="student" <?= $user['role'] == 'student' ? 'selected' : '' ?>>Student</option>
            <option value="lecturer" <?= $user['role'] == 'lecturer' ? 'selected' : '' ?>>Lecturer</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br>

        <button type="submit">Update</button>
    </form>
    <p><a href="display.php">Cancel</a></p>
</body>
</html>
