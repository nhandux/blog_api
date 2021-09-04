<template>
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">{{name_page}}</li>
        </ol>
    </div>  
</template>

<script>
    export default {
        name: "AppBreadcrumb",
        computed: {
            name_page() {
                return this.$route.name;
            },
        }
    };
</script>
