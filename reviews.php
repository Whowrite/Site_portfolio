<?php
include 'connection.php';

// Обробка форми додавання відгуку
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    $username = !empty($_POST['username']) ? $_POST['username'] : "Анонім";
    $userfeedback = $_POST['feedback'];

    $stmt = $conn->prepare("INSERT INTO feedback (username, userfeedback) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $userfeedback);
    $stmt->execute();
    $stmt->close();
}

// Обробка пошуку
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $sql = "SELECT username, userfeedback FROM feedback WHERE username LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $searchTerm);
} else {
    $sql = "SELECT username, userfeedback FROM feedback";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$feedbacks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="UK">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Відгуки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #1F3C70;
        }

        .feedback-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .feedback-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .feedback-item:last-child {
            border-bottom: none;
        }

        .feedback-item strong {
            color: #1F3C70;
        }

        .form-container {
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            background-color: #1F3C70;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #FECF51;
            color: #1F3C70;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input {
            width: calc(100% - 20px);
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1F3C70;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #FECF51;
            color: #1F3C70;
        }
    </style>
</head>
<body>

    <h1>Відгуки користувачів</h1>

    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Пошук за іменем..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Пошук</button>
        </form>
    </div>

    <div class="feedback-container">
        <?php if (!empty($feedbacks)): ?>
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback-item">
                    <strong><?php echo htmlspecialchars($feedback['username']); ?>:</strong>
                    <p><?php echo nl2br(htmlspecialchars($feedback['userfeedback'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Немає відгуків.</p>
        <?php endif; ?>
    </div>

    <div class="form-container">
        <h2>Залишити відгук</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Ваше ім'я (необов'язково)">
            <textarea name="feedback" placeholder="Ваш відгук..." required></textarea>
            <button type="submit">Надіслати</button>
        </form>
    </div>

    <a href="index.php" class="back-button">Повернутися на головну</a>

</body>
</html>