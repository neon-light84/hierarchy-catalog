<?php

namespace App\Helpers;

/**
 * Преобразует реляционную структуру в полноценную иерархическую.
 */
class RelationToHierarchy
{
    private static $relationData;

    /**
     * @param array $data данные, как они получены после fetchAll
     * @return array
     */
    public static function run(&$data)
    {
        static::$relationData = $data;

        // Что бы во всей реляционной структуре не было родителей с пустыми/null значениями. Это мешается для рекурсии.
        for ($i = 0; $i < count(static::$relationData); $i++) {
            if (!static::$relationData[$i]['parent']) static::$relationData[$i]['parent'] = -1;
        }

        return static::recurse(-1);
    }

    private static function recurse($curParentId) {
        $returned = [];
        $idDel = [];

        foreach (static::$relationData as $key => $item) {
            if ((int)$item['parent'] === (int)$curParentId) {
                $idDel[] = $key;
                $returned[] = ['self' => $item, 'childs' => static::recurse($item['id'])];
            }
        }

        // Чистим те записи, которые уже использовали. Мы их больше не будем использовать. А дальнейший перебор
        // будет быстрее.
        // Можно было бы удалять прямо в цикле выше, но могут быть ошибки из-за того, что меняем внутри
        // итерационного цикла, сам итерируемый массив.
        // Другим вариантом было бы использовать выше, цикл for, и удалять лишние записи прямо в нем.
        // Но по идеен, цикл for медленнее для итерируемого перебора.
        foreach ($idDel as $index) {
            unset(static::$relationData[$index]);
        }

        return $returned;
    }


}
