<?php
$host = "localhost"; // Хост (локальний сервер)
$user = "root";      // Користувач (root за замовчуванням)
$pass = "";          // Пароль (у OpenServer зазвичай порожній)
$db = "BD_portfolio";    // Назва бази даних

// Створення з'єднання
$conn = new mysqli($host, $user, $pass, $db);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}
?>