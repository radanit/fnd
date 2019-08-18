
const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    { path: '/dashboard',name:'dashboard', component: require('../components/Dashboard.vue').default },
    { path: '/landing',name:'landing', component: require('../components/Landing.vue').default },
    //{ path: '/specialities',name:'doctor.specialities', component: require('../components/Specialities.vue').default },
	
	/*Begin Profile Routes*/
	{ path: '/profile_structures',name:'profile_structures', component: require('../components/profile/ProfileStructure.vue').default },
	{ path: '/create_profile_structures',name:'create_profile_structures', component: require('../components/profile/CreateProfileStructure.vue').default },
	{ path: '/edit_profile_structures',name:'edit_profile_structures', component: require('../components/profile/EditProfileStructure.vue').default },
	/*End Profile Routes*/

	/*Begin PasswordPolicy Routes*/
	{ path: '/password_policies',name:'password_policies', component: require('../components/password_policy/PasswordPolicy.vue').default },
	{ path: '/create_password_policies',name:'create_password_policies', component: require('../components/password_policy/CreatePasswordPolicy.vue').default },
	{ path: '/edit_password_policies',name:'edit_password_policies', component: require('../components/password_policy/EditPasswordPolicy.vue').default },
	/*End PasswordPolicy Routes*/
	
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
	/*Begin receptions Routes*/
	{ path: '/receptions',name:'receptions', component: require('../components/reception/Reception.vue').default },
	{ path: '/registered_receptions',name:'registered_receptions', component: require('../components/reception/registered/RegisteredReception.vue').default },
	{ path: '/captured_receptions',name:'captured_receptions', component: require('../components/reception/captured/CapturedReception.vue').default },
	{ path: '/compeleted_receptions',name:'compeleted_receptions', component: require('../components/reception/completed/CompletedReception.vue').default },
	{ path: '/view_completed_receptions',name:'view_completed_receptions', component: require('../components/reception/completed/ViewCompletedReception.vue').default },
	{ path: '/rejected_receptions',name:'rejected_receptions', component: require('../components/reception/rejected/RejectedReception.vue').default },
	{ path: '/create_receptions',name:'create_receptions', component: require('../components/reception/CreateReception.vue').default },
	{ path: '/edit_receptions',name:'edit_receptions', component: require('../components/reception/EditReception.vue').default },
	{ path: '/view_registered_receptions',name:'view_registered_receptions', component: require('../components/reception/registered/ViewRegisteredReception.vue').default },
	{ path: '/view_rejected_receptions',name:'view_rejected_receptions', component: require('../components/reception/rejected/ViewRejectedReception.vue').default },
	{ path: '/view_captured_reception',name:'view_captured_reception', component: require('../components/reception/captured/ViewCapturedReception.vue').default },
	/*End receptions Routes*/

	/*Begin RadioType Routes*/
	{ path: '/radio_types',name:'radio_types', component: require('../components/radio_type/RadioType.vue').default },
	{ path: '/create_radio_types',name:'create_radio_types', component: require('../components/radio_type/CreateRadioType.vue').default },
	{ path: '/edit_radio_types',name:'edit_radio_types', component: require('../components/radio_type/EditRadioType.vue').default },
	/*End RadioType Routes*/

	/*Begin Doctor Routes*/
	{ path: '/doctors',name:'doctors', component: require('../components/doctor/Doctor.vue').default },
	/*End Doctor Routes*/	
	
	/*Begin Speciality Routes*/
	{ path: '/specialities',name:'specialities', component: require('../components/speciality/Speciality.vue').default },
	{ path: '/create_specialities',name:'create_specialities', component: require('../components/speciality/CreateSpeciality.vue').default },
	{ path: '/edit_specialities',name:'edit_specialities', component: require('../components/speciality/EditSpeciality.vue').default },
	/*End Speciality Routes*/		

	{ path: '/profiles',name:'profiles', component: require('../components/user_profile/Profile.vue').default },
	{ path: '/chats',name:'chats', component: require('../components/chat/ChatMessage.vue').default },

	/* Begin Notify */
	{ path: '/all_notify',name:'all_notify', component: require('../components/notification/Notification.vue').default },
	/* End Notify */
];

export default routes;
