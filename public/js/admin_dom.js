// Скрипты для страницы  админа, затрагивающие работу с DOM. По возможности, логика исключена.


// DOM элементы, с которыми будем работать
var domCatalogHierarchy = document.getElementById('list-catalog');
var domCurrentData = document.getElementById('current-data');
var domItemDescription = document.getElementById('js-description');
var domItemName = document.getElementById('js-name');
var domItemId = document.getElementById('js-id');
var domItemParent = document.getElementById('js-parent');
var domFormControlUpdate = document.getElementById('js-update');
var domFormControlDelete = document.getElementById('js-delete');
var domFormControlFormStateInsert = document.getElementById('js-form-insert');
var domFormControlInsert = document.getElementById('js-insert');
var domFormControlIsChangeParent = document.getElementById('js-is-change-parent');

// Навешивание слушателей на дерево каталога
// Выбор элемента из списка (заполнение детальной формы)
addListenerWithTarget(
    'click',
    domCatalogHierarchy,
    'span.item-name>.text',
    function (elem) {
        if (domCurrentData.dataset.state === 'insert') return;
        domItemDescription.value = elem.closest('span.item-name').dataset.description;
        domItemName.value = elem.closest('span.item-name').dataset.name;
        domItemId.value = elem.closest('span.item-name').dataset.id;
        domItemParent.value = elem.closest('span.item-name').dataset.parent;
    });
// выбор родителя при добавлении / обновлении
addListenerWithTarget(
    'click',
    domCatalogHierarchy,
    'span.item-name>.new-parent',
    function (elem) {
        domItemParent.value = elem.closest('span.item-name').dataset.id;
    });
// сворачивание / разворачивание веток дерева каталога
addListenerWithTarget('click', domCatalogHierarchy, 'span.item-name>.plus,span.item-name>.minus', function (elem) {
    elem.closest('span.item-name').classList.toggle('collapsed')
});
// Конец, Навешивание слушателей на дерево каталога

// Привести форму к начальному состоянию
function clearForm() {
    domItemDescription.value = '';
    domItemName.value = '';
    domItemId.value = '';
    domItemParent.value = '';

    domCatalogHierarchy.classList.remove('select-new-parent');
    domFormControlIsChangeParent.checked = false;
    domCurrentData.classList.add('state-initial');
    domCurrentData.classList.remove('state-insert');
}

// Переход к форме добавления элемента
domFormControlFormStateInsert.onclick = function () {
    clearForm();
    domCatalogHierarchy.classList.add('select-new-parent');
    domCurrentData.classList.remove('state-initial');
    domCurrentData.classList.add('state-insert');
}

// Перезагрузка дерева каталога
function reloadCatalogTree() {
    clearForm();
    restReadAll().then(function (textBody) {
        domCatalogHierarchy.innerHTML = '';
        domCatalogHierarchy.appendChild(generateDomHierarchy(JSON.parse(textBody), true));
    });
}

reloadCatalogTree();

// Установить признак того, что добавляем / перемещаем элемент в корень дерева
document.getElementById('js-add-in-root').onclick = function () {
    domItemParent.value = -1;
}

// В режиме редактирования. Собираемся ли мы перемещать элемент по дереву. От этого зависит визуал дерева.
domFormControlIsChangeParent.onchange = function () {
    if (this.checked) {
        domCatalogHierarchy.classList.add('select-new-parent');
    }
    else {
        domCatalogHierarchy.classList.remove('select-new-parent');
    }
}

// Команда на вставку нового элемента
domFormControlInsert.onclick = function () {
    restCreate(
        domItemName.value,
        domItemDescription.value,
        domItemParent.value,
    ).then((text) => {
        reloadCatalogTree();
        window.alert(text);
    });
}

// Команда на обновление элемента
domFormControlUpdate.onclick = function () {
    if ((String)(domItemId.value) === (String)(domItemParent.value)) {
        window.alert('Нельзя переместить элемент на самого себя.');
        return;
    }
    restUpdate(
        domItemId.value,
        domItemName.value,
        domItemDescription.value,
        domItemParent.value,
    ).then((text) => {
        reloadCatalogTree();
        window.alert(text);
    });
}

// Команда на удаление элемента
domFormControlDelete.onclick = function () {
    restDelete(
        domItemId.value,
    ).then((text) => {
        reloadCatalogTree();
        window.alert(text);
    });
}

