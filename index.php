<?php
// Подключение к базе данных
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Мой Не Сам - Главная</title>
    <style>
 .service-card {
    flex: 1 1 20%; /* Устанавливает ширину карточек */
    margin: 10px; /* Отступы между карточками */
    padding: 20px; /* Внутренние отступы */
    border: 1px solid #ccc; /* Граница карточки */
    border-radius: 5px; /* Закругление углов */
    display: flex; /* Используем flexbox для выравнивания содержимого */
    flex-direction: column; /* Вертикальное выравнивание */
    align-items: stretch; /* Растягиваем элементы по ширине */
}

.request-button {
    color: white; /* Цвет текста кнопки */
    border: none; /* Убираем границу */
    padding: 10px 15px; /* Внутренние отступы */
    border-radius: 5px; /* Закругление углов кнопки */
    cursor: pointer; /* Указатель при наведении */
    margin-top: auto; /* Отодвигаем кнопку вниз */
}

.request-button:hover {
    background-color:  #4b0082; /* Цвет фона при наведении */
}

    </style>
</head>
<body>
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
            <a href="login.php">Вход</a>
            <a href="create_request.php">Оставить заявку</a>
            <a href="admin.php">администратора</a>
        </nav>
    </div>
</header>
    <main>
        <style> 
.hea {
    background-color: white; /* Белый фон для карточки */
    border: 1px solid #ddd; /* Граница карточки */
    border-radius: 8px; /* Закругление углов */
    padding: 20px; /* Внутренние отступы */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Тень для карточки */
    text-align: center; /* Центрирование текста */
}

.hea h1{
    color:rgb(80, 66, 170); /* Черный цвет текста */
    font-weight:bolder;
}
.hea p{
  color:rgb(80, 66, 170);
  font-weight:bolder;
  font-size: 17px;
}
h2 {
    text-align: center; /* Центрирование заголовка */
    color:#6a5acd;
}
        </style>
        <div class="hea">
        <h1> Добро пожаловать в  нашу надежную клининговую службу!</h1>
        <p>В современном мире, где время — самый ценный ресурс, забота о чистоте и порядке
             в вашем доме или офисе может стать настоящим вызовом. Мы понимаем, как важна для 
             вас каждая минута, и именно поэтому рады представить вам нашу клининговую службу «Не Мой Сам». 
             Наша команда профессионалов готова взять на себя все заботы по уборке, чтобы вы могли сосредоточиться на том, что действительно важно.</p>
             </div>
        <h2>Наши услуги  </h2>

<div class="services">
    <div class="service-card">
        <h3>Общий клининг</h3>
        <p>Полная уборка Вашего помещения с использованием профессиональных средств.</p>
        <button class="request-button" onclick="location.href='create_request.php'">Заявка</button>
    </div>
    <div class="service-card">
        <h3>Генеральная уборка</h3>
        <p>Глубокая уборка всех уголков Вашего дома или офиса.</p>
        <button class="request-button" onclick="location.href='create_request.php'">Заявка</button>
    </div>
    <div class="service-card">
        <h3>Послестроительная уборка</h3>
        <p>Уборка после ремонта или строительства с удалением строительного мусора.</p>
        <button class="request-button" onclick="location.href='create_request.php'">Заявка</button>
    </div>
    <div class="service-card">
        <h3>Химчистка ковров и мебели</h3>
        <p>Профессиональная химчистка для восстановления чистоты и свежести.</p>
        <button class="request-button" onclick="location.href='create_request.php'">Заявка</button>
    </div>
    <div class="service-card">
        <h3>Иная услуга</h3>
        <p>Если у Вас есть особые пожелания, мы готовы их обсудить.</p>
        <button class="request-button" onclick="location.href='create_request.php'">Заявка</button>
    </div>
</div>


    </main>

    <footer>
        <p>&copy; 2024 Мой Не Сам. Все права защищены.</p>
    </footer>
</body>
</html>
