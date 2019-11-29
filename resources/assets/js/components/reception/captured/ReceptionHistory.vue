<template>
   <div id="container">
     <ul id="example-1">
      <li v-for="(item, index) in list" v-if="item.id!=reception_id">
        {{trans('reception.file_number')}} 
        <el-link v-if="item.status!='recepted'" type="info" @click="loadHistoryReceptionPic(item.id)">{{ item.id }}</el-link>
        <span v-else>{{ item.id }} {{trans('reception.whithout_pic')}}</span>
        {{trans('reception.done_in')}} {{item.reception_date | moment("jYYYY/jM/jD")}}
      </li>
    </ul>
    <el-dialog
      :title="trans('reception.reception_pictures')"
      :visible.sync="dialogVisible"
      width="80%"
      >
      <view-pictures :form="form"></view-pictures>
    </el-dialog>
   </div>   
 </template>
 <style>
 
 </style>
 
 <script>
   import {errorMessage} from '../../../utilities';
   import ViewPictures from '../reception_picture/ViewPicture.vue';
   export default {
   data() {
       return {
         list:[],
         apiUrl:'../api/receptions/result',
         reception_id:this.$route.params.receptionId,
         dialogVisible: false,
         form:{
          id: '',
          doctor:{
            id:''
          },
          radio_type_id:'',
          reception_date:'',
          patient:{
            national_id:'',              
            first_name: '',
            last_name: '',
            mobile:'',          
            birth_year:'',
            gender:'',
          }
        },
       }
     },
     methods :{
      backToReceptionList(){
        this.$router.go(-1);
        },
        /**
         * This Method Show Previous Reception Of This patient 
         * Added By e.bagherzadegan
         * */
      ReceptionHistory(){
          axios.get(this.apiUrl+'?filter[national_id]='+this.$route.params.national_id).then(({data})=>(this.list = data.data)).catch(()=>{
              let msgErr = errorMessage(error.response.data.errors);
              this.$message({
                title: '',
                message:msgErr,
                dangerouslyUseHTMLString: true,
                center: true,
                type: 'error'
              });                
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Load Selected Reception Info
        |--------------------------------------------------------------------------
        |
        | This method load profile info for edit
        |
        */
        loadHistoryReceptionPic(id){
          this.dialogVisible=true;
            this.$route.params.receptionId = id;
            axios.get("../api/receptions/"+id+"/result").then(({data})=>(this.form = data.data)).catch(()=>{
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({
                  title: '',
                  message:msgErr,
                  dangerouslyUseHTMLString: true,
                  center: true,
                  type: 'error'
                });                
            });
        },
      },
      created() {
        this.ReceptionHistory();
      },
      components: {
        'view-pictures' : ViewPictures,
    }
      
   }
 </script> 