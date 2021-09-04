export function index(params) {
    return new Promise((res, reject) => {
        axios.get('/api/v1/questions', {params: params})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function questionDelete(datas) {
    return new Promise((res, reject) => {
        axios.delete('/api/v1/questions', {params: {'ids': datas}})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function questionCreate(dataForm) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/questions', dataForm)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function questionUpdate(dataForm, id) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/questions/' + id, dataForm)
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
        axios.get('/api/v1/questions/' + id) 
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}