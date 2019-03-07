<template>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="card card-primary card-outline w-100">
            <div class="card-body box-profile">
            <div class="text-center profile-image">
            <el-upload>
            <img  src="images/user4-128x128.jpg" class="profile-user-img img-fluid img-circle el-icon-plus w-50 h-50" alt="User profile picture">
            </el-upload>
            </div>
            <h3 class="profile-username "></h3>
            <el-row :gutter="12" class="text-center nav-item" style="font-size:12px;">
                <el-col :span="8">تاریخ امروز<br/>{{ new Date() | moment("jYYYY/jM/jD") }}</el-col>
                <el-col :span="8"><i class="nav-icon fas fa-power-off red"></i><br/>خروج</el-col>            
                <el-col :span="8">آخرین ورود<br/></el-col>
            </el-row>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
export default {
    data() {
    return {
      cuurentDate: new Date()
    };
  }
}
</script>
