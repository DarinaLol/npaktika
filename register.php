<?php
// Подключение к базе данных
require 'db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Валидация
    if (strlen($password) < 6) {
        $errors[] = "Пароль должен содержать минимум 6 символов.";
    }
    if (!preg_match('/^[а-яА-ЯёЁ\s]+$/u', $fullName)) {
        $errors[] = "ФИО должно содержать только кириллицу и пробелы.";
    }
    // Изменено регулярное выражение для телефона
    if (!preg_match('/^\d{3}-\d{3}-\d{2}-\d{2}$/', $phone)) {
        $errors[] = "Телефон должен быть в формате XXX-XXX-XX-XX.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный адрес электронной почты.";
    }

    // Проверка уникальности логина
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Логин уже занят.";
    }

    // Если нет ошибок, добавляем пользователя
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users (login, password, full_name, phone, email) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$login, password_hash($password, PASSWORD_DEFAULT), $fullName, $phone, $email])) {
            // Перенаправление на главную страницу
            header("Location: index.php");
            exit(); // Завершение скрипта после перенаправления
        } else {
            echo "Ошибка при регистрации.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } 
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<header>
    <h1>Клининговые услуги «Мой Не Сам»</h1>
    <div class="lol">
        <a href="index.php">
            <img src="img/logo.png" alt="Логотип Мой Не Сам" class="logo">
        </a>
    </div>
    <div class="naf">
        <nav>
        <a href="index.php">Главная</a>
            <a href="login.php">Вход</a>
            <a href="create_request.php">Оставить заявку</a>
            <a href="admin.php">администратора</a>
        </nav>
    </div>
</header>

<!-- HTML форма регистрации -->
<form method="POST">
    <input type="text" name="login" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="text" name="full_name" placeholder="ФИО" required>
    <input type="text" name="phone" placeholder="Телефон (XXX-XXX-XX-XX)" required>
    <input type="email" name="email" placeholder="Электронная почта" required>
    <button type="submit">Зарегистрироваться</button>
</form>

<?php if ($errors): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
