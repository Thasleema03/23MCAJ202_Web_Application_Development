<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Name Sorter</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin: -10px 0 10px;
        }
        .button-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        input[type="submit"], .back-button {
            flex: 1;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover,
        .back-button:hover {
            background-color: #0056b3;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            white-space: pre-wrap;
            border-left: 5px solid #007BFF;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
<?php
// Back button clicked
if (isset($_POST['go_back'])) {
    $_POST = [];
}

// Step 3: Display results
if (isset($_POST['names']) && !isset($_POST['go_back'])) {
    $students = $_POST['names'];
    $errors = [];
    $valid_students = [];

    foreach ($students as $i => $name) {
        $trimmed = trim($name);
        if (empty($trimmed)) {
            $errors[$i] = "Name cannot be empty";
        } elseif (!preg_match("/^[a-zA-Z ]+$/", $trimmed)) {
            $errors[$i] = "Only letters and spaces allowed";
        } else {
            $valid_students[$i] = $trimmed;
        }
    }

    if (!empty($errors)) {
        // Show form again with error messages
        echo "<h2>Enter Student Names</h2>";
        echo "<form method='post'>";
        foreach ($students as $i => $name) {
            $errorMsg = isset($errors[$i]) ? "<div class='error'>{$errors[$i]}</div>" : "";
            echo "<input type='text' name='names[]' value='".htmlspecialchars($name)."' placeholder='Student Name ".($i+1)."' required>$errorMsg";
        }
        echo "<div class='button-row'>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";

        echo "<form method='post'>";
        echo "<input type='submit' name='go_back' value='Back' class='back-button'>";
        echo "</form></div>";
    } else {
        echo "<h2>Sorted Student Names</h2>";
        echo "<h3>Original Array:</h3><pre>";
        print_r($valid_students);
        echo "</pre>";

        $asc = $valid_students;
        asort($asc);
        echo "<h3>Ascending Order:</h3><pre>";
        print_r($asc);
        echo "</pre>";

        $desc = $valid_students;
        arsort($desc);
        echo "<h3>Descending Order:</h3><pre>";
        print_r($desc);
        echo "</pre>";

        echo "<form method='post'><div class='button-row'>";
        echo "<input type='submit' name='go_back' value='Back to Start' class='back-button'>";
        echo "</div></form>";
    }
}
// Step 2: Name input form
elseif (isset($_POST['student_count'])) {
    $count = (int)$_POST['student_count'];
    echo "<h2>Enter Names of $count Students</h2>";
    echo "<form method='post'>";
    for ($i = 1; $i <= $count; $i++) {
        echo "<input type='text' name='names[]' placeholder='Student Name $i' required>";
    }
    echo "<div class='button-row'>";
    echo "<input type='submit' value='Submit'>";
    echo "</form>";

    echo "<form method='post'>";
    echo "<input type='submit' name='go_back' value='Back' class='back-button'>";
    echo "</form></div>";
}
// Step 1: Count input
else {
    echo "<h2>Enter Number of Students</h2>";
    echo "<form method='post'>";
    echo "<input type='number' name='student_count'  min='1' required>";
    echo "<input type='submit' value='Next'>";
    echo "</form>";
}
?>
</div>
</body>
</html>
