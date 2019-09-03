<template>
   <div id="container">
     <el-form>
       <el-form-item>
        <el-button  size="mini" type="success" @click="dialogVisible = true" plain>{{trans('app.completeBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
        <el-button  size="mini" type="warning" @click="RejectReception()" plain>{{trans('app.rejectBtnLbl')}} <i class="fas fa-times-circle"></i></el-button>
        <el-button size="mini" type="info" @click="backToReceptionList()" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
        </el-form-item>  
       <el-form-item>
          <vue-editor v-model="result" :editorToolbar="customToolbar"></vue-editor>
       </el-form-item>        
        <el-dialog
          :title="trans('reception.add_vote_card_title')"
          :visible.sync="dialogVisible"
          width="45%"
          :before-close="handleClose">
          <el-form-item :label="trans('app.graphy_rate')">
            <el-rate
                v-model="rate"
                :colors="colors">
            </el-rate>
          </el-form-item>
          <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="updateReception('ok')">{{trans('reception.like_add_vote_btn_lbl')}}</el-button>
            <el-button @click="updateReception('no')">{{trans('reception.dontlike_add_vote_btn_lbl')}}</el-button>            
          </span>
        </el-dialog>
        <el-form-item>
          <el-button  size="mini" type="success" @click="dialogVisible = true" plain>{{trans('app.completeBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
          <el-button  size="mini" type="warning" @click="RejectReception()" plain>{{trans('app.rejectBtnLbl')}} <i class="fas fa-times-circle"></i></el-button>
          <el-button size="mini" type="info" @click="backToReceptionList()" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
        </el-form-item>          
     </el-form>
   </div>   
 </template>
 <style>
 .ql-snow .ql-picker-label{
     padding-right: 15px !important;
     display:inline-grid !important;
 }
 
 .ql-container{
   font-family: Vazir, Tahoma, sans-serif !important;
 }
 </style>
 
 <script>
   import { VueEditor } from 'vue2-editor'
   import {errorMessage} from '../../../utilities';

   export default {
 
   components: {
      VueEditor
   },
 
   data() {
       return {
         dialogVisible: false,
         rate:null,
         receptId:'',
         colors: ['#99A9BF', '#F7BA2A', '#FF9900'], // same as { 2: '#99A9BF', 4: { value: '#F7BA2A', excluded: true }, 5: '#FF9900' }
         result: '',
         customToolbar: [
            [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline','strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': 'center'}, { 'align': 'justify' },{ 'align': 'right'},{ 'align': '' }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'direction': 'rtl' }],
          ] 
       }
     },
     methods :{
      handleClose(done) {
        done();
      },
      backToReceptionList(){
        this.$router.go(-1);
      },
      /*
      |--------------------------------------------------------------------------
      | update Reception Method
      |--------------------------------------------------------------------------
      |
      | This method Update Reception Info To Database
      |
      */
      updateReception(bool) {
        if(bool == 'no')
          this.rate = 0;
        this.dialogVisible = false;          
          let receptionInfo={
            result : this.result,
            votes :this.rate
          }
          this.receptId=this.$route.params.receptionId;
          axios.post('../api/receptions/'+this.receptId+'/result?_method=put',receptionInfo).then(response => {
          this.$message({
              type: 'success',
              center: true,
              message:response.data.message
            });
           this.backToReceptionList();
          })          
          .catch((error) => {
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              message: msgErr,
              center: true,
              type: 'error',
              dangerouslyUseHTMLString: true
            });
          });     
        },
      /*
      |--------------------------------------------------------------------------
      | Reject Reception Method
      |--------------------------------------------------------------------------
      |
      | This method Reject Reception Info To Database
      |
      */
      RejectReception() {
          let receptionInfo={
            result : this.result,
            votes :this.rate
          }
          this.receptId=this.$route.params.receptionId;
          axios.patch('../api/receptions/'+this.receptId+'/result',receptionInfo).then(response => {
          this.$message({
              type: 'success',
              center: true,
              message:response.data.message
            });
           this.backToReceptionList();
          })          
          .catch((error) => {
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              message: msgErr,
              center: true,
              type: 'error',
              dangerouslyUseHTMLString: true
            });
          });     
        }        
      },
   }
 </script> 