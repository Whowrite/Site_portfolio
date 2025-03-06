<?php
include 'connection.php';

// Обробка форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_info = $_POST['info'];
    $id = $_POST['id'];

    // Оновлення текстової інформації
    $sql = "UPDATE lastproject SET info = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $project_info, $id);
    $stmt->execute();

    // Оновлення зображень, якщо вони завантажені
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_FILES["photo$i"]['tmp_name'])) {
            $imageData = file_get_contents($_FILES["photo$i"]['tmp_name']);
            $sql = "UPDATE images SET photo$i = ? WHERE ID = (SELECT ID_images FROM lastproject WHERE ID = ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("bi", $imageData, $id);
            $stmt->send_long_data(0, $imageData);
            $stmt->execute();
        }
    }
}

// Отримання даних з БД
$sql = "SELECT * FROM `lastproject` INNER JOIN images ON `ID_images` = images.ID";
$result = $conn->query($sql);
$project = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="EN">
<head>
    <title>Адмін панель</title>
</head>
<body>
    <h1>Ласкаво просимо до адмін панелі!</h1>
    
    <form action="dashboard.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $project['ID']; ?>">
        
        <label for="info">Опис проєкту:</label><br>
        <textarea name="info" id="info" rows="4" cols="50"><?php echo htmlspecialchars($project['info']); ?></textarea><br>

        <label>Фото 1:</label><br>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($project['photo1']); ?>" width="150"><br>
        <input type="file" name="photo1"><br>

        <label>Фото 2:</label><br>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($project['photo2']); ?>" width="150"><br>
        <input type="file" name="photo2"><br>

        <label>Фото 3:</label><br>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($project['photo3']); ?>" width="150"><br>
        <input type="file" name="photo3"><br>

        <button type="submit">Зберегти зміни</button>
    </form>

    <!-- Кнопка для повернення на головну сторінку -->
    <br>
    <a href="index.php">
        <button type="button">Повернутися на головну</button>
    </a>
</body>
</html>