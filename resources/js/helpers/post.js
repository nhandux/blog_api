export function index(params) {
    return new Promise((res, reject) => {
        axios.get('/api/v1/posts', {params: params})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function postDelete(datas) {
    return new Promise((res, reject) => {
        axios.delete('/api/v1/posts', {params: {'ids': datas}})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function postCreate(dataForm) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/posts', dataForm)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function postUpdate(dataForm, id) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/posts/' + id, dataForm)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function detail(id) {
    return new Promise((res, reject) => {
        axios.get('/api/v1/posts/' + id) 
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}