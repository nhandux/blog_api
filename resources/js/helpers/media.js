export function index(params) {
    return new Promise((res, reject) => {
        axios.get('/api/v1/medias', {params: params})
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function mediaDelete(id) {
    return new Promise((res, reject) => {
        axios.delete('/api/v1/medias/'+ id)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}

export function mediaCreate(dataForm) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/medias', dataForm)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg);
            })
    })
}