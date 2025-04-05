<?php
$error = "";
$num_players = "";
$player_names = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Reset everything
    if (isset($_POST['reset'])) {
        $num_players = "";
        $player_names = [];
        $error = "";
    }

    // If number of players is submitted
    elseif (isset($_POST['num_players'])) {
        $num_players = intval($_POST['num_players']);
        if ($num_players <= 0) {
            $error = "Please enter a valid number of players.";
            $num_players = "";
        }
    }

    // If player names are submitted
    elseif (isset($_POST['players'])) {
        $valid = true;
        foreach ($_POST['players'] as $name) {
            $trimmed = trim($name);
            if (!preg_match("/^[a-zA-Z\s]+$/", $trimmed)) {
                $valid = false;
                $error = "Only letters and spaces allowed in names.";
                break;
            }
            $player_names[] = $trimmed;
        }

        if (!$valid) {
            $num_players = count($_POST['players']); // retain for redisplay
            $player_names = []; // clear to re-enter
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Indian Cricket Players</title>
    <style>
        body {
            font-family: Arial;
            background: #e0f2f1;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        button {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
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
<div class="container">
    <h2>Indian Cricket Players</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Step 1: Get number of players -->
    <?php if ($num_players === "" && empty($player_names)): ?>
        <form method="post">
            <label>Enter number of players:</label>
            <input type="number" name="num_players" min="1" required>
            <button type="submit">Next</button>
        </form>

    <!-- Step 2: Get player names -->
    <?php elseif (empty($player_names)): ?>
        <form method="post">
            <?php for ($i = 0; $i < $num_players; $i++): ?>
                <input type="text" name="players[]" placeholder="Player <?= $i + 1 ?>" required>
            <?php endfor; ?>
            <div class="btn-row">
                <button type="submit">Submit</button>
                <button type="submit" name="reset">Back</button>
            </div>
        </form>

    <!-- Step 3: Show result table -->
    <?php else: ?>
        <table>
            <tr><th>SI. No</th><th>Player Name</th></tr>
            <?php foreach ($player_names as $index => $name): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($name) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form method="post" style="margin-top: 20px;">
            <button type="submit" name="reset">Enter Again</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
