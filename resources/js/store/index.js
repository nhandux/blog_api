import Vue from 'vue';
import Vuex from 'vuex';
import Auth from './modules/auth';
import Category from './modules/category';
import Post from './modules/post';
import Question from './modules/question';
import Media from './modules/media';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Auth,
        Category,
        Post,
        Question,
        Media
    }
})