<template>
    <AppHeaderDropdown right no-caret class="ml-2" v-if="isLoggedIn">
        <template slot="header">
            Welcome, {{ authUser.name }}
            <img
                src="img/avatars/6.jpg"
                class="img-avatar"
                :alt="authUser.email"/>
        </template>
        <template slot="dropdown">
            <template>
                <b-dropdown-item @click="onLogout"><i class="fa fa-lock"/> Logout</b-dropdown-item>
            </template>
        </template>
    </AppHeaderDropdown>
</template>

<script>
    import {HeaderDropdown as AppHeaderDropdown} from '@coreui/vue'
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: 'DefaultHeaderDropdownAccnt',
        components: {
            AppHeaderDropdown
        },
        data: () => {
            return {itemsCount: 42}
        },
        computed: {
            ...mapGetters([
                'isLoggedIn',
                'authUser',
            ]),
        },
        mounted() {
          // console.log(this.isLoggedIn);
        },
        methods: {
            /*...mapGetters([
            ]),*/
            ...mapActions([
                'unauthenticated',
            ]),
            onLogout() {
                let that = this;

                this.logout();
            },
            logout() {
                this.unauthenticated();

                this.$router.push('/login');
            },
        }
    }
</script>
