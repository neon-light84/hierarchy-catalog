<?php
require_once  '../../index.php';
use App\Services\CrudCatalog;
use App\Services\Auth;

if (!Auth::isAdminAuth()) exit("Не авторизованы. Перезагрузите страницу. ");

$httpMethod = $_SERVER["REQUEST_METHOD"];

switch (strtoupper($httpMethod)) {
    case 'GET': {
        echo CrudCatalog::getAll();
        break;
    }
    case 'POST': {
        $res = CrudCatalog::create([
            'parent' => $_GET['parent'],
            'name' => $_GET['name'],
            'description' => $_GET['description'],
        ]);
        echo $res ? "Данные добавлены" : "Ошибка добавления";
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
