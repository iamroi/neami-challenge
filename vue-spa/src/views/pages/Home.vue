<template>
    <div class="app">
        <div class="">
            <b-row class="home-banner-row">
                <b-col sm="12" class="home-banner">
                </b-col>
            </b-row>
        </div>

        <div class="container">
            <b-row class="message-section mt-5">
                <b-col sm="12" class="">
                    <b-card
                        title="Support for you"
                        img-src="https://picsum.photos/600/300/?image=25"
                        img-alt="Image"
                        img-top
                        tag="article"
                        style="max-width: 20rem;"
                        class="mb-2"
                    >
                        <div>
<!--                            <h1 class="d-block"></h1>-->
                            <h6>We support people who have:</h6>
                            <ul>
                                <li>Never accessed mental health support</li>
                                <li>Been receiving mental health support for a while</li>
                                <li>Ongoing and intensive support needs</li>
                                <li>Recently been to hospital (or acute care)</li>
                            </ul>
                        </div>

                        <b-button href="#" variant="primary">Go somewhere</b-button>
                    </b-card>

                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex'

    export default {
        name: 'Home',
        data: () => {
            return {
            }
        },
        computed: {
        },
        created() {
            // this.$store.dispatch('getUsers')
        },
        mounted() {
            // console.log('weg');
        },
        components: {},
        methods: {
            ...mapGetters([
                'isLoggedIn',
            ]),
            ...mapActions([
            ]),
        }
    }
</script>
