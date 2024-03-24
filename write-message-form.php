<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale=1.0>
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <title>Написать письмо</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
  <?php require "blocks/header.php" ?>

  <form class="container" action ="send-message.php" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Написать письмо</h1>

    <input type="text" name="userName" id="userName" class="form-control" placeholder="Ваш никнейм" autofocus=""> </br>
    
    <input type="email" id="email" name="email" class="form-control" placeholder="E-mail"> </br> 
    
    <div class="g-recaptcha" id="captcha" data-sitekey="6LdOyqEpAAAAAL4j9nH6p9AHJVgO1ReVhEuJb8Y0"></div><br>
    
    <input type="text" id="text" name="text" class="form-control" placeholder="Текст"> </br>
    
    <button class="btn btn-lg btn-block btn-primary"  type="submit" id="submitButton" disabled>Отправить письмо</button>
  </form>
  <script>
    function validateForm() {
      var userName = document.getElementById("userName").value;
      var email = document.getElementById("email").value;
      var text = document.getElementById("text").value;

      var submitButton = document.getElementById("submitButton");
      submitButton.disabled = !(userName.trim() !== '' && email.trim() !== '' && text.trim() !== '');
    }

    document.getElementById("userName").addEventListener("input", validateForm);
    document.getElementById("email").addEventListener("input", validateForm);
    document.getElementById("text").addEventListener("input", validateForm);
    
    grecaptcha.render(
      document.getElementById('captcha'), 
      {
        callback: validateForm, 
        sitekey: '6LdOyqEpAAAAAL4j9nH6p9AHJVgO1ReVhEuJb8Y0'
      }
    );
    
  </script>
</body>
</html>