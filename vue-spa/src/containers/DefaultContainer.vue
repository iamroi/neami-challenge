<template>
    <div class="app">
        <AppHeader fixed>
            <SidebarToggler class="d-lg-none" display="md" mobile/>
            <b-link class="navbar-brand" to="/">
                Neami Challenge
            </b-link>
            <SidebarToggler class="d-md-down-none" display="lg"/>

            <b-navbar-nav class="d-md-down-none">
                <b-nav-item class="px-3" to="/home">Home</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto">
                <DefaultHeaderDropdownAccnt/>
            </b-navbar-nav>
        </AppHeader>

        <div class="app-body">
            <AppSidebar fixed>
                <SidebarHeader/>
                <SidebarForm/>
                <SidebarNav :navItems="nav" v-if="isPermissionsLoaded"></SidebarNav>
                <SidebarFooter/>
                <SidebarMinimizer/>
            </AppSidebar>
            <main class="main">
                <Breadcrumb :list="list"/>
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </main>

            <!--<AppAside fixed>-->
            <!--&lt;!&ndash;aside&ndash;&gt;-->
            <!--<DefaultAside/>-->
            <!--</AppAside>-->
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
        SidebarToggler,
        Sidebar as AppSidebar,
        SidebarFooter,
        SidebarForm,
        SidebarHeader,
        SidebarMinimizer,
        SidebarNav,
        Aside as AppAside,
        AsideToggler,
        Footer as TheFooter,
        Breadcrumb
    } from '@coreui/vue'
    import DefaultAside from './DefaultAside'
    import DefaultHeaderDropdownAccnt from './DefaultHeaderDropdownAccnt'
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'DefaultContainer',
        components: {
            AsideToggler,
            AppHeader,
            AppSidebar,
            AppAside,
            TheFooter,
            Breadcrumb,
            DefaultAside,
            DefaultHeaderDropdownAccnt,
            SidebarForm,
            SidebarFooter,
            SidebarToggler,
            SidebarHeader,
            SidebarNav,
            SidebarMinimizer
        },
        data() {
            return {
                // nav: nav.items
            }
        },
        created () {
            if(this.isLoggedIn()) {
                this.getPermissions();
            }
        },
        computed: {
            ...mapGetters([
                'isPermissionsLoaded',
                'authUser',
            ]),
            nav() {
                let navItems = nav.items.filter(item => {
                    if(item.meta && item.meta.requiredPermission) {
                        if(this.isUserCan()(item.meta.requiredPermission)) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                    return true;
                });
                return navItems;
                return nav.items
            },
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
