<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="6" sm="8">
                    <b-card no-body class="mx-4">
                        <b-card-body class="p-4">
                            <h1>Register</h1>
                            <p class="text-muted">Create your account</p>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend>
                                    <b-input-group-text><i class="icon-user"></i></b-input-group-text>
                                </b-input-group-prepend>
                                <b-form-input type="text" name="name" class="form-control" placeholder="Name"
                                              autocomplete="name"
                                              v-model="form.name"
                                              :class="{'is-invalid': errors.has('name') }"
                                              v-validate="{required: true}"/>
                                <div class="invalid-feedback">
                                    {{ errors.first('name') }}
                                </div>
                            </b-input-group>

                            <b-input-group class="mb-3">
                                <b-input-group-prepend>
                                    <b-input-group-text>@</b-input-group-text>
                                </b-input-group-prepend>
                                <b-form-input type="text" name="email" class="form-control" placeholder="Email"
                                              autocomplete="email"
                                              v-model="form.email"
                                              :class="{'is-invalid': errors.has('email') }"
                                              v-validate="{required: true}"/>
                                <div class="invalid-feedback">
                                    {{ errors.first('email') }}
                                </div>
                            </b-input-group>

                            <b-input-group class="mb-3">
                                <b-input-group-prepend>
                                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                                </b-input-group-prepend>
                                <b-form-input type="password" name="password" class="form-control" placeholder="Password"
                                              autocomplete="new-password"
                                              v-model="form.password"
                                              :class="{'is-invalid': errors.has('password') }"
                                              v-validate="{required: true}"/>
                                <div class="invalid-feedback">
                                    {{ errors.first('password') }}
                                </div>
                            </b-input-group>

                            <b-input-group class="mb-4">
                                <b-input-group-prepend>
                                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                                </b-input-group-prepend>
                                <b-form-input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password"
                                              autocomplete="new-password"
                                              v-model="form.password_confirmation"
                                              :class="{'is-invalid': errors.has('password_confirmation') }"
                                              v-validate="{required: true}"/>
                                <div class="invalid-feedback">
                                    {{ errors.first('password_confirmation') }}
                                </div>
                            </b-input-group>

                            <vue-ladda :loading="isRegistering"
                                       class="btn btn-success d-block text-center-- float-right--"
                                       @click="onRegister">Create Account</vue-ladda>
                            <!--<b-button variant="success" block>Create Account</b-button>-->
                        </b-card-body>
                        <!--<b-card-footer class="p-4">-->
                        <!--<b-row>-->
                        <!--<b-col cols="6">-->
                        <!--<b-button block class="btn btn-facebook"><span>facebook</span></b-button>-->
                        <!--</b-col>-->
                        <!--<b-col cols="6">-->
                        <!--<b-button block class="btn btn-twitter" type="button"><span>twitter</span></b-button>-->
                        <!--</b-col>-->
                        <!--</b-row>-->
                        <!--</b-card-footer>-->
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: 'Register',
        data: () => {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                isRegistering: false,
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
            onRegister() {
                this.$validator.validate().then(isValid => {
                    if (!isValid) {
                        return;
                    }
                    this.register();
                });
            },
            async register() {
                let that = this;

                that.isRegistering = true;

                axios.post('/auth/register', this.form)
                    .then(result => {
                        console.dir(result.data);
                        // let config = JSON.parse(result.data.data[0].config);

                        // this.authenticated(result.data.data);

                        this.$toastr.success('Register Successful.', '', {
                            "positionClass": "toast-top-center",
                            "timeOut": "3000",
                        });

                        // redirect to detail page
                        // window.location = `/dashboard`;
                        this.$router.push('/login');

                        that.isRegistering = false;

                    }).catch(err => {
                        console.dir(err);
                        // return;

                        this.$setApiValidationErrorsFromResponse(err.response.data);
                        // console.dir(this.$validator.errors);

                        if(err.response.data.error.message) {
                            this.$toastr.error(err.response.data.error.message, '', {
                                "positionClass": "toast-top-center",
                                "timeOut": "3000",
                            });
                        }

                        that.isRegistering = false;
                    });
            },
        }
    }
</script>
