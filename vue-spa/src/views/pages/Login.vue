<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="8">
                    <b-card-group>
                        <b-card no-body class="p-4">
                            <b-card-body>
                                <b-form>
                                    <h1>Login</h1>
                                    <p class="text-muted">Sign In to your account</p>
                                    <b-input-group class="mb-3">
                                        <b-input-group-prepend>
                                            <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                                        </b-input-group-prepend>
                                        <b-form-input type="text" name="email" class="form-control" placeholder="Email"
                                                      autocomplete="username email"
                                                      v-model="form.email"
                                                      :class="{'is-invalid': errors.has('email') }"
                                                      v-validate="{required: true}"/>
                                        <div class="invalid-feedback">
                                            {{ errors.first('email') }}
                                        </div>
                                    </b-input-group>
                                    <b-input-group class="mb-4">
                                        <b-input-group-prepend>
                                            <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                                        </b-input-group-prepend>
                                        <b-form-input type="password" name="password" class="form-control" placeholder="Password"
                                                      v-model="form.password"
                                                      autocomplete="current-password"
                                                      :class="{'is-invalid': errors.has('password') }"
                                                      v-validate="{required: false}"/>
                                        <div class="invalid-feedback">
                                            {{ errors.first('password') }}
                                        </div>
                                    </b-input-group>
                                    <b-row>
                                        <b-col cols="6">
                                        </b-col>
                                        <b-col cols="6" class="text-right">
                                            <vue-ladda :loading="isLoginSubmitting"
                                                       class="btn btn-primary text-center-- float-right--"
                                                       @click="onLogin">Login</vue-ladda>
                                            <!--<b-button variant="link" class="px-0">Forgot password?</b-button>-->
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </b-card-body>
                        </b-card>
                        <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <b-card-body class="text-center">
                                <div>
                                    <h2>Sign up</h2>
                                    <p>We see our role in building the capacity of the community to respond to people’s mental health needs as vital to our vision and mission.</p>
                                    <b-button variant="primary" class="active mt-3" @click="$router.push('/register')">Register Now!</b-button>
                                </div>
                            </b-card-body>
                        </b-card>
                    </b-card-group>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: 'Login',
        data: () => {
            return {
                form: {
                    email: '',
                    password: '',
                },
                isLoginSubmitting: false,
            }
        },
        mounted () {
        },
        components: {},
        methods: {
            ...mapGetters([
                'isLoggedIn',
            ]),
            ...mapActions([
                'authenticated',
            ]),
            onLogin() {
                this.$validator.validate().then(isValid => {
                    if (!isValid) {
                        return;
                    }
                    this.login();
                });
            },
            async login() {
                let that = this;

                that.isLoginSubmitting = true;

                axios.post('/auth/login', this.form)
                    .then(result => {
                        console.dir(result.data);
                        // let config = JSON.parse(result.data.data[0].config);

                        // localStorage.setItem('token', result.data.data.token);

                        this.authenticated(result.data.data);

                        this.$toastr.success('Login Successful.', '', {
                            "positionClass": "toast-top-center",
                            "timeOut": "3000",
                        });

                        // redirect to detail page
                        // window.location = `/dashboard`;
                        this.$router.push('/dashboard');

                        that.isLoginSubmitting = false;

                    }).catch(err => {
                        console.dir(err);
                        // return;

                        this.$setApiValidationErrorsFromResponse(err.response.data);
                        // console.dir(this.$validator.errors);

                        localStorage.removeItem('token'); // if the request fails, remove any possible user token if possible

                        this.$toastr.error(err.response.data.error.message, '', {
                            "positionClass": "toast-top-center",
                            "timeOut": "3000",
                        });

                        that.isLoginSubmitting = false;
                    });
            },
        }
    }
</script>
