<?php
// Проверка, что CAPTCHA пройдена
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secret = '6LdOyqEpAAAAAA10cVSWQVkaTkwtDFN_tmyNhbEB';
    $captcha = $_POST['g-recaptcha-response'];
    
    // Отправить запрос на сервер reCAPTCHA для проверки
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    $responseKeys = json_decode($response, true);

    // Проверка результата
    if (intval($responseKeys["success"]) !== 1) {
      // Если CAPTCHA не пройдена, вы можете выполнить нужные действия, например, вывести сообщение об ошибке
      echo "Пожалуйста, пройдите проверку CAPTCHA.";
    } else {
      // Если CAPTCHA пройдена, обрабатываем данные из формы
      // Подключение к базе данных
      $servername = "localhost";
      $username = "saviorcheg";
      $password = "Ss859756211";
      $dbname = "saviorcheg";

      // Создание подключения
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Проверка подключения
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Проверка, была ли отправлена форма
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Генерация UUID
        $id = uniqid();
        // Получение данных из формы
        $userName = $_POST['userName'];
        $email = $_POST['email'];
        $text = $_POST['text'];
        // Получение IP-адреса пользователя
        $ip = $_SERVER['REMOTE_ADDR'];
        // Получение информации о браузере пользователя
        $browser = $_SERVER['HTTP_USER_AGENT'];
        // Установка часового пояса на Екатеринбург
        date_default_timezone_set('Asia/Yekaterinburg');
        // Формирование текущей даты
        $message_date = date('Y-m-d');
        // Формирование текущей даты и текущего времени
        $message_datetime = date('Y-m-d H:i:s'); 
        // Подготовка SQL запроса для вставки данных в таблицу
        $sql = "INSERT INTO messages (id, userName, email, text, ip, browser, message_date, message_datetime) VALUES ('$id','$userName', '$email', '$text', '$ip', '$browser', '$message_date', '$message_datetime')";

        // Попытка выполнения SQL запроса
        if ($conn->query($sql) === TRUE) {
          // echo "Данные успешно сохранены";
          header("Location: messages.php");
          exit();
        } else {
          echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
      }

      // Закрытие соединения с базой данных
      $conn->close();
    }
} else {
  // Если CAPTCHA не была отправлена, вы можете выполнить нужные действия, например, вывести сообщение об ошибке
  echo "Пожалуйста, пройдите проверку CAPTCHA.";
}