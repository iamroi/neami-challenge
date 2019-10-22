<template>
    <div class="animated fadeIn">

        <b-row>
            <b-col sm="12">
                <b-card header="Users">
                    <vue-element-loading :active="isUsersLoading" spinner="bar-fade-scale" background-color="rgba(255, 255, 255, .3)" color="#FF6700"/>
                    <b-table :dark="false" :hover="false" :striped="true" :bordered="false" :small="false" :fixed="false" responsive="sm" :items="loadUsers" :fields="fields" :current-page="currentPage" :per-page="perPage">
                        <template slot="name" slot-scope="data">
                            {{ data.item.name }}
                        </template>

                        <template slot="role" slot-scope="data">
                            <b-badge variant="info" v-for="role in data.item.roles">
                                {{ role.name }}
                            </b-badge>
                            <template v-if="data.item.roles.length === 0">
                                N/A
                            </template>
                        </template>
                    </b-table>
                    <nav>
                        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" prev-text="Prev" next-text="Next" hide-goto-end-buttons/>
                    </nav>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import User from '@/models/User'
    // import cTable from '@/views/base/Table.vue'

    export default {
        name: 'users',
        data: () => {
            return {
                users: [],
                currentPage: 1,
                perPage: 8,
                totalRows: 0,
                fields: [
                    {key: 'name', label: 'Name', sortable: false},
                    {key: 'email'},
                    {key: 'role'},
                    // {key: 'price', label: 'Cost', class: 'text-center'},
                ],
                isUsersLoading: false,
            }
        },
        mounted () {
            // console.log('weg');
            // this.loadUsers();
        },
        components: {},
        methods: {
            loadUsers(paginationCtx) {
                // console.dir(paginationCtx);
                let that = this;
                this.isUsersLoading = true;

                return User
                        // let promise = axios.get('/users');
                        // .where('type', destinationType)
                        .page(paginationCtx.currentPage)
                        .limit(paginationCtx.perPage)
                        .get()
                        // let result = axios.get('/users')
                        .then(result => {
                            // console.dir(result);
                            that.users = result.data;
                            // Vue.set(this.users, users.data);

                            that.totalRows = result.pagination.total;

                            this.isUsersLoading = false;

                            return result.data || []
                        }).catch(err => {
                            console.dir(err);

                            this.$toastr.error(err.response.data.error.message, '', {
                                "positionClass": "toast-top-center",
                                "timeOut": "3000",
                            });

                            this.isUsersLoading = false;

                            return [];
                        });
            },
        }
    }
</script>
