export function clearCartAPI() {
    return fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'clear'
        })
    });
}

export function addProductAPI(id) {
    return fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'add',
            id: id
        })
    });
}

export function deleteProductAPI(id) {
    return fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'delete',
            id: id
        })
    });
}

export function buyAPI(name, email) {
    return fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'buy',
            name: name,
            email: email
        })
    });
}