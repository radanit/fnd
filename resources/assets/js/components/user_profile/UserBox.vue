<template>
    <el-row style="font-size:12px;color:#fff;text-align:center;white-space:nowarp;">
        <el-row :gutter="10" class="userbox-msg">
            <el-col :span="3" class="mt-2">
                <a href="#" @click="editProfile()" id="profile-link">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
            </el-col>
            <el-col :span="7" class="mt-4 brand-text font-weight-light">{{trans('app.welcome_message')}}</el-col>
            <el-col :span="7" class="mt-1 profile-image">
                <el-upload
                    class="avatar-uploader"
                    action="../api/profile/user/avatar/"
                    :headers="headerInfo"
                    :show-file-list="false"
                    name="avatar"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="user.avatar" :src="user.avatar" class="profile-user-img img-fluid img-circle el-icon-plus" alt="User profile picture">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    <div class="edit"><a href="#"><i class="fas fa-edit"></i></a></div>
                </el-upload>
            </el-col>
            <el-col :span="7" class="mt-4 brand-text font-weight-light">{{user.fullname}}</el-col>
        </el-row>
        <el-row :gutter="10" class="userbox-date">
            <el-col :span="8" class="brand-text font-weight-light">{{trans('app.current_date')}}<br/><span class="darkOrange">{{ new Date() | moment("jYYYY/jM/jD") }}</span></el-col>
            <el-col :span="8" class="brand-text font-weight-light"><a href="/logout" @click="logout()" id="user-logout"><i class="nav-icon fas fa-power-off darkOrange"></i><br/>{{trans('menus.logout')}}</a></el-col>            
            <el-col :span="8" class="brand-text font-weight-light">{{trans('app.last_login')}}<br/><span class="darkOrange">{{user.last_login | moment("jYYYY/jM/jD") }}</span></el-col>
        </el-row>
    </el-row>
</template>
<style>
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
  .profile-link:active{
      background-color: #3490dc !important;
  }
  .el-row{
    margin:0 !important;
    padding-bottom: 5px;
    top: 1%;
  }
  #user-logout{
      color: darkOrange;
  }
  .profile-image:hover .edit {
	display: block;
}

.edit {
    padding-top: 11%;
    padding-right: 40%;
	position: absolute;
	right: 0;
	top: 0;
	display: none;
}
.userbox-date{
    background: #ffffff;
    color: #000000;
    font-style: bold;
    padding-top: 10px;
}
.userbox-msg{
    background: #3490dc;
    height: 75px;
}
</style>
<script>
export default {
	data(){
        return{          
            form: {},
            user:{},
            avatar:'',
            headerInfo: {
                'Accept': 'application/json'
            },
        }
    },
  methods:{
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
            //this.user.avatar = URL.createObjectURL(file.raw);
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
            let param = new FormData()  
                param.append('avatar', file, file.name) 
            let config = {
                headers: {'Content-Type': 'multipart/form-data'}
            }
            if(isJPG & isLt2M)
            {
                axios.post('../api/profile/user/avatar', param, config).then((response) =>{
                this.user.avatar = response.data.url;
                this.$message({
                        type: 'success',
                        center: true,
                        message:response.data.message
                    });
                })
                .catch((error) => {
                    this.$message({
                        message: error.response.data.errors,
                        center: true,
                        type: 'error'
                    });
                });
            }
        },
        editProfile(){
             this.$router.push({ name: 'profiles', params: { user: this.user} });
        }
    },
    created() 
    {
        this.loadUserInfo();
    },


}
</script>

