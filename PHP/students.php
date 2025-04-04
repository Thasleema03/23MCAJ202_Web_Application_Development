<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Name List</title>
<!-- CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }
        .container {
            width: 60%; 
            max-width: 1000px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .tables {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        table {
            width: 30%; 
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Name List</h2>

        <?php
        // Array of student names
        $students = array("Anu", "Vimal", "Joseph", "Meera", "Amal");

        // Store the original array before sorting
        $original_students = $students;

        // Function to display a table
        function displayTable($title, $array) {
            echo "<div>";
            echo "<h3>$title</h3>";
            echo "<table>";
            echo "<tr><th>Index</th><th>Name</th></tr>";
            foreach ($array as $index => $name) {
                echo "<tr><td>$index</td><td>$name</td></tr>";
            }
            echo "</table></div>";
        }

        echo "<div class='tables'>";
        
        // Display original array
        displayTable("Original Order", $original_students);

        // Sort ascending and display
        asort($students);
        displayTable("Ascending Order", $students);

        // Sort descending and display
        arsort($students);
        displayTable("Descending Order", $students);

        echo "</div>";
        ?>
    </div>
</body>
</html>
