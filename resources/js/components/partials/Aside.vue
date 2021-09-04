<template>
    <div v-if="route_name != 'Login'" class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <span class="c-sidebar-brand-full">KENNER_IT</span>
            <span class="c-sidebar-brand-minimized">KN</span>
        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <router-link :to="{ name: 'DashBoard' }" class="c-sidebar-nav-link" @click="activeMenu('')">
                    <i class="cil-chart c-sidebar-nav-icon"></i>
                    Dashboard
                </router-link>
            </li>
            <li class="c-sidebar-nav-title">Components</li>
            <li :class="[active == 'category' && 'c-show', 'c-sidebar-nav-item c-sidebar-nav-dropdown']" >
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#" @click="activeMenu('category')">
                    <i class="cil-devices c-sidebar-nav-icon" ></i> Category
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'Category' }" class="c-sidebar-nav-link"><span class="c-sidebar-nav-icon"></span> List</router-link>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'FormCategory' }" class="c-sidebar-nav-link"><span class="c-sidebar-nav-icon"></span> Register</router-link>
                    </li>
                </ul>
            </li>
            <li :class="[active == 'post' && 'c-show', 'c-sidebar-nav-item c-sidebar-nav-dropdown']" >
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#" @click="activeMenu('post')">
                    <i class="cil-clipboard c-sidebar-nav-icon" ></i> Post
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'Post' }" class="c-sidebar-nav-link" ><span class="c-sidebar-nav-icon"></span> List</router-link>

                    </li>
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'FormPost' }" class="c-sidebar-nav-link"><span class="c-sidebar-nav-icon"></span> Register</router-link>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item">
                <router-link :to="{ name: 'Question' }" class="c-sidebar-nav-link">
                    <i class="cil-comment-square c-sidebar-nav-icon"></i>
                    Interview questions
                </router-link>
            </li>
            <li class="c-sidebar-nav-item">
                <router-link :to="{ name: 'Media' }" class="c-sidebar-nav-link">
                    <i class="cil-satelite c-sidebar-nav-icon"></i>
                    Media
                </router-link>
            </li>
            <li class="c-sidebar-nav-item">
                <router-link :to="{ name: 'Contact' }" class="c-sidebar-nav-link">
                    <i class="cil-contact c-sidebar-nav-icon"></i>
                    Contact
                </router-link>
            </li>
            <li :class="[active == 'manager' && 'c-show', 'c-sidebar-nav-item c-sidebar-nav-dropdown']" >
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#" @click="activeMenu('manager')">
                    <i class="cil-address-book c-sidebar-nav-icon" ></i> Manager
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'Role' }" class="c-sidebar-nav-link"><span class="c-sidebar-nav-icon"></span> Roles</router-link>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <router-link :to="{ name: 'User' }" class="c-sidebar-nav-link"><span class="c-sidebar-nav-icon"></span> Users</router-link>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item">
                <router-link :to="{ name: 'Setting' }" class="c-sidebar-nav-link">
                    <i class="cil-settings c-sidebar-nav-icon"></i>
                    Setting
                </router-link>
            </li>
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
</template>

<script>
    export default {
        name: "AppAside",
        data() {
            let path  = this.$route.path.split('/');
            return {
                
                active: path.length > 1 ? path[1] : '',
            }
        },
        methods: {
            activeMenu (active) {
                if(active != this.active) {
                    this.active = active;
                } else {
                    this.active = '';
                }
            }
        },
        computed: {
            route_name() {
                return this.$route.name;
            }
        }
    };
</script>
