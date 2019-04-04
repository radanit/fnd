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
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
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
             this.$router.push({ name: 'profiles'});
        }
    },
    created() 
    {
        this.loadUserInfo();
    },


}
</script>

