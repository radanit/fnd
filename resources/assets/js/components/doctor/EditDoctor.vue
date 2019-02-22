<template>
  <div class="container" @keydown.esc="backToDoctorList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('doctor.lblUpdateDoctorCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form @submit.native.prevent @keyup.enter.native="createDoctor" :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('doctor.first_name')"
            prop="first_name"
            :rules="[
              { required: true, message: trans('doctor.doctorFirtsNameRequierdError')}
            ]"
            >
            <el-input ref="first_name" name="first_name" type="text" v-model="form.first_name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('doctor.last_name')"
            prop="last_name"
            :rules="[
              { required: true, message: trans('doctor.doctorLastNameRequierdError')}
            ]"
            >
            <el-input name="last_name" type="text" v-model="form.last_name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('doctor.speciality')"
            prop="speciality_id"
            :rules="[
              { required: true, message: trans('doctor.doctorSpecialityRequierdError')}
            ]"
            >
              <el-select
                v-model="form.speciality_id"
                filterable
                default-first-option
                :placeholder="trans('doctor.speciality_choose_lbl')">
                <el-option
                v-for="item in speciality_options"
                :key="item.id"
                :label="item.description"
                :value="item.id">
              </el-option>
            </el-select>
            </el-form-item>
              <el-form-item>
              <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button size="mini" type="info" @click="backToDoctorList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button> 
              </el-form-item>
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
  export default 
  {
    data(){
        return{
          form: 
          {
            first_name: '',
            last_name: '',
            speciality_id: '',            
          },
          speciality_options:[],
        }
    },
    methods :{
        /*
        |--------------------------------------------------------------------------
        | Load Selected Doctor Info
        | Added By e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method load Doctor info for edit
        |
        */
        loadDoctor(){
          this.form.id=this.$route.params.doctorId;
          axios.get("../api/bahar/doctors/"+this.form.id).then(({data})=>(this.form = data.data)).catch((error)=>{
              this.$message({
                title: '',
                message:error.response.data.errors,
                center: true,
                type: 'error'
              });
              this.$router.push({name: 'edit_doctors'});                 
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Load specialities
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method specialities list
        |
        */    
        loadSpeciality(){
          axios.get("../api/bahar/specialities").then(({data})=>(this.speciality_options = data.data)).catch((error)=>{
            this.$message({
              title: '',
              message: error.respons.data.errors,
              center: true,
              type: 'error'
            });                
          });
        },           
        /*
        |--------------------------------------------------------------------------
        | Back to Doctor List
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method go back to Doctors list
        |
        */
        
        backToDoctorList(){
          this.$router.push({ name: 'doctors'});
        },
        /*
        |--------------------------------------------------------------------------
        | Update Doctor Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Update Doctor Info To Database
        |
        */          
        updateDoctor(){
          let doctorInfo ={
            first_name: this.form.first_name,
            last_name: this.form.last_name,
            speciality_id: this.form.speciality_id
          }
          axios.put('../api/bahar/doctors/'+this.form.id,doctorInfo).then(response => {
          this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });          
            }).catch((error) => {              
              this.$message({
                title: error.response.data.message,
                type: 'error',
                center: true,
                message:error.response.data.errors
              });
          }); 
        },
        /*
        |--------------------------------------------------------------------------
        | Submit Form Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Submit Form
        |
        */             
        submitForm(formName) {
          this.$refs[formName].validate((valid) => {
            if (valid) 
            {
              this.updateDoctor();
              this.backToDoctorList();
            }
            else {
              return false;
            }
          });
        },
    },
    directives: {
          focus: {
              // directive definition
              inserted: function (el) {
              el.focus()
              }
          }
    },            
    created() {
        this.loadDoctor();
        this.loadSpeciality();
        Fire.$on('AfterCrud',() => {
            //
        });
    },
    mounted(){
      this.$refs.description.focus();
    }
  }
</script>
<style>
.el-form-item__label:lang(fa){
	float:right;
	text-align:left;
	padding:0 0 0 10px;
  white-space: nowrap !important;
}
.el-form-item__label:lang(en){
  float: left;
  text-align: right;
  padding: 0 10px 0 0;
  white-space: nowrap;
}
.el-form-item__content:lang(fa){
	margin-right:160px !important;
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
</style>
