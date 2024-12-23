<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Вы не авторизованы.");
}
$user_id = $_SESSION['user_id'];
$errors = [];
// Получение истории заявок пользователя
$history_query = $pdo->prepare("SELECT r.*, s.service_type FROM requests r JOIN services s ON r.service_id = s.id WHERE r.user_id = ?");
$history_query->execute([$user_id]);
$history_requests = $history_query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $contact_phone = $_POST['contact_phone'];
    $service_type = $_POST['service_type'];
    $additional_service = $_POST['additional_service'] ?? null;
    $payment_type = $_POST['payment_type'];
    $preferred_date = $_POST['preferred_date'] ?? null;

    if (empty($address) || empty($contact_phone) || empty($service_type) || empty($payment_type) || empty($preferred_date)) {
        $errors[] = "Пожалуйста, заполните все обязательные поля.";
    }

    $service_id_query = $pdo->prepare("SELECT id FROM services WHERE service_type = ?");
    $service_id_query->execute([$service_type]);
    $service_id = $service_id_query->fetchColumn();

    if (!$service_id) {
        $errors[] = "Выбранный тип услуги не существует.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, address, contact_phone, service_id, additional_service, payment_type, preferred_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $address, $contact_phone, $service_id, $additional_service, $payment_type, $preferred_date]);
        echo "Заявка успешно создана!";
    }
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<style>
    input[type="text"], input[type="datetime-local"], select {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        box-sizing: border-box; /* Учитывать отступы и границы в ширине */
    }
    button {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        cursor: pointer;
    }
</style>
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
          <a href="index.php">Главная</a>
         <a href="admin.php">администратора</a>
      </nav>
    </div>
</header>
<h1>Создание заявки</h1>
<form method="POST">
    Адрес: <input type="text" name="address" required><br>
    Контактный телефон: <input type="text" name="contact_phone" required><br>
    Вид услуги: <select name="service_type" required>
        <option value="general_cleaning">Общий клининг</option>
        <option value="deep_cleaning">Генеральная уборка</option>
        <option value="post_construction_cleaning">Послестроительная уборка</option>
        <option value="carpet_cleaning">Химчистка ковров</option>
        <option value="other">Иная услуга</option>
    </select><br>
    Дополнительная услуга: <input type="text" name="additional_service"><br>
    Тип оплаты: <select name="payment_type" required>
        <option value="cash">Наличные</option>
        <option value="card">Банковская карта</option>
    </select><br>
    Дата и время: <input type="datetime-local" name="preferred_date" required><br>
    <button type="submit">Создать заявку</button>
</form>
<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h1>История заявок</h1>
<table border="1" style="width: 100%;">
    <tr>
        <th>Адрес</th>
        <th>Контактный телефон</th>
        <th>Тип услуги</th>
        <th>Статус</th>
        <th>Дата и время</th>
    </tr>
    <?php foreach ($history_requests as $request): ?>
        <tr>
            <td><?php echo htmlspecialchars($request['address']); ?></td>
            <td><?php echo htmlspecialchars($request['contact_phone']); ?></td>
            <td><?php echo htmlspecialchars($request['service_type']); ?></td>
            <td><?php echo htmlspecialchars($request['status']); ?></td>
            <td><?php echo htmlspecialchars($request['preferred_date']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
