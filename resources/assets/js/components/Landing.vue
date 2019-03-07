<template>
  <div v-loading.fullscreen.lock="fullscreenLoading">
    <el-dialog title="landing Page" :visible.sync="dialogTableVisible" fullscreen="true">
		<div class="card card-primary card-outline">
		  <div class="card-body box-profile">
			<div class="text-center profile-image">
			<el-upload>
			  <img v-if="imageUrl" :src="imageUrl" class="profile-user-img img-fluid img-circle el-icon-plus" alt="User profile picture">
			  <i v-else class="el-icon-plus avatar-uploader-icon"></i>		
				<div class="edit"><a href="#"><i class="fas fa-edit"></i></a></div>
			</el-upload>
			</div>
			<h3 class="profile-username text-center">sdsdsd</h3>
			<p class="text-right text-center">sdsdsd</p>
		  </div>
		</div>
        <el-row :gutter="12">
            <el-col :span="6">
                <el-card shadow="hover">
                MAI
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card shadow="hover">
                MAM
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card shadow="hover">
                CEW
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card shadow="hover">
                CEM
                </el-card>
            </el-col>            
        </el-row>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        imageUrl:'images/user4-128x128.jpg',
        fullscreenLoading: false,
        dialogTableVisible: false,
      }
    },
    methods: {
      openFullScreen() {
        this.fullscreenLoading = true;
        setTimeout(() => {
          this.fullscreenLoading = false;
        }, 2000);
      }
    },
    created(){
        this.openFullScreen();
        this.dialogTableVisible = true;
    }
  }
</script>