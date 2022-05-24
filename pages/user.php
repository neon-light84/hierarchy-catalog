<?php require_once  '../index.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<span id="js-json-catalog-hierarchy" style="display: none"><?=\App\Controllers\CRUDData::getAll();?></span>

<div class="main-container">
    <div id="list-catalog">
    </div>
    <div>
        <label>
            <span>Данные:</span>
            <textarea id="js-description" disabled="disabled"></textarea>
        </label>
    </div>
</div>

<script type="text/javascript" src="main.js"></script>

<script type="text/javascript">
    var dataCatalog = JSON.parse(document.getElementById('js-json-catalog-hierarchy').innerText)
    var domListCatalog = document.getElementById('list-catalog');

    domListCatalog.appendChild(generateDomHierarchy(dataCatalog));

    addListenerWithTarget('click', domListCatalog, 'span.item-name>.text', function (elem) {
        document.getElementById('js-description').innerText = elem.closest('span.item-name').dataset.description;
    });
    addListenerWithTarget('click', domListCatalog, 'span.item-name>.plus,span.item-name>.minus', function (elem) {
        elem.closest('span.item-name').classList.toggle('collapsed')
    });
</script>
</body>
</html>
