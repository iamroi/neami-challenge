import Vue from 'vue'
import Router from 'vue-router'


// TODO PROTECT THE ROUTES FROM DIRECT ACCESS WITHOUT PERMISSION


// Containers
const DefaultContainer = () => import('@/containers/DefaultContainer')
const HomeContainer = () => import('@/containers/HomeContainer')

// Views - Pages
const Login = () => import('@/views/pages/Login')
const Register = () => import('@/views/pages/Register')
const Home = () => import('@/views/pages/Home')
const Dashboard = () => import('@/views/pages/Dashboard')
const Users = () => import('@/views/pages/Users')
const Page404 = () => import('@/views/pages/Page404')
const Page500 = () => import('@/views/pages/Page500')

// Views
// const CoreDashboard = () => import('@/views/Dashboard')

Vue.use(Router)

export default new Router({
    mode: 'history', // https://router.vuejs.org/api/#mode
    linkActiveClass: 'open active',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            // name: 'Login',
            component: HomeContainer,
            children: [
                {
                    path: '/home',
                    name: 'Home',
                    component: Home,
                    meta: {
                    }
                },
                {
                    path: 'login',
                    name: 'Login',
                    component: Login,
                    meta: {
                        forGuests: true,
                    }
                },
                {
                    path: 'register',
                    name: 'Register',
                    component: Register,
                    meta: {
                        forGuests: true,
                    }
                },
                {
                    path: '404',
                    name: 'Page404',
                    component: Page404
                },
                {
                    path: '500',
                    name: 'Page500',
                    component: Page500
                },
            ]
        },
        {
            path: '/',
            redirect: '/dashboard',
            name: 'Home',
            component: DefaultContainer,
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: Dashboard,
                    meta: {
                        requiresAuth: true,
                    }
                },
                {
                    path: 'users',
                    name: 'Users',
                    component: Users,
                    meta: {
                        requiresAuth: true,
                        permission: 'manage-users'
                    }
                },
                // {
                //     path: 'core-dashboard',
                //     name: 'CoreDashboard',
                //     component: CoreDashboard
                // },
            ]
        },
    ]
})
