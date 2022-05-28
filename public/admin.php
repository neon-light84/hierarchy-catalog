<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php

use App\Services\Auth;

require_once '../index.php';
?>
<? if (isset($_GET['logout']) && $_GET['logout'] === 'yes'): ?>
    <?php
    Auth::logout();
    ?>
    <h2>Вы вышли из админки</h2>
    <p><a href="?">Авторизоваться</a></p>
    <p><a href="user.php">Режим только просмотра</a></p>
<? elseif (
        Auth::isAdminAuth() ||
        (isset($_POST['login']) && isset($_POST['password']) && Auth::login($_POST['login'], $_POST['password']))
): ?>
<? //Основной код для авторизованного админа?>
    <h2>Вы админ</h2>
    <p><a href="?logout=yes">Выйти</a></p>

    <div class="catalog-container">
        <div id="list-catalog" class="">
        </div>
        <div id="current-data" class="state-initial">
            <div>
                <span>Родитель:</span>
                <br>
                <input type="text" id="js-parent" disabled="disabled">
                <label class="is-change-parent"><input type="checkbox" id="js-is-change-parent"> Изменить родителя</label>
                <input id="js-add-in-root" type="button" value="Добавить в корень">

            </div>
            <div>
                <span>Название:</span>
                <br>
                <input type="text" id="js-name">
            </div>
            <div>
                <span>Данные:</span>
                <br>
                <textarea id="js-description" rows="10" cols="70"></textarea>
            </div>
            <div>
                <input type="button" id="js-update" value="Сохранить">
                <input type="button" id="js-delete" value="Удалить">
                <input type="button" id="js-form-insert" value="Форма добавления нового">
                <input type="button" id="js-insert" value="Добавить новый">
            </div>
            <input type="hidden" id="js-id">
        </div>
    </div>


    <script type="text/javascript">
        var token = '<?=isset($_SESSION['token']) ? $_SESSION['token'] : '';?>';
    </script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/rest.js"></script>
    <script type="text/javascript" src="js/admin_dom.js"></script>
<? //Конец, Основной код для авторизованного админа?>

<? else: ?>
    <h2>Авторизуйтесь пожалуйста</h2>
    <? if (isset($_POST['login'])): ?>
    <p>Не правильный логин или пароль</p>
<? endif; ?>
    <form action="#" method="post" class="register">
        <div class="fields">
            <label>login: <input type="text" name="login"></label>
            <label>пароль: <input type="password" name="password"></label>
        </div>
        <input type="submit">
    </form>

<? endif; ?>


</body>
</html>


<?php
