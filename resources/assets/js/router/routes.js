
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    { path: '/userGroups',name:'userGroups', component: require('../components/UserGroups.vue').default },
];

export default routes;
