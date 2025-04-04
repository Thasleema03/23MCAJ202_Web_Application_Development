<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Information</title>
    
    <!-- Internal CSS Styling -->
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 85%;
            max-width: 900px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    <!-- Container for the page content -->
    <div class="container">
        <h2>Student Details</h2>

        <?php
        // Connect to MySQL database: host, username, password, database name
        $conn = mysqli_connect("localhost", "root", "", "college");

        // If connection fails, show error message
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // SQL query to get all students from the 'students' table
        $sql = "SELECT * FROM students";
        $result = mysqli_query($conn, $sql);

        // Check if any records are returned
        if (mysqli_num_rows($result) > 0) {

            // Start HTML table
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Course</th></tr>";

            // Loop through each row and display the data in table format
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['course']}</td>
                       
                      </tr>";
            }

            // End of table
            echo "</table>";
        } else {
            // If no records found
            echo "<p>No student records found.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
