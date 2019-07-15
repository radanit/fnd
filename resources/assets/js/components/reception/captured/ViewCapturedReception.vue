<template>
    <div class="container">
        <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item :title="trans('reception.registered_reception_info')" name="receptionInfo">
                <show-reception :apiUrl="apiUrl"></show-reception>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_pictures')" name="receptionPictures">
                <view-pictures :form = form></view-pictures>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_opinion')" name="receptionOpinion">
                <opinion-reception></opinion-reception>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>
<style>
.el-collapse-item__arrow{
  float:right;
  padding: 15px;
}
.el-collapse-item__header{
  display: block;
  text-align: justify;
}
.el-collapse-item__content{
  text-align: justify;
}
</style>
<script>
import {errorMessage} from '../../../utilities';
import ShowReception from '../ShowReception.vue';
import ViewPictures from '../reception_picture/ViewPicture.vue';
import ReceptionOpinion from './ReceptionOpinion.vue';
  export default {
    data() {
      return {
        activeNames: ['receptionOpinion'],
        apiUrl:"../api/receptions/"+this.$route.params.receptionId+"/result",
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
        doctor_lists:[],
        radio_type_lists:[],
      };
    },
    methods: {
        handleChange(val) {
          //console.log(val);
        },
       /*
        |--------------------------------------------------------------------------
        | Load Selected Reception Info
        |--------------------------------------------------------------------------
        |
        | This method load profile info for edit
        |
        */
        loadReception(){
            this.form.id=this.$route.params.receptionId;
            axios.get(this.apiUrl).then(({data})=>(this.form = data.data)).catch(()=>{
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
    created(){
      this.loadReception();
    },
    components: {
        'show-reception' : ShowReception,
        'view-pictures' : ViewPictures,
        'opinion-reception' : ReceptionOpinion,
    }
  }
</script>