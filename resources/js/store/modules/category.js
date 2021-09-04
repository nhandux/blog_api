
export default {
    state: {
        categoryList: {
            last_page: 0,
            total: 0,
            data: []
        },
        category: {
            parent_id: 0
        },
        loading: false
    },
    getters: {
        IS_LOADING_CATEGORY: state => {
            return state.loading;
        },
        CATEGORY_LIST: state => {
            return state.categoryList;
        },
        CATEGORY: state => {
            return state.category;
        }
    },
    mutations: {
        LOAD_CATEGORY: state => {
            state.loading = true;
        },
        CATEGORY_LIST: (state, payload) => {
            state.loading = false;
            state.categoryList = payload;
        },
        LOAD_CATEGORY_FAIL: (state) => {
            state.loading = false;
        },
        CATEGORY_DETAIL: (state, payload) => {
            state.category = payload.data;
        }
    }
}
