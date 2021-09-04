import Vue from 'vue';
import Router from 'vue-router';
import DashBoard from '../components/layouts/Dashboard';
import IndexCategory from '../components/layouts/category';
import FormCategory from '../components/layouts/category/form';
import IndexPost from '../components/layouts/post';
import FormPost from '../components/layouts/post/form';
import Setting from '../components/layouts/setting';
import IndexQuestion from '../components/layouts/question';
import FormQuestion from '../components/layouts/question/form';
import Contact from '../components/layouts/contact';
import Media from '../components/layouts/media';
import User from '../components/layouts/manager/user';
import Role from '../components/layouts/manager/role';
import Login from '../components/layouts/auth/Login';

Vue.use(Router)

export function createRouter () {
    return new Router({
        mode: 'history',
        routes: [
            { 
                path: '/', 
                name: 'DashBoard', 
                component: DashBoard 
            },
            {
                path: '/login',
                name: 'Login',
                component: Login
            },
            { 
                path: '/setting', 
                name: 'Setting', 
                component: Setting 
            },
            { 
                path: '/interview-question', 
                name: 'Question', 
                component: IndexQuestion 
            },
            { 
                path: '/interview-question/create', 
                name: 'FormQuestion', 
                component: FormQuestion 
            },
            { 
                path: '/interview-question/:id/detail', 
                name: 'UpdateQuestion', 
                component: FormQuestion 
            },
            { 
                path: '/category', 
                name: 'Category', 
                component: IndexCategory 
            },
            { 
                path: '/category/create', 
                name: 'FormCategory', 
                component: FormCategory 
            },
            { 
                path: '/category/:id/detail', 
                name: 'UpdateCategory', 
                component: FormCategory 
            },
            { 
                path: '/post', 
                name: 'Post', 
                component: IndexPost 
            },
            { 
                path: '/post/create', 
                name: 'FormPost', 
                component: FormPost 
            },
            { 
                path: '/post/:id/detail', 
                name: 'UpdatePost', 
                component: FormPost 
            },
            { 
                path: '/contact', 
                name: 'Contact', 
                component: Contact 
            },
            { 
                path: '/media', 
                name: 'Media', 
                component: Media 
            },
            { 
                path: '/manager/role', 
                name: 'Role', 
                component: Role 
            },
            { 
                path: '/menager/user', 
                name: 'User', 
                component: User 
            }
        ]
    })
}