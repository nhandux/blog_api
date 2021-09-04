export function index(params) {
    return new Promise((res, reject) => {
        axios.get('/api/v1/categories', {params: params})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function categoryDelete(datas) {
    return new Promise((res, reject) => {
        axios.delete('/api/v1/categories', {params: {'ids': datas}})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function categoryCreate(dataForm) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/categories', dataForm)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function categoryUpdate(dataForm, id) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/categories/' + id, dataForm)
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
        axios.get('/api/v1/categories/' + id) 
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}