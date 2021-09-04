export default {
    state: {
        questionList: {
            last_page: 0,
            total: 0,
            data: []
        },
        question: {
            parent_id: 0
        },
        loading: false
    },
    getters: {
        IS_LOADING_QUESTION: state => {
            return state.loading;
        },
        QUESTION_LIST: state => {
            return state.questionList;
        },
        QUESTION: state => {
            return state.question;
        }
    },
    mutations: {
        LOAD_QUESTION: state => {
            state.loading = true;
        },
        QUESTION_LIST: (state, payload) => {
            state.loading = false;
            state.questionList = payload;
        },
        LOAD_QUESTION_FAIL: (state) => {
            state.loading = false;
        },
        QUESTION_DETAIL: (state, payload) => {
            state.question = payload.data;
        }
    }
}