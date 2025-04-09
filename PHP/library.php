<?php
// DB connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_store";

// Create connection to MySQL server (without selecting DB yet)
$conn = new mysqli($servername, $username, $password);

// Check server connection
if ($conn->connect_error) {
    die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
}

// Create database if not exists
$dbCreateSQL = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($dbCreateSQL)) {
    die("<div class='error'>Database creation failed: " . $conn->error . "</div>");
}

// Select the created/available DB
$conn->select_db($dbname);

// Create table if not exists
$tableCreateSQL = "CREATE TABLE IF NOT EXISTS books (
    accession_number INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    authors VARCHAR(255),
    edition VARCHAR(100),
    publisher VARCHAR(255)
)";
if (!$conn->query($tableCreateSQL)) {
    die("<div class='error'>Table creation failed: " . $conn->error . "</div>");
}

$message = "";
$searchResults = "";
$searchDone = false;

// Show success message if redirected after book insert
if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    $message = "<div class='success'>✅ Book added successfully!</div>";
    echo "<script>history.replaceState(null, null, window.location.pathname);</script>";
}

// Text validation function
function isValidText($text) {
    return preg_match("/^[a-zA-Z0-9\s,.\-]+$/", $text);
}

// Back to home from search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['back_to_home'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Add book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $acc_no = $_POST['accession_number'];
    $title = trim($_POST['title']);
    $authors = trim($_POST['authors']);
    $edition = trim($_POST['edition']);
    $publisher = trim($_POST['publisher']);

    $errors = [];

    if (!is_numeric($acc_no) || intval($acc_no) <= 0) {
        $errors[] = "Accession number must be a positive number.";
    }
    if (!isValidText($title)) {
        $errors[] = "Title can only contain letters, numbers, spaces, commas, hyphens, and dots.";
    }
    if (!isValidText($authors)) {
        $errors[] = "Authors can only contain valid characters.";
    }
    if (!isValidText($edition)) {
        $errors[] = "Edition can only contain valid characters.";
    }
    if (!isValidText($publisher)) {
        $errors[] = "Publisher can only contain valid characters.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO books (accession_number, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $acc_no, $title, $authors, $edition, $publisher);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?msg=success");
            exit();
        } else {
            $message = "<div class='error'>❌ Error: " . htmlspecialchars($stmt->error) . "</div>";
        }
        $stmt->close();
    } else {
        foreach ($errors as $err) {
            $message .= "<div class='error'>❌ " . htmlspecialchars($err) . "</div>";
        }
    }
}

// Search book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_book'])) {
    $searchDone = true;
    $search = "%" . $_POST['search_title'] . "%";
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $searchResults .= "<table><tr>
            <th>Accession No</th><th>Title</th><th>Authors</th><th>Edition</th><th>Publisher</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $searchResults .= "<tr>
                <td>{$row['accession_number']}</td>
                <td>{$row['title']}</td>
                <td>{$row['authors']}</td>
                <td>{$row['edition']}</td>
                <td>{$row['publisher']}</td>
            </tr>";
        }
        $searchResults .= "</table>";
    } else {
        $searchResults .= "<p class='error'>❌ No books found.</p>";
    }
    $stmt->close();
}

//  Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management</title>
    <!-- CSS -->
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: rgb(234, 245, 255);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .search-row {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }
        .search-row input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .search-row input[type="submit"] {
            padding: 10px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .search-row input[type="submit"]:hover {
            background: #0056b3;
        }

        form.add-form label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        form.add-form input[type="text"],
        form.add-form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .add-form input[type="submit"] {
            padding: 10px 18px;
            background: rgb(23, 38, 250);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0 auto;
        }
        .add-form input[type="submit"]:hover {
            background: rgb(36, 30, 126);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }

        .success, .error {
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
        .back-btn input[type="submit"] {
            padding: 10px 20px;
            background-color: rgb(0, 102, 190);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .back-btn input[type="submit"]:hover {
            background-color: rgb(42, 149, 255);
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (!$searchDone): ?>
        <!-- Search Bar -->
        <form class="search-row" method="POST">
            <input type="text" name="search_title" placeholder="Search by title" required>
            <input type="submit" name="search_book" value="Search">
        </form>

        <!-- Add Book Form -->
        <h2>📘 Add a New Book</h2>
        <?= $message ?>
        <form class="add-form" method="POST">
            <label>Accession Number</label>
            <input type="number" name="accession_number" required>

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Authors</label>
            <input type="text" name="authors" required>

            <label>Edition</label>
            <input type="text" name="edition" required>

            <label>Publisher</label>
            <input type="text" name="publisher" required>

            <input type="submit" name="add_book" value="Add Book">
        </form>
    <?php endif; ?>

    <!-- Search Results -->
    <?= $searchResults ?>

    <?php if ($searchDone): ?>
        <div class="back-btn">
            <form method="POST">
                <input type="submit" name="back_to_home" value="Back">
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
