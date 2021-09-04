<template>
    <div class="col-md-4 offset-md-4 pt-100 fade-in div-login">
        <div class="card w-100">
            <div class="card-header">
                <h4 class="mb-0">Login</h4>
            </div>
            <article class="card-body">
                <form @submit.prevent="authenticate">
                    <div class="form-group">
                        <input name="" class="form-control" value="nhanduc96@gmail.com" placeholder="Email or login" type="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" password="password" placeholder="******" type="password" v-model="form.password">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button :disabled="loading === true" type="submit" class="btn btn-primary mw-100" > Login  </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="small" href="#">Forgot password?</a>
                        </div>
                    </div>
                </form>
            </article>
        </div>
    </div>
</template>

<script>
    import { login } from '../../../helpers/auth';
    import { axios_check_authentication } from '../../../helpers/general';

    export default {
        name: 'Login',
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
                type: 'login',
                error: null,
            }
        },
        methods: {
            async authenticate() {
                this.$store.dispatch("LOGIN");
                await this.$helpers.default.sleep(1000);
                
                login(this.$data.form)
                    .then(res => {
                        this.$store.commit("LOGIN_SUCCESS", res);
                        axios_check_authentication(this.$store);
                        this.$router.push({path: '/'});
                    })
                    .catch(error => {
                        this.$store.commit("LOGIN_FAILED", {error});
                        this.$toast.error(error);
                    })
            },
        },
        computed: {
            loading() {
                return this.$store.getters.IS_LOADING;
            }
        }
    }
</script>