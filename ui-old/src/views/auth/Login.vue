<template>
    <div class="col-md-4 ml-auto mr-auto">
<!--        <login-card></login-card>-->
    </div>
</template>
<script>
    import LoginCard from "./LoginCard";

    export default {
        name: 'login',
        components: { LoginCard },
        data() {
            return {}
        },
        methods: {},
        mounted() {},
        created() {},
    }
</script>
<style>
    .navbar-nav .nav-item p {
        line-height: inherit;
        margin-left: 5px;
    }
</style>
