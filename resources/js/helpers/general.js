export function initialize(store, router) {
    
    router.beforeEach((to, from, next) => {
        // const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.Auth.currentUser;
        if (to.name !== 'Login' && !currentUser) {  
            next({ name: 'Login' });
        } else if (to.path === '/login' && currentUser) {
            next({ name: 'Dashboard' });
        } else {
            next();
        }
    });
   
    axios_check_authentication(store)
}

export function axios_check_authentication(store) {
    axios.interceptors.response.use(null, (error) => {
        if(error.response.status === 401) {
            store.commit('LOGOUT');
            router.push('/login');
        }

        return Promise.reject(error);
    });
    
    if (store.getters.CURRENT_USER) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${store.getters.CURRENT_USER.token}`;
    }
}