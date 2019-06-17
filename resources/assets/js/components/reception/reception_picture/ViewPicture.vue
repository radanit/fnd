<template>
    <div class="container">
        <el-card class="box-card">
                <div style="display:inline-block" v-for="item in form.graphy_jpg" :key="item.id">
                    {{getReceptionPics(item.id)}}
                    <img :id="item.id" @click="open(item.id)" style="width: 100px; height: 100px;padding-left:10px;" class="pointer" />
                </div> 
                

        </el-card>
    </div>
</template>
<script>
import {errorMessage} from '../../../utilities';
export default {
    props:['form'],
    data() {
      return {
        src: [],
        dialogImageUrl: '',
        dialogVisible: false,
        imageUrl:'',
        dicomImageUrl:'',
        headerInfo: {
            'Accept': 'application/json'
        },
        viewPicForm:[],        
        receptionId:'',
        actionUrl:"../api/receptions/1/capture/1",
        fileList:[{}]
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
    getReceptionPics(id) {
        this.receptionId=this.$route.params.receptionId;
        axios.get("../api/receptions/"+this.receptionId+"/capture/"+id,{responseType: 'arraybuffer'}).then((response) => {
              var bytes = new Uint8Array(response.data);
              var binary = bytes.reduce((data, b) => data += String.fromCharCode(b), '');
              this.src[id] = "data:image/jpeg;base64," + btoa(binary);
              document.getElementById(id).src=this.src[id];
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
                    
      },
      open(id) {
            this.imageUrl= document.getElementById(id).src;
            this.$alert('<img id="orginImage" src="'+this.imageUrl+'"/>', '', {
            confirmButtonText:trans('app.closeBtnLbl'),
            dangerouslyUseHTMLString: true
        });
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
</style>
