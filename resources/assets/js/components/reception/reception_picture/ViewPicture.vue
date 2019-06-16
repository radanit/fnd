<template>
    <div class="container">
        <el-card class="box-card">
            <el-form id="update_form" :model="form"  ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                  <el-upload
                      class="dicom-uploader"
                      :headers="headerInfo"
                       ref="form.graphy_dicom"
                       action=""
                       name="graphy_dicom"
                      :limit=1
                      :on-success="handleAvatarSuccess"
                      :before-upload="onBeforeUpload"
                      :auto-upload="false">           
                  <el-button slot="trigger" size="small" type="primary">{{trans('reception.select_dicom_picture')}}</el-button> 
                      <img  v-if="imageUrl" :src="imageUrl" class="img-fluid img-circle" alt="User profile picture">               
                  </el-upload>
                  <el-upload                     
                      :headers="headerInfo"
                      ref="form"
                      action=""
                     :file-list="form"
                      name="graphy_jpg"
                      list-type="picture-card"
                      :limit=5
                      :multiple="true"                 
                      >
                      <i class="el-icon-plus"></i>
                  </el-upload>
                  <el-dialog :visible.sync="dialogVisible">
                      <img width="100%" :src="form.graphy_jpg" alt="">
                  </el-dialog>
                <img id="graphy_jpg" width="100%" :src="form" alt="">           
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
        actionUrl:"../api/receptions/1/capture/1",
        fileList:''
      }
    },
    methods:{
      backToReceptionList(){
        this.$router.go(-1);
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
        axios.get("../api/receptions/"+this.receptionId+"/capture/1").then(({
            data})=>{(this.form = data)}).catch(()=>{
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
    hexToBase64(str) {
        return btoa(String.fromCharCode.apply(null, str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" ")));
    }
  },
  created(){
      this.getReceptionInfo();
      document.getElementById("graphy_jpg").src ='data:image/jpeg;base64,' + this.form;
      console.log(this.form);
  },

}
</script>