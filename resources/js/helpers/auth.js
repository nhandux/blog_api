export function login(credential) {
    return new Promise((res, reject) => {
        axios.post('/api/v1/auth/login', credential)
            .then(result => {
                res(result.data);
            })
            .catch(error => { 
                reject(error.response.data.status.msg.message);
            })
    })
}

export function currentUser() {
    const user = localStorage.getItem('user');

    if (!user) {
        return null;
    }

    return JSON.parse(user);
}