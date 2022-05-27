// Скрипты для страницы  админа, затрагивающие работу с DOM. По возможности, логика исключена.


// DOM элементы, с которыми будем работать
var domListCatalog = document.getElementById('list-catalog');


// Навешивание слушателей на дерево каталога
// Выбор элемента из списка (заполнение детальной формы)
addListenerWithTarget('click', domListCatalog, 'span.item-name>.text', function (elem) {
    if (document.getElementById('current-data').dataset.state == 'insert') return;
    document.getElementById('js-description').value = elem.closest('span.item-name').dataset.description;
    document.getElementById('js-name').value = elem.closest('span.item-name').dataset.name;
    document.getElementById('js-id').value = elem.closest('span.item-name').dataset.id;
    document.getElementById('js-parent').value = elem.closest('span.item-name').dataset.parent;
});
// выбор родителя при добавлении / обновлении
addListenerWithTarget('click', domListCatalog, 'span.item-name>.new-parent', function (elem) {
    document.getElementById('js-parent').value = elem.closest('span.item-name').dataset.id;
});
// сворачивание / разворачивание веток дерева каталога
addListenerWithTarget('click', domListCatalog, 'span.item-name>.plus,span.item-name>.minus', function (elem) {
    elem.closest('span.item-name').classList.toggle('collapsed')
});
// Конец, Навешивание слушателей на дерево каталога

// Привести форму к начальному состоянию
function clearForm() {
    document.getElementById('js-description').value = '';
    document.getElementById('js-name').value = '';
    document.getElementById('js-id').value = '';
    document.getElementById('js-parent').value = '';

    document.getElementById('js-update').style.display= '';
    document.getElementById('js-delete').style.display= '';
    document.getElementById('js-form-insert').style.display= '';
    document.getElementById('js-insert').style.display= 'none';

    document.getElementById('list-catalog').classList.remove('select-new-parent');
    document.getElementById('js-is-change-parent').checked = false;
    document.getElementById('js-is-change-parent').style.display = '';
    document.getElementById('current-data').dataset.state = ''
}

// Перезагрузка дерева каталога
function reloadCatalogTree() {
    clearForm();
    restReadAll().then(function (textBody) {
        domListCatalog.innerHTML = '';
        domListCatalog.appendChild(generateDomHierarchy(JSON.parse(textBody), true));
    });
}

reloadCatalogTree();

// Переход к форме добавления элемента
document.getElementById('js-form-insert').onclick = function () {
    clearForm();
    document.getElementById('js-update').style.display= 'none';
    document.getElementById('js-delete').style.display= 'none';
    document.getElementById('js-form-insert').style.display= 'none';
    document.getElementById('js-insert').style.display= '';

    document.getElementById('list-catalog').classList.add('select-new-parent');
    document.getElementById('js-is-change-parent').style.display = 'none';
    document.getElementById('current-data').dataset.state = 'insert'
}

// Установить признак того, что добавляем / перемещаем элемент в корень дерева
document.getElementById('js-add-in-root').onclick = function () {
    document.getElementById('js-parent').value = -1;
}

// В режиме редактирования. Собираемся ли мы перемещать элемент по дереву. От этого зависит визуал дерева.
document.getElementById('js-is-change-parent').onchange = function () {
    if (this.checked) {
        document.getElementById('list-catalog').classList.add('select-new-parent');
    }
    else {
        document.getElementById('list-catalog').classList.remove('select-new-parent');
    }
}

// Команда на вставку нового элемента
document.getElementById('js-insert').onclick = function () {
    restCreate(
        document.getElementById('js-name').value,
        document.getElementById('js-description').value,
        document.getElementById('js-parent').value,
    ).then((text) => {
        reloadCatalogTree();
        window.alert(text);
    });
}

// Команда на обновление элемента
document.getElementById('js-update').onclick = function () {
    if (document.getElementById('js-id').value == document.getElementById('js-parent').value) {
        window.alert('Нельзя переместить элемент на самого себя.');
        return;
    }
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

// Команда на удаление элемента
document.getElementById('js-delete').onclick = function () {
    restDelete(
        document.getElementById('js-id').value,
    ).then((text) => {
        reloadCatalogTree();
        window.alert(text);
    });
}

