<?php
session_start();
$error = "";

// Step 1: Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1: Get number of players
    if (isset($_POST['num_players'])) {
        $_SESSION['num_players'] = intval($_POST['num_players']);
        $_SESSION['players'] = null;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Step 2: Get players
    if (isset($_POST['players'])) {
        $valid = true;
        $player_names = [];

        foreach ($_POST['players'] as $name) {
            $trimmed = trim($name);
            if (!preg_match("/^[a-zA-Z\s]+$/", $trimmed)) {
                $valid = false;
                $error = "Only letters and spaces are allowed in player names.";
                break;
            }
            $player_names[] = $trimmed;
        }

        if ($valid) {
            $_SESSION['players'] = $player_names;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Reset all session data
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Indian Cricket Players</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right,rgb(68, 91, 126),rgb(49, 132, 136));
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        input[type="number"], input[type="text"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        button {
            padding: 10px;
            flex: 1;
            background: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
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
            background: #f2f2f2;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Indian Cricket Players</h2>

    <?php if (!isset($_SESSION['num_players'])): ?>
        <!-- number of players -->
        <form method="POST">
            <label for="num_players">Enter number of players:</label>
            <input type="number" name="num_players" min="1" required>
            <button type="submit">Next</button>
        </form>

    <?php elseif (!isset($_SESSION['players'])): ?>
        <!-- player names -->
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <?php for ($i = 0; $i < $_SESSION['num_players']; $i++): ?>
                <input type="text" name="players[]" placeholder="Player <?= $i + 1 ?>" required>
            <?php endfor; ?>
            <div class="btn-row">
                <button type="submit">Submit</button>
                <button type="button" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>?reset=1'">Back</button>
            </div>
        </form>

    <?php else: ?>
        <!--  Display table -->
        <table>
            <tr>
                <th>SI. No</th>
                <th>Player Name</th>
            </tr>
            <?php foreach ($_SESSION['players'] as $index => $player): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($player) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <form method="GET">
            <button type="submit" name="reset" value="1">Enter Again</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
