<template>
        <el-row :gutter="10" class="user-panel mt-3 pt-2 mb-3 d-flex text-justify">
            <el-col :span="5" class="profile-image">
                <el-upload
                    class="avatar-uploader image"
                    action="../api/users/me/avatar/"
                    :headers="headerInfo"
                    :show-file-list="false"
                    name="avatar"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="user.avatar" :src="user.avatar" class="img-circle el-icon-plus elevation-2" alt="User profile picture">
                    <span v-else class="ant-avatar ant-avatar-circle ant-avatar-icon" data-v-21b4b419="" style="width: 64px; height: 64px; line-height: 100%; font-size: 32px;color:#ffffff"><i class="anticon anticon-user"><svg viewBox="64 64 896 896" data-icon="user" width="1em" height="1em" fill="currentColor" aria-hidden="true" class=""><path d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"></path></svg></i></span>
                    <div class="edit"><a href="#"><i class="fas fa-edit"></i></a></div>
                </el-upload>
            </el-col>
            <el-col :span="18" class="info text-white">{{user.fullname}}</el-col>
            <el-col :span="1" class="mt-2">
                <a href="#" @click="editProfile()" id="profile-link">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
            </el-col>
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

.edit:lang(fa) {
    padding-top: 7%;
    padding-right: 9%;
	position: absolute;
	right: 0;
	top: 0;
	display: none;
}
.edit:lang(en) {
    padding-top: 7%;
    padding-left: 12%;
	position: absolute;
	left: 0;
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
import {errorMessage} from '../../utilities';
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
            axios.get("../api/users/me").then(({data})=>{(this.user =data.data),(this.profile_id =data.data.profile_id) }).catch((error)=>{
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({                      
                    message:msgErr,
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
                axios.post('../api/users/me/avatar', param, config).then((response) =>{
                this.user.avatar = response.data.url;
                this.$message({
                        type: 'success',
                        center: true,
                        message:response.data.message
                    });
                })
                .catch((error) => {
                    let msgErr = errorMessage(error.response.data.errors);
                    this.$message({
                        message: msgErr,
                        center: true,
                        type: 'error'
                    });
                });
            }
        },
        editProfile(){
            this.$router.push({ name: 'profiles', params: { profile_id: this.user.profile_id}});
        }
    },
    created() 
    {
        this.loadUserInfo();
    },


}
</script>

