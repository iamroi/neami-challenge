export default {
    items: [
        {
            name: 'Dashboard',
            url: '/dashboard',
            icon: 'icon-speedometer',
            // badge: {
            //     variant: 'primary',
            //     text: 'NEW'
            // }
            meta: {
                requiredPermission: ''
            }
        },
        {
            name: 'Users',
            url: '/users',
            icon: 'icon-user',
            meta: {
                requiredPermission: 'manage-users'
            }
        },
    ]
}
