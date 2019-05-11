<template>
    <div class="container">
        <el-card class="box-card">
            <el-form id="update_form" :model="form"  ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                prop="form.graphy_dicom"
                :rules="[
                { required: false, message: trans('reception.dicomRequierdError')}
                ]"
                >
                  <el-upload
                      class="dicom-uploader"
                      :headers="headerInfo"
                       ref="dicom"
                       action=""
                       name="graphy_dicom"
                      :limit=1
                      :on-success="handleAvatarSuccess"
                      :before-upload="onBeforeUpload"
                      :auto-upload="false">           
                  <el-button slot="trigger" size="small" type="primary">{{trans('reception.select_dicom_picture')}}</el-button> 
                      <img  v-if="imageUrl" :src="imageUrl" class="img-fluid img-circle" alt="User profile picture">               
                  </el-upload>
                </el-form-item>
                <el-form-item
                prop="from.graphy_jpg"
                :rules="[
                { required: false, message: trans('reception.imgsRequierdError')}
                ]"
                >
                  <el-upload                     
                      :headers="headerInfo"
                      ref="jpg"
                      id="jpg"
                      action=""
                      name="graphy_jpg"
                      list-type="picture-card"
                      :limit=5
                      :multiple="true"                 
                      :auto-upload="false"
                      :on-change="handleUploadJpg"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove">
                      <i class="el-icon-plus"></i>
                  </el-upload>
                  <el-dialog :visible.sync="dialogVisible">
                      <img width="100%" :src="dialogImageUrl" alt="">
                  </el-dialog>
                </el-form-item>
                <el-form-item>
                <el-button  size="mini" type="success" @click="updateReception()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                <el-button size="mini" type="info" @click="backToReceptionList()"  plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
                </el-form-item>                
            </el-form>
        </el-card>
    </div>
</template>
<style>

</style>
<script>
export default {
    data() {
      return {
        dialogImageUrl: '',
        dialogVisible: false,
        imageUrl:'',
        dicomImageUrl:'',
        headerInfo: {
            'Accept': 'application/json'
        },
        form:{
            graphy_dicom:'',
            graphy_jpg:'',
        },        
        receptionId:'',
      }
    },
    methods:{
      backToReceptionList(){
        this.$router.go(-1);
      },
      handleUploadJpg(){
        this.files = this.$refs.files.files;
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
    handleRemove(file, fileList) {
        console.log(file, fileList);
        this.graphy_jpg = fileList;
    },
    handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
    },
/*
    |--------------------------------------------------------------------------
    | Create User Method
    |--------------------------------------------------------------------------
    |
    | This method Add User Info To Database
    |
    */
    getReceptionInfo() {
        this.receptionId=this.$route.params.receptionId;
        axios.get("../api/receptions/"+this.receptionId+"/result").then(({
            data})=>{(this.form = data.data)}).catch(()=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
                title: '',
                message: msgErr,
                center: true,
                dangerouslyUseHTMLString: true,
                type: 'error'
            });               
        });
    },    
  },
  created(){
      //this.getReceptionInfo();
  }
}
</script>