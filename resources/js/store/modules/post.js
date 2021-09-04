export default {
    state: {
        postList: {
            last_page: 0,
            total: 0,
            data: []
        },
        post: {
            parent_id: 0
        },
        loading: false
    },
    getters: {
        IS_LOADING_POST: state => {
            return state.loading;
        },
        POST_LIST: state => {
            return state.postList;
        },
        POST: state => {
            return state.post;
        }
    },
    mutations: {
        LOAD_POST: state => {
            state.loading = true;
        },
        POST_LIST: (state, payload) => {
            state.loading = false;
            state.postList = payload;
        },
        LOAD_POST_FAIL: (state) => {
            state.loading = false;
        },
        POST_DETAIL: (state, payload) => {
            state.post = payload.data;
        }
    }
}