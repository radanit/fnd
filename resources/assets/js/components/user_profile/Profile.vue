<template>
	<div dir="rtl">
		<el-row :gutter="20">
			<el-col :span="24">
				<el-row :gutter="20">
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
							<el-upload
							class="avatar-uploader"
							action="https://jsonplaceholder.typicode.com/posts/"
							:show-file-list="false"
							:on-success="handleAvatarSuccess"
							:before-upload="beforeAvatarUpload">
							<img v-if="imageUrl" :src="imageUrl" class="profile-user-img img-fluid  el-icon-plus" alt="User profile picture">
							<i v-else class="el-icon-plus avatar-uploader-icon"></i>
						</el-upload>
					</el-col>
				</el-row>
			</el-col>
		</el-row>
		<el-row :gutter="20">
			<el-col :span="24">
				<template>
					<el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
						<el-tab-pane :label="trans('profile.activities')" name="first">User</el-tab-pane>
						<el-tab-pane :label="trans('profile.doctors')" name="second">Config</el-tab-pane>
						<el-tab-pane :label="trans('profile.setting')" name="third">Role</el-tab-pane>
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
								activeName: 'first'
					}
        },
			methods: {
				/**
				 * Load User Info
				 */
				loadUserInfo(){					
					axios.get("../api/profile/user").then(({data})=>{(this.user =data.data),(this.profile_id =data.data.profile_id) }).catch((error)=>{
							this.$message({                      
								message:error.response.data.errors,
								center: true,
								type: 'error'
							});

					});
				},
	      handleAvatarSuccess(res, file) {
	        this.imageUrl = URL.createObjectURL(file.raw);
	      },
	      beforeAvatarUpload(file) {
	        const isJPG = file.type === 'image/jpeg';
	        const isLt2M = file.size / 1024 / 1024 < 2;

	        if (!isJPG) {
	          this.$message.error('Avatar picture must be JPG format!');
	        }
	        if (!isLt2M) {
	          this.$message.error('Avatar picture size can not exceed 2MB!');
	        }
	        return isJPG && isLt2M;
				},
					handleClick(tab, event) {
					console.log(tab, event);
				}
			},
			components:{ 
					'doctor-profile' : DoctorProfile,
					'patient-profile' :PatientProfile,
					'technician-profile' :TechnicianProfile,
					'default-profile' :DefaultProfile
				 },
			mounted() {
				this.loadUserInfo();			
			}
    }
</script>