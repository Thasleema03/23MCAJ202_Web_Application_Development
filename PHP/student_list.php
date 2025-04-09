<?php
// Connect to MySQL
$conn = mysqli_connect("localhost", "root", "");

//  Create database if it doesn't exist
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS college_students");

//  Select the database
mysqli_select_db($conn, "college_students");

// Create table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    course VARCHAR(100)
)";
mysqli_query($conn, $createTable);

//  Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $course = trim($_POST['course']);

    $errors = [];

    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Invalid name. Only letters and spaces allowed.";
    }
    if (!is_numeric($age) || $age < 1 || $age > 120) {
        $errors[] = "Invalid age. Enter a number between 1 and 120.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $course)) {
        $errors[] = "Invalid course. Only letters and spaces allowed.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO students (name, age, course) VALUES ('$name', $age, '$course')";
        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color:green;'>Student added successfully.</p>";
        } else {
            $message = "<p style='color:red;'>Database error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        foreach ($errors as $err) {
            $message .= "<p style='color:red;'>$err</p>";
        }
    }
}

// Fetch existing students
$students = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Information</title>
    <!-- CSS -->
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 85%;
            max-width: 900px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #1abc9c;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #16a085;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #1abc9c;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #eaeaea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Details</h2>

        <!-- Display message if any -->
        <?php echo $message; ?>

        <!-- Form -->
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="text" name="course" placeholder="Course" required>
            <button type="submit">Add Student</button>
        </form>

        <!-- Table of students -->
        <?php if (mysqli_num_rows($students) > 0): ?>
            <table>
                <tr><th>ID</th><th>Name</th><th>Age</th><th>Course</th></tr>
                <?php while ($row = mysqli_fetch_assoc($students)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= htmlspecialchars($row['course']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No student records found.</p>
        <?php endif; ?>
        <?php mysqli_close($conn); ?>  <!-- close connection -->
    </div>
</body>
</html>
