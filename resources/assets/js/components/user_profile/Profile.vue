<template>
	<div :dir="trans('app.dir')">
		<el-row :gutter="20">
			<el-col :span="24">
				<el-row v-if="trans('app.dir')==='rtl'" :gutter="20">
						<el-col :span="10"><div class="grid-content"></div></el-col>
						<el-col :span="10" class="text-right mt-4">
								<el-row :gutter="20">
									<el-col :span="24">{{trans('userProfile.fullname')}} : {{user.fullname}}</el-col>
								</el-row>
								<el-row :gutter="20">
									<el-col :span="24">{{trans('userProfile.email')}} : {{user.email}}</el-col>
								</el-row>
								<el-row :gutter="20">
									<el-col :span="24">{{trans('userProfile.roles')}} : {{user.roles}}</el-col>
								</el-row>																
						</el-col>
						<el-col :span="4" class="text-right">
							<img v-if="user.avatar" :src="user.avatar" class="profile-user-img img-fluid  el-icon-plus" alt="User profile picture">
					</el-col>
				</el-row>
				<!-- EN -->
				<el-row v-if="trans('app.dir')==='ltr'" :gutter="20">
						<el-col :span="4" class="text-left">
							<img v-if="user.avatar" :src="user.avatar" class="profile-user-img img-fluid  el-icon-plus" alt="User profile picture">
					</el-col>						
					<el-col :span="10" class="text-left mt-4">
							<el-row :gutter="20">
								<el-col :span="24">{{trans('userProfile.fullname')}} : {{user.fullname}}</el-col>
							</el-row>
							<el-row :gutter="20">
								<el-col :span="24">{{trans('userProfile.email')}} : {{user.email}}</el-col>
							</el-row>
							<el-row :gutter="20">
								<el-col :span="24">{{trans('userProfile.roles')}} : {{user.roles}}</el-col>
							</el-row>																
					</el-col>
					<el-col :span="10"><div class="grid-content"></div></el-col>		
				</el-row>
			</el-col>
		</el-row>
		<el-row :gutter="20">
			<el-col :span="24">
				<template>
					<el-tabs v-model="activeName" type="border-card">
						<el-tab-pane :label="trans('profile.activities')" name="first">

						</el-tab-pane>
						<el-tab-pane :label="trans('profile.changePass')" name="two">
							<change-pass></change-pass>
						</el-tab-pane>
						<el-tab-pane :label="trans('profile.setting')" name="third">
							 <el-form id="update_form"  :model="form" @keyup.enter.native="updateUser" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
								 	 <user-profile :user='user'></user-profile>  
									<el-form-item>
										<el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>										
									</el-form-item>									
							 </el-form>
						</el-tab-pane>
					</el-tabs>
				</template>
			</el-col>
		</el-row>
	</div>
</template>
<style>
  .el-row {
    margin-bottom: 20px;
    &:last-child {
      margin-bottom: 0;
    }
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
	}
	.profile-user-img{
		width: 100% !important;
	}
  .el-tabs__nav:lang(fa){
		float: right !important;
		text-align: justify;
		direction: rtl;
	}
	.el-tabs__nav:lang(en){
		float: left;
	}
	.el-tabs__content:lang(en){
		text-align: justify;
		direction: ltr;
	}
	.el-tabs__content:lang(fa){
				text-align: justify;
		direction: rtl;
	}	
</style>
<script>
	import {errorMessage} from '../../utilities';
	import userProfile from '../user/userProfile';
	import changePass from '../user_profile/changePass';
  export default {
	data(){
					return{
								imageUrl:'images/user4-128x128.jpg',
								form: {},
								user:{},
								avatar:'',
								headerInfo: {
										'Accept': 'application/json'
								},
								structure:{},
								activeName: 'first'
					}
        },
			methods: {
				/**
				 * Load User Info
				 */
				loadUserInfo(){
					this.user = this.$route.params.user;
				},				
				/*
				|--------------------------------------------------------------------------
				| handleAvatarSuccess
				|--------------------------------------------------------------------------
				|
				| This method handleAvatarSuccess
				|
				*/        
				handleAvatarSuccess(res, file) {
					this.user.avatar = URL.createObjectURL(file.raw);
				},
				/*
				|--------------------------------------------------------------------------
				| Validate Avatar Befor Upload
				|--------------------------------------------------------------------------
				|
				| This method Validate Avatar Befor Upload
				|
				*/     
				onBeforeUpload(file) {
						const isJPG = file.type === 'image/jpeg';
						const isLt2M = file.size / 1024 / 1024 < 2;
						if (!isJPG) {
								this.$message.error('Avatar picture must be JPG format!');
						}
						if (!isLt2M) {
								this.$message.error('Avatar picture size can not exceed 2MB!');
						}
						return (isJPG & isLt2M);
				},
				/*
				|--------------------------------------------------------------------------
				| Update User Method
				| Added By e.bagherzadegan        
				|--------------------------------------------------------------------------
				|
				| This method Update User Info To Database
				|
				*/          
				updateUser(){      
				var jsonData = {};
				for (var i=0 ;i<this.structure.length;i++)
				{
						var columnName = this.structure[i].name;
						jsonData[columnName] = this.form.data[this.structure[i].name];
				};
				this.formData = new FormData( document.getElementById("update_form") );
				axios.post('../api/profile/user/?_method=put',this.formData).then(response => {      
						this.$message({
							type: 'success',
							center: true,
							message:response.data.message
						});
						this.backToUserList();   
						}).catch((error) => {
							let msgErr = errorMessage(error.response.data.errors);
							this.$message({
								type: 'error',
								dangerouslyUseHTMLString: true,
								message:msgErr             
							});
					});        
				},				
				/*
				|--------------------------------------------------------------------------
				| Submit Form Method
				| Added By e.bagherzadegan        
				|--------------------------------------------------------------------------
				|
				| This method Submit Form
				|
				*/          
				submitForm(formName) {
					this.$refs[formName].validate((valid) => {
						if (valid) 
						{
							this.updateUser();
							Fire.$emit('AfterCrud');            
						}
						else {
							return false;
						}
					});
				},				
			},
			created() {
				this.loadUserInfo();
			},
			components :
			{
				'user-profile':userProfile,
				'change-pass' :changePass
			},
    }
</script>