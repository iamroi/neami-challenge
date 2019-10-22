<template>
    <div class="app">
        <AppHeader fixed>
            <b-link class="navbar-brand" to="/">
                Neami Challenge
            </b-link>

            <b-navbar-nav class="d-md-down-none">
                <b-nav-item class="px-3" to="/home">Home</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="d-md-down-none" v-if="isLoggedIn()">
                <b-nav-item class="px-3" to="/dashboard">Dashboard</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto mr-5">

                <b-nav-item class="d-md-down-none px-3" @click="$router.push('/login')" v-if="!isLoggedIn()">
                    <i class="icon-login"></i>
                    Login
                </b-nav-item>

                <DefaultHeaderDropdownAccnt/>
            </b-navbar-nav>
        </AppHeader>

        <div class="app-body">
            <main class="main">
                <!--<Breadcrumb :list="list"/>-->
                <div class="container-fluid--">
                    <router-view></router-view>
                </div>
            </main>
        </div>
        <TheFooter>
            <!--footer-->
            <div>
                <a href="http://iamraja.com">Raja Munisamy</a>
                <span class="ml-1">&copy; 2018</span>
            </div>
            <div class="ml-auto">
                <span class="mr-1">Powered by</span>
                <a href="https://coreui.io">CoreUI for Vue</a>
            </div>
        </TheFooter>
    </div>
</template>

<script>
    import nav from '@/_nav'
    import {
        Header as AppHeader,
        Footer as TheFooter,
    } from '@coreui/vue'
    // import DefaultAside from './DefaultAside'
    import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'DefaultContainer',
        components: {
            AppHeader,
            // SidebarToggler,
            // AppSidebar,
            TheFooter,
            // DefaultAside,
            DefaultHeaderDropdownAccnt,
        },
        data() {
            return {
                nav: nav.items
            }
        },
        created () {
            if(this.isLoggedIn()) {
                this.getPermissions();
            }
        },
        mounted() {
            // todo refer coreUI documentation and fix this sidebar issue properly
            document.body.classList.remove("sidebar-lg-show");
        },
        computed: {
            ...mapGetters([
                'isPermissionsLoaded',
            ]),
            name() {
                return this.$route.name
            },
            list() {
                return this.$route.matched.filter((route) => route.name || route.meta.label)
            }
        },
        methods: {
            ...mapGetters([
                'isLoggedIn',
                'isUserCan',
            ]),
            ...mapActions([
                'getPermissions',
            ]),
        }
    }
</script>
