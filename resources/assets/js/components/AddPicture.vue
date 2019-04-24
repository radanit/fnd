<template>
    <div class="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>{{trans('app.selectImages')}}</span>
            </div>
            <el-upload
                class="avatar-uploader"
                :headers="headerInfo"
                ref="upload"
                action=""
                name="avatar"
                :limit=5
                :on-success="handleAvatarSuccess"
                :before-upload="onBeforeUpload"
            :auto-upload="false">           
            <el-button slot="trigger" size="small" type="primary">انتخاب تصویر</el-button> 
                <img  v-if="imageUrl" :src="imageUrl" class="img-fluid img-circle" alt="User profile picture">               
            </el-upload>
            <br/>
            <el-upload
                class="avatar-uploader"
                :headers="headerInfo"
                ref="upload"
                action=""
                name="avatar"
                :limit=1
                :on-success="handleAvatarSuccess"
                :before-upload="onBeforeUpload"
            :auto-upload="false">               
            <el-button slot="trigger" size="small" type="primary">انتخاب تصویر Dicom</el-button> 
                <img  v-if="dicomImageUrl" :src="dicomImageUrl" class="img-fluid img-circle" alt="User profile picture">               
            </el-upload>
        </el-card>
    </div>
</template>
<style>

</style>
<script>
export default {
    data() {
      return {
        imageUrl:'',
        dicomImageUrl:'',
        headerInfo: {
            'Accept': 'application/json'
        },
        formData:'',
      }
    },
    methods:{
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
}
</script>