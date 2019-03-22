<template>
	<div :dir="trans('app.dir')">
		<el-row :gutter="20">
			<el-col :span="24">
				<el-row v-if="trans('app.dir')==='rtl'" :gutter="20">
						<el-col :span="10"><div class="grid-content bg-purple"></div></el-col>
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
              <el-upload
                    v-if="item.item=='el-upload'"
                    class="avatar-uploader"
                    action="../api/profile/user/avatar"
                    :headers="headerInfo"
                    :show-file-list="false"
                    name="avatar"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="user.avatar" :src="user.avatar" class="profile-user-img img-fluid el-icon-plus" alt="User profile picture">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    <div class="edit"><a href="#"><i class="fas fa-edit"></i></a></div>
              </el-upload>
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
					<el-col :span="10"><div class="grid-content bg-purple"></div></el-col>
				</el-row>
			</el-col>
		</el-row>
		<el-row :gutter="20">
			<el-col :span="24">
				<template>
					<el-tabs v-model="activeName" type="border-card">
						<el-tab-pane :label="trans('profile.activities')" name="first">User</el-tab-pane>
						<el-tab-pane :label="trans('profile.setting')" name="third">
							 <el-form  :model="form" @keyup.enter.native="updateUser" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
								<el-form-item v-for="(item, key, index) in this.structure" :key="item.key"
									:label="trans(item.label)"
												:prop="item.name"
												:rules="[
													{ type:item.type,required:item.required, message: trans(item.errorMsg)}
												]">
										<el-input v-if="item.item=='el-input' " v-model="user[item.name]" :name="item.name" type="text"></el-input>
										<el-select @focus="loadList(item.apiUrl)" v-if="item.item=='el-select' " v-model="form[item.name]" :name="item.name" >
											<el-option
												v-for="option in lists"
												:key="option.id"
												:label="option.description"
												:value="option.id">
											</el-option>
										</el-select>
										<el-upload
											v-if="item.item=='el-upload'"
											class="avatar-uploader"
											:headers="headerInfo"
											ref="upload"
											action=""
											name="avatar"
											:limit=1
											:on-success="handleAvatarSuccess"
											:before-upload="onBeforeUpload"
											:auto-upload="false">               
											<el-button slot="trigger" size="small" type="primary">انتخاب تصویر</el-button> 
											<img v-if="user.avatar" :src="user.avatar" class="img-fluid img-circle" alt="User profile picture">               
										</el-upload>                                
									</el-form-item>
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
import DoctorProfile from './DoctorProfile.vue';
import PatientProfile from './PatientProfile.vue';
import TechnicianProfile from './TechnicianProfile.vue';
import DefaultProfile from './DefaultProfile.vue';
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
				loadProfileSructure(){
					axios.get("../api/profile/profiles/"+this.user.profile_id).then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
							this.$message({                      
								message:error.response.data.errors,
								center: true,
								type: 'error'
							}); 
					});
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
			},
			components:{ 
					'doctor-profile' : DoctorProfile,
					'patient-profile' :PatientProfile,
					'technician-profile' :TechnicianProfile,
					'default-profile' :DefaultProfile
				 },
			created() {
				this.loadUserInfo();
				this.loadProfileSructure();
			}
    }
</script>