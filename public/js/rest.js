// Тут не должно быть работы с DOM.

var endPointCrud = 'http://ierarchi.local.su/rest/admin.php';

function restCreate(parent, name, description) {
    return fetch(
        endPointCrud + `?resource=catalog&parent=${parent}&name=${name}&description=${description}&token=${token}`,
        {method: 'POST'}
    )
        .then((response)=>{
            return response.text();
        })
        .then((data)=>{
            return data;
        })
        .catch((err)=>{
            console.warn("Вот такая ошибка: ", err);
        });
}

function restReadAll() {
    return fetch(
        endPointCrud + `?resource=catalog&token=${token}`,
        {method: 'GET'}
    )
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

function restUpdate(id, name, description, parent) {
    return fetch(
        endPointCrud + `?resource=catalog&id=${id}&parent=${parent}&name=${name}&description=${description}&token=${token}`,
        {method: 'PUT'}
    )
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

function restDelete(id) {
    return fetch(
        endPointCrud + `?resource=catalog&id=${id}&token=${token}`,
        {method: 'DELETE'}
    )
        .then((response)=>{
            return response.text();
        })
        .then((data)=>{
            return data;
        })
        .catch((err)=>{
            console.warn("Вот такая ошибка: ", err);
        });
}

function restMove(id, newParent) {
    fetch(
        endPointCrud + `?resource=catalog&id=${id}&new-parent=${newParent}&token=${token}`,
        {method: 'PATCH'}
    )
        .then((response)=>{
            return response.text();
        })
        .then((data)=>{
            return data;
        })
        .catch((err)=>{
            console.warn("Вот такая ошибка: ", err);
        });
}
