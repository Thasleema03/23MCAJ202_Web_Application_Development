<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Information</title>
    
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

        <!-- Form for user input -->
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="text" name="course" placeholder="Course" required>
            <button type="submit">Add Student</button>
        </form>

        <?php
        // Connect to MySQL database
        $conn = mysqli_connect("localhost", "root", "", "college_students");

        // If connection fails, show error message
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $age = trim($_POST['age']);
            $course = trim($_POST['course']);

            $errors = [];

            // Name validation
            if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $errors[] = "Invalid name. Only letters and spaces are allowed.";
            }

            // Age validation
            if (!is_numeric($age) || $age < 1 || $age > 120) {
                $errors[] = "Invalid age. Please enter a number between 1 and 120.";
            }

            // Course validation
            if (!preg_match("/^[a-zA-Z\s]+$/", $course)) {
                $errors[] = "Invalid course. Only letters and spaces are allowed.";
            }

            // Display errors or insert into DB
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            } else {
                $sql = "INSERT INTO students (name, age, course) VALUES ('$name', $age, '$course')";
                if (mysqli_query($conn, $sql)) {
                    echo "<p style='color:green;'>Student added successfully.</p>";
                } else {
                    echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
                }
            }
        }

        // Fetch and display student records
        $sql = "SELECT * FROM students";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Course</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['course']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No student records found.</p>";
        }

        // Close DB connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
