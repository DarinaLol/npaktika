<?php
include 'db.php';
session_start(); // Запускаем сессию
// Проверка на авторизацию администратора
if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'] ?? ''; // Исправлено для избежания ошибки
        $password = $_POST['password'] ?? ''; // Исправлено для избежания ошибки
        if ($username === 'adminka' && $password === 'password') {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $error = "Неверный логин или пароль.";
        }
    } else {
        // Если не авторизован, показываем форму логина
        ?>
        <form method="POST">
            Логин: <input type="text" name="username" required><br>
            Пароль: <input type="password" name="password" required><br>
            <button type="submit">Войти</button>
        </form>
        <?php
        exit;
    }
}

// Обработка выхода из кабинета администратора
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$requests = $pdo->query("SELECT r.*, u.name FROM requests r JOIN users u ON r.user_id = u.id")->fetchAll(PDO::FETCH_ASSOC);

// Обработка изменения статуса заявки
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $cancellation_reason = $_POST['cancellation_reason'] ?? null;
    $stmt = $pdo->prepare("UPDATE requests SET status = ?, cancellation_reason = ? WHERE id = ?");
    $stmt->execute([$status, $cancellation_reason, $request_id]);

    echo "Статус заявки обновлен!";
}

// Обработка очистки истории заявок
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_history'])) {
    $user_id = $_SESSION['user_id'] ?? null; // Замените на правильный способ получения user_id
    if ($user_id) {
        $clear_query = $pdo->prepare("DELETE FROM requests WHERE user_id = ?");
        $clear_query->execute([$user_id]);
        echo "История заявок успешно очищена!";
    } else {
        echo "Ошибка: не удалось определить пользователя.";
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
            <a href="register.php">Регистрация</a>
            <a href="login.php">Вход</a>
            <a href="create_request.php">Оставить заявку</a>
            <a href="index.php">Главная</a>
        </nav>
    </div>
</header>
<h1>Панель администратора</h1>
<!-- Кнопка выхода -->
<form method="POST">
    <button type="submit" name="logout">Выйти из кабинета администратора</button>
</form>
<form method="POST">
    <button type="submit" name="clear_history">Очистить историю заявок</button>
</form>
<table border="1" style="width: 100%; table-layout: fixed;">
    <tr>
        <th>ФИО</th>
        <th>Тип услуги</th>
        <th>Контактные данные</th>
        <th>Адрес</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($requests as $request): ?>
    <tr>
        <td><?php echo htmlspecialchars($request['name']); ?></td>
        <td><?php 
            // Получаем тип услуги по ID
            $service_id = $request['service_id'];
            $service_query = $pdo->prepare("SELECT service_type FROM services WHERE id = ?");
            $service_query->execute([$service_id]);
            $service_type = $service_query->fetchColumn();
            echo htmlspecialchars($service_type); 
        ?></td>
        <td><?php echo htmlspecialchars($request['contact_phone']); ?></td>
        <td><?php echo htmlspecialchars($request['address']); ?></td>
        <td><?php echo htmlspecialchars($request['status']); ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                <select name="status" required>
                    <option value="pending" <?php if ($request['status'] == 'pending') echo 'selected'; ?>>В ожидании</option>
                    <option value="completed" <?php if ($request['status'] == 'completed') echo 'selected'; ?>>Завершено</option>
                    <option value="canceled" <?php if ($request['status'] == 'canceled') echo 'selected'; ?>>Отменено</option>
                </select>
                <button type="submit" name="update_status">Обновить статус</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
