<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale=1.0>
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <title>Письма</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
  </head>
  <body>
    <?php require "blocks/header.php" ?>
    <script>
      var sortDirections = {};

      function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector('.table');
        switching = true;
        var sortOrder = sortDirections[columnIndex] || 'asc'; // Проверяем текущий порядок сортировки или устанавливаем "asc" по умолчанию
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[columnIndex];
                y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                if (sortOrder === 'asc') {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                      shouldSwitch = true;
                      break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                      shouldSwitch = true;
                      break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        // Переключаем направление сортировки
        sortDirections[columnIndex] = sortOrder === 'asc' ? 'desc' : 'asc';
      }
    </script>
    <div class="container mt-5">
      <h1 class="mb-3">Список писем</h1>
      <table class="table">
        <thead>
          <tr>
          <th>#</th>
            <th onclick="sortTable(1)"> <p class="link mb-0"> Имя пользователя </p></th>
            <th onclick="sortTable(2)"> <p class="link mb-0"> Email </p></th>
            <th> Текст </th>
            <th> IP </th>
            <th> Браузер </th>
            <th onclick="sortTable(6)"> <p class="link mb-0"> Дата </p></th>
          </tr>
        </thead>
        <tbody>
            <?php
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

            // Определение текущей страницы
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $limit = 5; // Количество сообщений на странице
            $offset = ($page - 1) * $limit;

            // Запрос к базе данных для получения сообщений с учетом пагинации
            $sql = "SELECT * FROM messages ORDER BY message_datetime DESC LIMIT $limit OFFSET $offset ";
            $result = $conn->query($sql);

            // Вывод сообщений в таблицу
            if ($result->num_rows > 0) {
                $count = $offset + 1;
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$count}</td>"; 
                  echo "<td>{$row['userName']}</td>";
                  echo "<td>{$row['email']}</td>";
                  echo "<td>{$row['text']}</td>";
                  echo "<td>{$row['ip']}</td>";
                  echo "<td>{$row['browser']}</td>";
                  echo "<td>{$row['message_datetime']}</td>";
                  echo "</tr>";
                  $count++;
                }
            } else {
              echo "<tr><td colspan='6'>Нет сообщений</td></tr>";
            }
            ?>
        </tbody>
      </table>

        <!-- Пагинация -->
        <nav aria-label="Page navigation example">
          <ul class="pagination">
              <?php
                // Вывод ссылок на страницы
                $sql = "SELECT COUNT(*) AS total FROM messages";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $total_pages = ceil($row["total"] / $limit);

                for ($i = 1; $i <= $total_pages; $i++) {
                  echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
                // Закрытие соединения с базой данных
                $conn->close();
              ?>
          </ul>
        </nav>
      </div>
  </body>
</html>