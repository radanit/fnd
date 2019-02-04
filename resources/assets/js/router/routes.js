
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    //{ path: '/user_groups',name:'user_groups', component: require('../components/UserGroups.vue').default },
    //{ path: '/specialities',name:'doctor.specialities', component: require('../components/Specialities.vue').default },
	
	/*Begin Profile Routes*/
	{ path: '/profile_structures',name:'profile_structures', component: require('../components/profile/ProfileStructure.vue').default },
	{ path: '/create_profile_structures',name:'create_profile_structures', component: require('../components/profile/CreateProfileStructure.vue').default },
	{ path: '/edit_profile_structures',name:'edit_profile_structures', component: require('../components/profile/EditProfileStructure.vue').default },
	/*End Profile Routes*/
	
	/*Begin User Profile Routes*/
	{ path: '/user_profiles',name:'user_profiles', component: require('../components/userprofile/UserProfile.vue').default },
	{ path: '/create_user_profiles',name:'create_user_profiles', component: require('../components/userprofile/CreateUserProfile.vue').default },
	{ path: '/edit_user_Profiles',name:'edit_user_Profiles', component: require('../components/userprofile/EditUserProfile.vue').default },
	/*End User Profile Routes*/
	
	/*Begin User Routes*/
	{ path: '/users',name:'users', component: require('../components/user/User.vue').default },
	{ path: '/create_users',name:'create_users', component: require('../components/user/CreateUser.vue').default },
	{ path: '/edit_users',name:'edit_users', component: require('../components/user/EditUser.vue').default },
	/*End User Routes*/
	/*Begin Role Routes*/
	{ path: '/user_roles',name:'user_roles', component: require('../components/user/role/UserRole.vue').default },
	{ path: '/create_user_roles',name:'create_user_roles', component: require('../components/user/role/CreateUserRole.vue').default },
	{ path: '/edit_user_roles',name:'edit_user_roles', component: require('../components/user/role/EditUserRole.vue').default },	
	/*End Role Routes*/
	/*Begin Permission Routes*/
	{ path: '/user_permissions',name:'user_permissions', component: require('../components/user/permission/UserPermission.vue').default },
	{ path: '/create_user_permissions',name:'create_user_permissions', component: require('../components/user/permission/CreateUserPermission.vue').default },
	{ path: '/edit_user_permissions',name:'edit_user_permissions', component: require('../components/user/permission/EditUserPermission.vue').default },
	/*End Permission Routes*/



    { path: '/profiles',name:'Profiles', component: require('../components/userprofile/Profile.vue').default },
];

export default routes;
