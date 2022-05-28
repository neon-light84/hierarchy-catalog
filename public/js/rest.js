// Тут не должно быть работы с DOM.

var endPointCrud = 'http://ierarchi.local.su/rest/admin.php';

// По сути, обертка над фетчем
function restRequest (url, method) {
    return fetch(url, {method: method, credentials: 'include'})
        .then((response)=>{
            return response.text();
        })
        .then((data)=>{
            return data;
        })
        .catch((err)=>{
            return "Вот такая ошибка: " + err;
        });
}

function restCreate(name, description, parent) {
    return restRequest(
        endPointCrud + `?resource=catalog&parent=${parent}&name=${name}&description=${description}`,
        'POST'
    );
}

function restReadAll() {
    return restRequest(
        endPointCrud + `?resource=catalog`,
        'GET'
    );
}

function restUpdate(id, name, description, parent) {
    return restRequest(
        endPointCrud + `?resource=catalog&id=${id}&parent=${parent}&name=${name}&description=${description}`,
        'PUT'
    );
}

function restDelete(id) {
    return restRequest(
        endPointCrud + `?resource=catalog&id=${id}`,
        'DELETE'
    );
}
