<?php
require_once  '../../index.php';
use App\Services\CrudCatalog;

if ($_SESSION['token'] != $_GET['token']) exit("Не авторизованы");

$httpMethod = $_SERVER["REQUEST_METHOD"];

switch (strtoupper($httpMethod)) {
    case 'GET': {
        echo CrudCatalog::getAll();
        break;
    }
    case 'POST': {
        echo 'POST';
        break;
    }
    case 'PUT': {
        $res = CrudCatalog::update([
            'id' => $_GET['id'],
            'parent' => $_GET['parent'],
            'name' => $_GET['name'],
            'description' => $_GET['description'],
        ]);
        echo $res ? "Данные обновлены" : "Ошибка обновления";
        break;
    }
    case 'PATCH': {
        // Пока не требуется.
        break;
    }
    case 'DELETE': {
        $res = CrudCatalog::delete([
            'id' => $_GET['id'],
        ]);
        echo $res ? "Элемент удален" : "Ошибка удаления";
        break;
    }
}
