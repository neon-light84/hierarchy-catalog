// Что бы в эксплорере и виндовом сафари, работало грамотное всплытие.
if (!HTMLElement.prototype.matches) {
    if (HTMLElement.prototype.webkitMatchesSelector)
    {
        HTMLElement.prototype.matches = HTMLElement.prototype.webkitMatchesSelector;
    }
    if (HTMLElement.prototype.msMatchesSelector) {
        HTMLElement.prototype.matches = HTMLElement.prototype.msMatchesSelector;
    }
}
if (!HTMLElement.prototype.closest) HTMLElement.prototype.closest = function (selector) {
    var elem = this;
    if (!elem || !(elem instanceof HTMLElement)) elem = null;
    while (elem && !elem.matches(selector)) {
        elem = elem.parentNode;
        if (elem == document) elem = null;
    }
    return elem;
}
// конец, Что бы в эксплорере и виндовом сафари, работало грамотное всплытие.


function generateDomHierarchy(dataArr, forAdmin) {
    var domElemUl = document.createElement('ul');
    var domElemLi, domElemSpan;
    for (var i = 0; i < dataArr.length; i++) {
        domElemLi = document.createElement('li');
        domElemSpan = document.createElement('span');
        domElemSpan.dataset.id = dataArr[i].self.id;
        domElemSpan.dataset.parent = dataArr[i].self.parent;
        domElemSpan.dataset.name = dataArr[i].self.name;
        domElemSpan.dataset.description = dataArr[i].self.description;
        domElemSpan.classList.add('collapsed');
        domElemSpan.classList.add('item-name');
        domElemSpan.innerHTML =
            '<span class="plus">+</span>' +
            '<span class="minus">-</span>' +
            '<span class="text">' + dataArr[i].self.name + '</span>' +
            (forAdmin ? '<span class="new-parent">New parent</span>' : '');
        domElemLi.appendChild(domElemSpan);
        if (dataArr[i].childs.length > 0) {
            domElemLi.appendChild(generateDomHierarchy(dataArr[i].childs));
        }
        domElemUl.appendChild(domElemLi);
    }
    return domElemUl;
}

// Грамотная реализация всплытия. С учетом вложенных элементов в тот элемент, на который вешаем событие.
function addListenerWithTarget(
    eventType, // тип собития. Напирмер 'click'
    mainElement, // HTMLElement, внутри которого отслеживаем событие.
    targetSelector, // CSS селектор, от куда должно быть всплытии (<div><a href=#>1111</a></div> указывать div, сработает, даже если всплытие началось с a)
    callBack // функция, что делать, при событии
    // isPreventDefault = true,  // В осле и виндовом сафари не работает значение по умолчанию ((((
) {
    mainElement.addEventListener(eventType, function (event) {
        /* if (isPreventDefault)*/ event.preventDefault();
        var elem = event.target.closest(targetSelector);
        if (!elem) return;
        if (!mainElement.contains(elem)) return;
        callBack(elem); // elem - хтмл-элемент, соответствующий селектору  targetSelector, и который попался на пути всплытия
    });
}
