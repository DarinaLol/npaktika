<?php
// Подключение к базе данных
include 'db.php';

$errors = []; // Инициализация переменной $errors

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Изменено с 'username' на 'login'
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Проверка существования логина в базе данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?"); // Исправлено на 'login'
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Успешная авторизация
        session_start();
        $_SESSION['user_id'] = $user['id'];
        echo "Добро пожаловать, " . $user['full_name'];
        // Перенаправление на главную страницу после успешной авторизации
        header("Location: index.php");
        exit();
    } else {
        $errors[] = "Неверный логин или пароль."; // Добавление ошибки в массив
    }
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<header>
    <h1>Клининговые услуги «Мой Не Сам»</h1>
    <div class="lol">
        <a href="index.php"> <!-- Добавлен тег <a> для ссылки на главную страницу -->
            <img src="img/logo.png" alt="Логотип Мой Не Сам" class="logo">
        </a>
    </div>
    <div class="naf">
        <nav>
            <a href="register.php">Регистрация</a>
            <a href="index.php">Главная</a>
            <a href="create_request.php">Оставить заявку</a>
            <a href="admin.php">администратора</a>
        </nav>
    </div>
</header>

<form method="POST">
    <!-- Изменено с 'username' на 'login' -->
    Логин: <input type="text" name="login" required><br>
    Пароль: <input type="password" name="password" required><br>
    <button type="submit">Войти</button>
</form>

<?php if (!empty($errors)): ?> <!-- Проверка на наличие ошибок -->
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
