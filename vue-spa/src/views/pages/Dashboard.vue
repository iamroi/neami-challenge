<template>
    <div class="animated fadeIn" v-if="isPermissionsLoaded">
        <b-row v-if="isUserCan()('manage-users')">
            <b-col sm="6" lg="3">
                <b-card no-body class="bg-primary">
                    <b-card-body class="pb-0">
                        <vue-element-loading :active="dashboardCountsLoading" spinner="bar-fade-scale" background-color="rgba(255, 255, 255, .3)" color="#FF6700"/>
                        <!--<b-dropdown class="float-right" variant="transparent p-0" right>-->
                            <!--<template slot="button-content">-->
                                <!--<i class="icon-settings"></i>-->
                            <!--</template>-->
                            <!--<b-dropdown-item>Manage Products</b-dropdown-item>-->
                        <!--</b-dropdown>-->
                        <h4 class="mb-0">{{ usersCount }}</h4>
                        <p>Users</p>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>

        <b-row v-if="!isUserCan()('manage-users')">
            <b-col >
                <b-card
                    title="Get support"
                    img-src="https://picsum.photos/600/300/"
                    img-alt="Get support"
                    img-top
                    tag="article"
                    style="max-width: 20rem;"
                    class="mb-2"
                >
                    <div>
                        Find the right support to improve your mental health and wellbeing.
                    </div>

<!--                    <b-button href="#" variant="primary">Go somewhere</b-button>-->
                </b-card>
            </b-col>

            <b-col >
                <b-card
                    title="Recognising diversity"
                    img-src="https://picsum.photos/600/300/?2"
                    img-alt="Recognising diversity"
                    img-top
                    tag="article"
                    style="max-width: 20rem;"
                    class="mb-2"
                >
                    <div>
                        Our services are flexible to support diverse needs and experiences.
                    </div>
                </b-card>
            </b-col>

            <b-col >
                <b-card
                    title="Building capacity"
                    img-src="https://picsum.photos/600/300/?3"
                    img-alt="Training and building capacity"
                    img-top
                    tag="article"
                    style="max-width: 20rem;"
                    class="mb-2"
                >
                    <div>
                        We support individuals and organisations to increase their mental health </div>
                </b-card>

            </b-col>

        </b-row>

    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex'

    export default {
        name: 'dashboard',
        components: {},
        data: function () {
            return {
                usersCount: '-',
                dashboardCountsLoading: false,
            }
        },
        computed: {
            ...mapGetters([
                'isPermissionsLoaded',
            ]),
        },
        created () {
            // this.$store.dispatch('getUsers')
            this.getPermissions();
        },
        mounted () {
            this.getDashboardCounts();
        },
        methods: {
            ...mapGetters([
                'isUserCan',
                // 'isPermissionsLoaded',
            ]),
            ...mapActions([
                'getPermissions',
            ]),
            getDashboardCounts() {
                let that = this;

                this.dashboardCountsLoading = true;
                axios.get('/dashboard')
                    .then(result => {
                        // console.dir(result);
                        that.usersCount = result.data.data.usersCount;
                        this.dashboardCountsLoading = false;
                    }).catch(err => {
                        this.dashboardCountsLoading = false;
                    });
            },
            /*flag(value) {
                return 'flag-icon flag-icon-' + value
            }*/
        }
    }
</script>

<style>
    /* IE fix */
    #card-chart-01, #card-chart-02 {
        width: 100% !important;
    }
</style>
