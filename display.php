<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    // link dengan page login
    header('Location: login.php');
    exit;
}

// connect dengan database
$conn = new mysqli('localhost', 'root', '', 'lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Users</title>
</head>
<body>
    <h1>Users List</h1>
    
    <?php
    //table untuk paparkan database 
    echo "<table border='1'>
    <tr>
        <th>Matric</th>
        <th>Name</th>
        <th>Role</th>
    </tr>";

    if ($result->num_rows > 0) {

        // Output untuk setiap row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['matric']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "<td>
                    <a href='update.php?matric=" . urlencode($row['matric']) . "'>Update</a> |
                    <a href='delete.php?matric=" . urlencode($row['matric']) . "' onclick='return confirm
                    (\"Are you sure you want to delete this user?\");'>Delete</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users found in the database.</p>";
    }

    ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
