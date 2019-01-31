
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
	{ path: '/userRoles',name:'UserRoles', component: require('../components/user/UserRole.vue').default },
	{ path: '/createUserRoles',name:'CreateUserRoles', component: require('../components/user/CreateUserRole.vue').default },
	{ path: '/editUserRoles',name:'EditUserRoles', component: require('../components/user/EditUserRole.vue').default },	
	{ path: '/userPermissions',name:'UserPermissions', component: require('../components/user/UserPermission.vue').default },
	{ path: '/createUserPermissions',name:'CreateUserPermissions', component: require('../components/user/CreateUserPermission.vue').default },
	{ path: '/editUserPermissions',name:'EditUserPermissions', component: require('../components/user/EditUserPermission.vue').default },	
	/*End User Routes*/


    { path: '/profiles',name:'Profiles', component: require('../components/Profile.vue').default },
];

export default routes;
