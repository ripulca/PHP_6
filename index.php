<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PHP интаро</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h4 class="my-0 font-weight-normal">Обратная связь</h4>
    <form name='mail_form' class="form" method='POST'>
          <label for="FIO">FIO:</label><br>
          <input type="text" id="FIO" name="FIO" pattern="[А-я]{1,25} [А-я]{1,25} [А-я]{1,25}" required="required"><br>
          <label for="email">Электронная почта:</label><br>
          <input type="text" id="email" name="email" pattern="[a-zA-Z._]{3,25}@[a-z]{2,20}\.[a-z]{2,3}" required="required"><br>
          <label for="phone">Телефон:</label><br>
          <input type="text" id="phone" name="phone" pattern="\+?[0-9]{11}" required="required"><br>
          <label for="comment">Комментарий:</label><br>
          <textarea type="text" id="comment" name="comment" style="resize: vertical;" required="required"></textarea>
          <p class="error_msg"></p>
          <button class="btn submit_btn" id="submit_button">Отправить</button>
    </form>

    <div class="feedback_form close" id="feedback_form">
        <div class="feedback_form_msg" id="feedback_form_msg">
        </div>
    </div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="index.js"></script>
</html>