<template>
    <div class="container">
        <el-card class="box-card">
                <div style="display:inline-block" v-for="dicom_item in form.graphy_dicom" :key="dicom_item.id" class="mb-4">
                    {{getReceptionDicom(dicom_item.id)}}
                    <a :id="dicom_item.id">{{trans('reception.download_dicom')}}</a>
                </div>
                <br>
                <div class="images" v-viewer v-loading="loading">
                  <span class="recept-pic" v-for="item in form.graphy_jpg" :key="item.id">
                      {{getReceptionPics(item.id)}}
                      <img :id="item.id"  style="width: 100px; height: 100px;padding-left:10px;" class="pointer" />
                      <a :id="'dnl-'+item.id">{{trans('reception.download_pic')}}</a>
                  </span>
                </div>
        </el-card>
    </div>
</template>
<script>
import {errorMessage} from '../../../utilities';
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import Vue from 'vue'
Vue.use(Viewer)
export default {
    props:['form'],
    data() {
      return {
        loading:true,
        src: [],
        dnl: [],
        DicomSrc:[],
        dialogImageUrl: '',
        dialogVisible: false,
        imageUrl:'',
        dicomImageUrl:'',
        headerInfo: {
            'Accept': 'application/json'
        },      
        receptionId:'',
      }
    },
    methods:{
      backToReceptionList(){
        this.$router.go(-1);
      },
    /*
    |--------------------------------------------------------------------------
    | Load Jpg Pictures Method
    |--------------------------------------------------------------------------
    |
    | This method Load Jpg Pictures From Database
    |
    */
      getReceptionPics(id) {
          this.receptionId=this.$route.params.receptionId;
          axios.get("../api/receptions/"+this.receptionId+"/capture/"+id,{responseType: 'arraybuffer'}).then((response) => {
                var bytes = new Uint8Array(response.data);
                var binary = bytes.reduce((data, b) => data += String.fromCharCode(b), '');
                this.src[id] = "data:image/jpeg;base64," + btoa(binary);
                this.dnl[id] = this.src[id].replace(/^data:image\/[^;]+/, 'data:application/octet-stream');
                document.getElementById(id).src=this.src[id];
                document.getElementById('dnl-'+id).href=this.dnl[id];
                this.loading = false;
            }).catch(()=>{
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
    /*
    |--------------------------------------------------------------------------
    | Load Dicom Picture Method
    |--------------------------------------------------------------------------
    |
    | This method Load Dicom Picture From Database
    |
    */
    getReceptionDicom(id) {
          this.receptionId=this.$route.params.receptionId;
          axios.get("../api/receptions/"+this.receptionId+"/capture/"+id,{responseType: 'arraybuffer'}).then((response) => {
                var bytes = new Uint8Array(response.data);
                var binary = bytes.reduce((data, b) => data += String.fromCharCode(b), '');
                this.DicomSrc[id] = "data:image/jpeg;base64," + btoa(binary);
                var url = this.DicomSrc[id].replace(/^data:image\/[^;]+/, 'data:application/octet-stream');
                document.getElementById(id).href=url;
            }).catch(()=>{
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
     handlePreview(file) {
        console.log(file);
      },
      showOrginalImage(id){
          this.dialogVisible = true;
      }
  },
  created(){
      
  },

}
</script>
<style>
.el-message-box{
    width:auto !important;
}
.pointer { cursor: pointer; }
.recept-pic{display:inline-grid}
</style>
