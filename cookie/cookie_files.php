<?php
// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Сохраняем данные в cookies на 1 неделю
    setcookie("name", $_POST['name'], time() + (7 * 24 * 60 * 60)); // 1 неделя
    setcookie("email", $_POST['email'], time() + (7 * 24 * 60 * 60)); // 1 неделя

    // Перезагружаем страницу для отображения сохраненных значений
    header("Location: registration.php");
    exit();
}

// Проверяем, установлен ли cookie и заполняем поля значениями из cookies
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form action="registration.php" method="post">
        <label for="name">Имя:</label><br>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

        <input type="submit" value="Зарегистрироваться">
    </form>
</body>
</html>