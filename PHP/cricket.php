<?php
// Array of Indian Cricket Players
$players = [
    "Virat Kohli", "Rohit Sharma", "MS Dhoni", "Sachin Tendulkar", "Rahul Dravid", 
    "Kapil Dev", "Sourav Ganguly", "Yuvraj Singh", "Hardik Pandya", "Jasprit Bumrah"
];

// Sort the array in ascending order
asort($players);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Cricket Players</title>
    <!-- CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(0, 10, 43);
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Main container for the table -->
    <div class="container">
        <h1>List of Indian Cricket Players</h1>
        <!-- Table to display player list -->
        <table>
            <tr>
                <!-- Table headers -->
                <th>SI. No</th>
                <th>Player Name</th>
            </tr>

            <!-- PHP loop to display each player's name -->
            <?php 
            $count = 1; // Initialize serial number
            foreach ($players as $player) { // Loop through each player
            ?>
                <tr>
                    <!-- Display serial number -->
                    <td><?php echo $count++; ?></td>
                    <!-- Display player name -->
                    <td><?php echo $player; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

