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
<? if ($_GET['logout'] == 'yes'): ?>
    <?php
    Auth::logout();
    ?>
    <h2>Вы вышли из админки</h2>
    <p><a href="?">Авторизоваться</a></p>
    <p><a href="user.php">Режим только просмотра</a></p>
<? elseif (Auth::isAdminAuth() || Auth::login($_POST['login'], $_POST['password'])): ?>
<? //Основной код для авторизованного админа?>
    <h2>Вы админ</h2>
    <p><a href="?logout=yes">Выйти</a></p>

    <div class="catalog-container">
        <div id="list-catalog" class="select-new-parent">
        </div>
        <div id="current-data" data-id="">
            <div>
                <span>Родитель:</span>
                <br>
                <input type="text" id="js-parent" disabled="disabled">
            </div>
            <div>
                <span>Название:</span>
                <br>
                <input type="text" id="js-name">
            </div>
            <div style="margin-top: 20px">
                <span>Данные:</span>
                <br>
                <textarea id="js-description" rows="10" cols="70"></textarea>
            </div>
            <div style="margin-top: 20px">
                <input type="button" id="js-update" value="Сохранить">
                <input type="button" id="js-delete" value="Удалить">
            </div>
            <input type="hidden" id="js-id">
        </div>
    </div>


    <script type="text/javascript">
        var token = '<?=$_SESSION['token']?>';
    </script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/rest.js"></script>

    <script type="text/javascript">
        var domListCatalog = document.getElementById('list-catalog');
        addListenerWithTarget('click', domListCatalog, 'span.item-name>.text', function (elem) {
            document.getElementById('js-description').value = elem.closest('span.item-name').dataset.description;
            document.getElementById('js-name').value = elem.closest('span.item-name').dataset.name;
            document.getElementById('js-id').value = elem.closest('span.item-name').dataset.id;
            document.getElementById('js-parent').value = elem.closest('span.item-name').dataset.parent;
        });

        addListenerWithTarget('click', domListCatalog, 'span.item-name>.plus,span.item-name>.minus', function (elem) {
            elem.closest('span.item-name').classList.toggle('collapsed')
        });

        function reloadCatalogTree() {
            restReadAll().then(function (textBody) {
                domListCatalog.innerHTML = '';
                domListCatalog.appendChild(generateDomHierarchy(JSON.parse(textBody), true));

            });
        }

        reloadCatalogTree();

        document.getElementById('js-update').onclick = function () {
            restUpdate(
                document.getElementById('js-id').value,
                document.getElementById('js-name').value,
                document.getElementById('js-description').value,
                document.getElementById('js-parent').value,
            ).then((text) => {
                reloadCatalogTree();
                window.alert(text);
            });
        }

        document.getElementById('js-delete').onclick = function () {
            restDelete(
                document.getElementById('js-id').value,
            ).then((text) => {
                reloadCatalogTree();
                window.alert(text);
            });
        }

    </script>
<? //Конец, Основной код для авторизованного админа?>

<? else: ?>
    <h2>Авторизуйтесь пожалуйста</h2>
    <? if ($_POST['login']): ?>
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
