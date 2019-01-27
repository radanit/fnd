
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    //{ path: '/user_groups',name:'user_groups', component: require('../components/UserGroups.vue').default },
    //{ path: '/specialities',name:'doctor.specialities', component: require('../components/Specialities.vue').default },
	{ path: '/profileStructure',name:'ProfileStructure', component: require('../components/profile/ProfileStructure.vue').default },
	{ path: '/createProfileStructure',name:'CreateProfileStructure', component: require('../components/profile/CreateProfileStructure.vue').default },
	{ path: '/editProfileStructure',name:'EditProfileStructure', component: require('../components/profile/EditProfileStructure.vue').default },



    { path: '/profile',name:'profile', component: require('../components/Profile.vue').default },
];

export default routes;
