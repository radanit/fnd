
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    //{ path: '/user_groups',name:'user_groups', component: require('../components/UserGroups.vue').default },
    //{ path: '/specialities',name:'doctor.specialities', component: require('../components/Specialities.vue').default },
	
	/*Begin Profile Routes*/
	{ path: '/profileStructures',name:'ProfileStructures', component: require('../components/profile/ProfileStructure.vue').default },
	{ path: '/createProfileStructures',name:'CreateProfileStructures', component: require('../components/profile/CreateProfileStructure.vue').default },
	{ path: '/editProfileStructures',name:'EditProfileStructures', component: require('../components/profile/EditProfileStructure.vue').default },
	/*End Profile Routes*/
	
	/*Begin User Profile Routes*/
	{ path: '/userProfiles',name:'UserProfiles', component: require('../components/userprofile/UserProfile.vue').default },
	{ path: '/createUserProfiles',name:'CreateUserProfiles', component: require('../components/userprofile/CreateUserProfile.vue').default },
	{ path: '/editUserProfiles',name:'EditUserProfiles', component: require('../components/userprofile/EditUserProfile.vue').default },
	/*End User Profile Routes*/
	
	/*Begin User Routes*/
	{ path: '/users',name:'Users', component: require('../components/user/User.vue').default },
	{ path: '/createUsers',name:'CreateUsers', component: require('../components/user/CreateUser.vue').default },
	{ path: '/editUsers',name:'EditUsers', component: require('../components/user/EditUser.vue').default },
	/*End User Routes*/


    { path: '/profiles',name:'Profiles', component: require('../components/Profile.vue').default },
];

export default routes;
