<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Name </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
        }
        .output-box {
            background-color: #ffffff;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #007BFF;
        }
        h2 {
            color: #007BFF;
        }
        pre {
            background-color: #f8f8f8;
            padding: 10px;
            overflow: auto;
        }
    </style>
</head>
<body>

    <h2>Student Names</h2>

    <?php
    // Step 1: Store student names in an array
    $students = array("Anu", "Vimal", "Joseph", "Meera", "Amal");

    // Step 2: Display original array
    echo "<div class='output-box'>";
    echo "<h3>Original Array:</h3>";
    echo "<pre>";
    print_r($students);
    echo "</pre>";
    echo "</div>";

    // Step 3: Sort in ascending order using asort()
    $ascending = $students;
    asort($ascending);
    echo "<div class='output-box'>";
    echo "<h3>Ascending Order (asort):</h3>";
    echo "<pre>";
    print_r($ascending);
    echo "</pre>";
    echo "</div>";

    // Step 4: Sort in descending order using arsort()
    $descending = $students;
    arsort($descending);
    echo "<div class='output-box'>";
    echo "<h3>Descending Order (arsort):</h3>";
    echo "<pre>";
    print_r($descending);
    echo "</pre>";
    echo "</div>";
    ?>

</body>
</html>
