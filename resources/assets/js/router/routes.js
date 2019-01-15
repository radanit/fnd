
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    { path: '/publicTable',name:'publicTable', component: require('../components/PublicTable.vue').default },
    { path: '/forms',name:'forms', component: require('../coreComponents/Form.vue').default },
    { path: '/formFields/:id',name:'formFields', component: require('../coreComponents/FormFields.vue').default },
    { path: '/preventiveService',name:'preventiveService', component: require('../components/PreventiveService.vue').default },
    { path: '/location',name:'location', component: require('../components/Locations.vue').default },
    { path: '/publicTableRecords/:id',name:'publicTableRecords', component: require('../components/PublicTableRecords.vue').default },
    { path: '/profile',name:'profile', component: require('../components/Profile.vue').default },
    { path: '/users',name:'users', component: require('../components/Users.vue').default },
    { path: '/userGroups',name:'userGroups', component: require('../components/UserGroups.vue').default },
    { path: '/pmActivities/:id',name:'pmActivities', component: require('../components/PmActivities.vue').default }
];

export default routes;