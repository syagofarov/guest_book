<!DOCTYPE html>
<html lang="ru">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale=1.0>
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Главная</title>
</head>

<body>
  <?php require "blocks/header.php" ?>
  <div class="container">
    <h2 class="text-center">Добро пожаловать!</h2>
    <p class="text-justify">
      Сайт предназначен для <a href="write-message-form"> отправки </a> и <a href="messages"> отображения </a> писем.
    </p>
  
    <p class="text-justify">
      Для того, чтобы написать письмо необходимо заполнить следующие данные: имя, адрес электронной почты, текст сообщения. Также необходимо пройти капчу.
    </p>

    <p class="text-justify">
      Реализована возможность сортировки писем в таблице по следующим полям: имя пользователя, адрес электронной почты, дата.
    </p>
  </div>
</body>

</html>