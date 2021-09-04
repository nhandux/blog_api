<template>
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
            <i class="cil-menu c-sidebar-nav-icon"></i>
        </button>
        <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>
        </ul>
        <ul class="c-header-nav ml-auto">
            <i class="cil-bell font-bell c-sidebar-nav-icon"></i>
            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                <img class="c-avatar-img" src="https://ui-avatars.com/api/?name=관리자" alt="user@email.com">
                </div>
            </span> 
            <span class="name--page-login">admin</span>
            <span class="name--page-logout" @click="logOut">Logout</span>
        </ul>
        
    </header>
</template>

<script>
    export default {
        name: "AppHeader",
        methods: {
            logOut() {
                this.$store.commit('LOGOUT');
                this.$router.push('/login');
            }
        }
    };
</script>
