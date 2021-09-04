export default {
    state: {
        mediaList: [],
        loading_upload: false,
        loading_list: true,
    },
    getters: {
        IS_LOADING_MEDIA_UPLOAD: state => {
            return state.loading_upload;
        },
        IS_LOADING_MEDIA: state => {
            return state.loading_list;
        },
        MEDIA_LIST: state => {
            return state.mediaList;
        }
    },
    mutations: {
        LOAD_MEDIA_UPLOAD: state => {
            state.loading_upload = true;
        },
        LOAD_MEDIA: state => {
            state.loading_list = true;
        },
        RESET_DATA_MEDIA: state => {
            state.mediaList = [];
        },
        MEDIA_LIST: (state, payload) => {
            state.loading_list = false;
            state.loading_upload = false;
            state.mediaList = payload;
        },
        LOAD_MEDIA_UPLOAD_FAIL: (state) => {
            state.loading_upload = false;
        },
        LOAD_MEDIA_FAIL: (state) => {
            state.loading_list = false;
        }
    }
}