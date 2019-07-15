<template>    
    <div class="container" @keydown.esc="backToReceptionList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	            <el-form label-position="right" disabled  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.reception_date')"
                    prop="reception_date"
                    >
                    <date-picker disabled tabindex=2 format="YYYY-MM-DD" display-format="jDD jMMMM jYYYY" :locale="('reception.locale')" v-model="form.reception_date" :auto-submit="true" :editable="true"></date-picker>
                   </el-form-item>                    
                  </el-col>
                  <el-col :span="12">
                    <el-form-item 
                    :label="trans('reception.national_id')"
                    prop="patient.national_id"
                    >
                    <el-input  tabindex=1 :minlength="11" :maxlength="11" name="national_id" ref="national_id" type="number"  v-model="form.patient.national_id" autocomplete="off"></el-input>
                    </el-form-item>                    
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.last_name')"
                    prop="patient.last_name"
                    >
                    <el-input tabindex=4 label="right" name="last_name" ref="last_name" type="text" v-model="form.patient.last_name" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.first_name')"
                    prop="patient.first_name"
                    >
                    <el-input tabindex=3 label="right" name="first_name" ref="first_name" type="text"  v-model="form.patient.first_name" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.birth_year')"
                    prop="patient.birth_year"
                    >
                    <date-picker disabled tabindex=6  v-model="form.patient.birth_year" type="year" :auto-submit="true" :editable="true" max="1397"></date-picker>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.mobile_number')"
                    prop="patient.mobile"
                    >
                    <el-input tabindex=5  label="right" name="mobile_number" ref="mobile_number" type="text" v-model="form.patient.mobile" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.doctor')"
                    prop="doctor_id">
                      <el-select tabindex=8
                        v-model.number="form.doctor_id"
                        filterable
                        default-first-option
                        :placeholder="trans('reception.doctor_choose')">
                        <el-option
                          v-for="p_item in doctor_lists"
                          :key="p_item.id"
                          :label="p_item.fullname"
                          :value="p_item.id">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.gender')"
                    prop="patient.gender"
                    >
                    <el-radio-group tabindex=7 v-model="form.patient.gender">
                      <el-radio-button :label="0">{{trans('reception.man')}}</el-radio-button>
                      <el-radio-button :label="1">{{trans('reception.women')}}</el-radio-button>
                    </el-radio-group>
                    </el-form-item>
                  </el-col>                
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="24">
                    <el-form-item
                    :label="trans('reception.radio_type')"
                    prop="radio_type_id">
                      <el-select tabindex=9
                        v-model.number="form.radio_type_id"
                        filterable
                        default-first-option
                        :placeholder="trans('reception.radio_type_choose')">
                        <el-option
                          v-for="item in radio_type_lists"
                          :key="item.id"
                          :label="item.description"
                          :value="item.id">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </el-col>            
                </el-row>
              </el-form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      
    </div>
</template>
<script>
import {errorMessage} from '../../utilities';
    export default {
      props:['apiUrl'],
        data(){
            return{
              form :{},
              doctor_lists:[],
              radio_type_lists:[],
            }
        },
        methods :{
        /*
        |--------------------------------------------------------------------------
        | Load Selected Profile Info
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
        /*
        |--------------------------------------------------------------------------
        | Load Patient Info
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method Load Patient Info
        |
        */    
        /*loadPatientInfo(){
          axios.get("../api/receptions?filter[national_id]="+this.form.patient.national_id).then(({data})=>{
            if (data.data.length>0)
            {
              (this.form = data.data[0].patient);
            }
            else{
              this.form.patient.first_name='';
              this.form.patient.last_name='';
              this.form.patient.birth_year='';
              this.form.patient.gender='';
              this.form.patient.mobile='';
            }
            }).catch((error)=>{
            let msgErr =errorMessage(error.response.data.errors);
            this.$message({
              title: '',
              message: msgErr,
              center: true,
              type: 'error',
              dangerouslyUseHTMLString: true
            });                
          });
        },*/                       
        /*
        |--------------------------------------------------------------------------
        | Back to User Reception List
        |--------------------------------------------------------------------------
        |
        | This method go back to User Reception list
        |
        */           
        backToReceptionList(){
          this.$router.push({ name: 'receptions'});
        },
        /*
        |--------------------------------------------------------------------------
        | Load Doctor List
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method Load Doctor list
        |
        */    
        loadDoctorList(){
          axios.get("../api/doctors").then(({data})=>(this.doctor_lists = data.data)).catch((error)=>{
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
        | Load Radio Type List
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method Radio Type list
        |
        */    
        loadRadioTypeList(){
          axios.get("../api/radiotypes").then(({data})=>(this.radio_type_lists = data.data)).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              title: '',
              message: msgErr,
              center: true,
              type: 'error'
            });                
          });
        },  
        updateReception(){
        let receptionInfo = {
          national_id: this.form.patient.national_id,
          reception_date: this.form.patient.reception_date,
          first_name: this.form.patient.first_name,
          last_name:this.form.patient.last_name,
          mobile_number:this.form.patient.mobile_number,
          birth_year:this.form.patient.birth_year,
          gender:this.form.patient.gender,
          doctor_id:this.form.doctor_id,
          radio_type_id:this.form.radio_type_id
        }
        axios.put('../api/receptions/'+this.form.id,receptionInfo).then(response => {
          this.$message({
            type: 'success',
            center: true,
            message:response.data.message,
          });
          Fire.$emit('AfterCrud');                  
            }).catch((error) => {
              let msgErr = errorMessage(error.response.data.errors);
              this.$message({
                type: 'error',
                center: true,
                dangerouslyUseHTMLString: true,
                message:msgErr
              });
          }); 
        },
        submitForm(formName) {
          this.$refs[formName].validate((valid) => {
            if (valid) 
            {
              this.updateReception();
            }
            else {
              return false;
            }
          });
        },
    },        
    created() {
        this.loadReception();
        this.loadDoctorList();
        this.loadRadioTypeList();
        Fire.$on('AfterCrud',() => {
            
        });
    },
    mounted(){
      //this.$refs.national_id.focus();
    }
}
</script>
<style>
.el-row {
  margin: 0px !important;
}
.el-form-item__label:lang(fa){
    float:right;
    text-align:left;
    padding:0 0 0 10px;
  }
  .el-form-item__label:lang(en){
    float: left;
    text-align: right;
    padding: 0 10px 0 0;
    white-space: nowrap;
  }
  .el-form-item__content:lang(fa){
    margin-right:130px!important;
    margin-left:0px;
    text-align: right;
  }
  .el-form-item__content:lang(en){
    margin-right:100px;
    margin-left:100px;
  }
  .el-form-item__error:lang(fa){
    right:0;
    left:auto;
  }
  .el-table .cell:lang(fa){
      float: right;
      text-align: right;
      direction: rtl;
  }
  .el-table .cell:lang(en){
      float: left;
      text-align: left;
      direction: ltr;
  }
  .el-popper:lang(en){
      text-align:left;
  }
  .el-popper:lang(fa){
      text-align:right;
  }
  .el-message-box__header:lang(fa)
  {
      direction:rtl;
  }
  .el-radio-button:last-child .el-radio-button__inner{
    border-radius: 4px 0px 0px 4px !important;
  }
  .el-radio-button:first-child .el-radio-button__inner{
     border-radius: 0px 4px 4px 0px !important;
  }
  .el-radio-button:first-child .el-radio-button__inner{
    border-right: 1px solid #dcdfe6 !important;
  }
  .el-radio-button:last-child .el-radio-button__inner{
    border-left: 1px solid #dcdfe6 !important;
  }
  .el-button + .el-button{
    margin-left: 0px !important;
  }
</style>
