<template>
    <div class="app_component">
        <app-aside></app-aside>
        <div class="c-wrapper c-fixed-components">
            <app-header v-if="route_name != 'Login'"></app-header>
            <app-breadcrumb v-if="route_name != 'Login'"></app-breadcrumb>
            <div class="c-body">
                <main class="c-main">
                    <nprogress-container></nprogress-container>
                    <router-view></router-view>
                </main>
                <app-footer v-if="route_name != 'Login'"></app-footer>
            </div>
        </div>
    </div>
</template>

<script>
import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
import AppHeader from "./components/partials/Header";
import AppAside from "./components/partials/Aside";
import AppFooter from "./components/partials/Footer";
import AppBreadcrumb from "./components/partials/Breadcrumb.vue";

export default {
    name: "App",
    components: {
        AppHeader,
        AppAside,
        AppFooter,
        AppBreadcrumb,
        NprogressContainer
    },
    computed: {
        route_name() {
            return this.$route.name;
        }
    }
}
</script>
