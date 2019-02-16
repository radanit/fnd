<template>
    <div class="container" @keydown.esc="backToReceptionList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('reception.update_card_title_lbl')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form label-position="right" :model="form" ref="form" @keyup.enter.native="updateReception" label-width="100px" class="demo-ruleForm mt-3" >
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.reception_date')"
                    prop="reception_date"
                    :rules="[
                      { required: true, message: trans('reception.reception_date_required_error')}
                    ]"
                    >
                    <date-picker :locale="trans('reception.locale')" v-model="form.reception_date" :auto-submit="true" :editable="true"></date-picker>
                   </el-form-item>                    
                  </el-col>
                  <el-col :span="12">
                    <el-form-item 
                    :label="trans('reception.meli_code')"
                    prop="meli_code"
                    :rules="[
                      { required: true,pattern:/^((?!(0))[0-9]{10})$/,message: trans('reception.meli_code_number_error')},
                    ]"
                    >
                    <el-input :minlength="11" :maxlength="11" name="meli_code" ref="meli_code" type="number"  v-model="form.meli_code" autocomplete="off"></el-input>
                    </el-form-item>                    
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.last_name')"
                    prop="last_name"
                    :rules="[
                      { required: true, message: trans('reception.last_name_required_error')}
                    ]"
                    >
                    <el-input  label="right" name="last_name" ref="last_name" type="text" v-model="form.last_name" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.first_name')"
                    prop="first_name"
                    :rules="[
                      { required: true, message: trans('reception.first_name_required_error')}
                    ]"
                    >
                    <el-input  label="right" name="first_name" ref="first_name" type="text"  v-model="form.first_name" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.birth_year')"
                    prop="birth_year"
                    :rules="[
                      { required: true, message: trans('reception.birth_year_required_error')}
                    ]"
                    >
                    <date-picker v-model="form.birth_year" type="year" :auto-submit="true" :editable="true" max="1397"></date-picker>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.mobile_number')"
                    prop="mobile_number"
                    :rules="[
                      { required: true,pattern:/^(\+\d{1,3}[- ]?)?\d{11}$/, message: trans('reception.mobile_number_required_error')}
                    ]"
                    >
                    <el-input  label="right" name="mobile_number" ref="mobile_number" type="text" v-model="form.mobile_number" autocomplete="off"></el-input>
                    </el-form-item>
                  </el-col>                  
                </el-row>
                <el-row :gutter="20">
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.doctor')"
                    prop="doctor_id"
                    :rules="[
                      { required: true, message: trans('reception.doctor_required_error')}
                    ]">
                      <el-select
                        v-model.number="form.doctor_id"
                        filterable
                        default-first-option
                        :placeholder="trans('reception.doctor_choose')">
                        <el-option
                          v-for="p_item in form.doctor_lists"
                          :key="p_item.id"
                          :label="p_item.description"
                          :value="p_item.id">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item
                    :label="trans('reception.gender')"
                    prop="gender"
                    :rules="[
                      { required: true, message: trans('reception.gender_required_error')}
                    ]"
                    >
                    <el-radio-group v-model="form.gender">
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
                    prop="radio_type_id"
                    :rules="[
                      { required: true, message: trans('reception.doctor_required_error')}
                    ]">
                      <el-select
                        v-model.number="form.radio_type_id"
                        filterable
                        default-first-option
                        :placeholder="trans('reception.radio_type_choose')">
                        <el-option
                          v-for="p_item in form.radio_type_lists"
                          :key="p_item.id"
                          :label="p_item.description"
                          :value="p_item.id">
                        </el-option>
                      </el-select>
                    </el-form-item>
                  </el-col>            
                </el-row>                
                <el-row :gutter="20">                                          
                  <el-form-item>
                      <el-button  size="mini" type="success" @click="createReception()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                      <el-button  size="mini" type="primary" @click="createContinueReception()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
                      <el-button size="mini" type="info" @click="backToReceptionList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
                  </el-form-item>
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
    export default {
        data(){
            return{
                updateAlert : trans('profileStructure.updateAlert'),                
                failedAlert : trans('app.failedAlert'),
                form: 
                {
                  id: '',
                  name: '',
                  description: '',
                  structure:'',
            
                },
            }
        },
        methods :{
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
          axios.get("../api/doctors").then(({data})=>(this.form.doctorl_lists = data.data)).catch((error)=>{
            this.$message({
              title: '',
              message: error.response.data.errors,
              center: true,
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
          axios.get("../api/radio_types").then(({data})=>(this.form.radio_type_lists = data.data)).catch((error)=>{
            this.$message({
              title: '',
              message: error.response.data.errors,
              center: true,
              type: 'error'
            });                
          });
        },  
        updateReception(){
        let receptionInfo = {
          meli_code: this.form.meli_code,
          reception_date: this.form.reception_date,
          first_name: this.form.first_name,
          last_name:this.form.last_name,
          mobile_number:this.form.mobile_number,
          birth_year:this.form.birth_year,
          gender:this.form.gender,
          doctor_id:this.doctor_id,
          radio_type_id:this.radio_type_id
        }
        axios.put('../api/receptions/'+this.form.id,receptionInfo).then(response => {
          this.$message({
            type: 'success',
            center: true,
            message:this.updateAlert
          });
          Fire.$emit('AfterCrud');                  
            }).catch((error) => {
              console.log(error.response.status);
              this.$message({
                type: 'error',
                center: true,
                message:error.response.data.errors.name
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
        this.loadDoctorList();
        this.loadRadioTypeList();
        Fire.$on('AfterCrud',() => {
            
        });
    },
    mounted(){
      this.$refs.meli_code.focus();
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
