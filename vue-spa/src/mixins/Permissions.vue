<script>
    export default {
        methods: {
            $can(permissionName) {
                // console.dir(this.$store.state)
                if(this.$store.state.auth.permissions === null) {
                    return false;
                }
                return this.$store.getters.isUserCan(permissionName);

                /*let hasAccess;
                axios.get(`/permission/${permissionName}`)
                  .then(()=> {
                    hasAccess = true;
                  })
                  .catch(()=> {
                    hasAccess = false;
                  });
                return hasAccess;*/
            },
        },
    };
</script>
