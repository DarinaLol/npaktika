<?php
include 'db.php';

session_start();
if (!isset($_SESSION['admin'])) {
    die("Доступ запрещен.");
}

// Получение всех заявок
$stmt = $pdo->query("SELECT * FROM requests");
$requests = $stmt->fetchAll();

foreach ($requests as $request) {
    echo "Заявка ID: " . $request['id'] . " - Статус: " . $request['status'] . "<br>";
    // Добавьте возможность изменения статуса
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">


<!-- HTML для панели администратора -->
<h1>Панель администратора</h1>
<table>
    <tr>
        <th>ФИО</th>
        <th>Контактные данные</th>
        <th>Статус</th>
        <th>Действия</th>
        
    </tr>
    <?php foreach ($requests as $request): ?>
        <tr>
            <td><?php echo $request['full_name']; ?></td>
            <td><?php echo $request['contact']; ?></td>
            <td><?php echo $request['status']; ?></td>
            <td>
                <form method="POST">
                    <select name="status">
                        <option value="в работе">В работе</option>
                        <option value="выполнено">Выполнено</option>
                        <option value="отменено">Отменено</option>
                    </select>
                    <input type="text" name="reason" placeholder="Причина отмены">
                    <button type="submit">Изменить статус</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
