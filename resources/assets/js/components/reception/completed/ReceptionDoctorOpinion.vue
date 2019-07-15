<template>
   <div id="container">
      <div class="card-body" v-for="item in results" :key="item.id">
        <div v-if="trans('app.dir')=='rtl'" class="direct-chat-messages right">
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name float-right">{{doctor.fullname}}</span>
              <span class="direct-chat-timestamp float-left">{{ item.reception_date | moment("jYYYY/jM/jD") }}</span>
            </div>
            <img v-if="doctor.avatar" :src="doctor.avatar" alt="message user image" class="direct-chat-img">
            <span v-else class="ant-avatar ant-avatar-circle ant-avatar-icon" data-v-21b4b419="" style="width: 64px; height: 64px; line-height: 100%; font-size: 32px;color:#ffffff"><i class="anticon anticon-user"><svg viewBox="64 64 896 896" data-icon="user" width="1em" height="1em" fill="currentColor" aria-hidden="true" class=""><path d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"></path></svg></i></span>
            <div class="direct-chat-text" v-html="item.result"></div>
          </div>
        </div>
        <div v-if="trans('app.dir')=='ltr'" class="direct-chat-messages left">
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name float-left">{{doctor.fullname}}</span>
              <span class="direct-chat-timestamp float-right">{{ item.reception_date }}</span>
            </div>
            <img v-if="doctor.avatar" :src="doctor.avatar" alt="message user image" class="direct-chat-img">            
            <span v-else class="ant-avatar ant-avatar-circle ant-avatar-icon" data-v-21b4b419="" style="width: 64px; height: 64px; line-height: 100%; font-size: 32px;color:#ffffff"><i class="anticon anticon-user"><svg viewBox="64 64 896 896" data-icon="user" width="1em" height="1em" fill="currentColor" aria-hidden="true" class=""><path d="M858.5 763.6a374 374 0 0 0-80.6-119.5 375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1-.4.2-.8.3-1.2.5-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8 2-77.2 33-149.5 87.8-204.3 56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z"></path></svg></i></span>
            <div class="direct-chat-text">{{trans('chat.fileDes')}}<a href="#" @click="viewReception(item.id)">{{item.id}}</a>{{trans('chat.patientName')}}{{item.result}}{{trans('chat.receivedMsg')}}</div>
          </div>
        </div>        
      </div>
      <el-button size="mini" type="info" @click="backToReceptionList()" plain class="mr-2">{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>     
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
 .row-background{
   background-color: darkgray;
 }
 </style>
 
 <script>
   import {errorMessage} from '../../../utilities';

   export default {
   props: ['results' , 'doctor'],
 
   data() {
       return {
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
      updateReception() {
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