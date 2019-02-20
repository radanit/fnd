<template>
    <div class="container" @keydown.esc="backToDoctorList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('doctor.doctorCardTitle')}}</h3>
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
                prop="speciality"
                :rules="[
                  { required: true, message: trans('doctor.doctorSpecialityRequierdError')}
                ]"
                >
                  <el-select
                    v-model="form.specialities"
                    filterable
                    default-first-option
                    :placeholder="trans('doctor.speciality_choose_lbl')">
                    <el-option
                    v-for="item in form.speciality_options"
                    :key="item.id"
                    :label="item.description"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
                <el-form-item>
                  <el-button  size="mini" type="success" @click="createDoctor()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button  size="mini" type="primary" @click="createContinueDoctor()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
                  <el-button  size="mini" type="info" @click="backToDoctorList" plain>{{trans('app.backBtnLbl')}} </el-button>   
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
              cancelAlert : trans('app.cancelAlert'),
              noticTxt : trans('app.noticTxt'),
              cancelButtonText : trans('app.cancelButtonText'),
              confirmButtonText : trans('app.confirmButtonText'),
              form: 
              {
                first_name: '',
                last_name: '',
                specialities: '',
                speciality_options:[],
              },
          }
      },
      methods :{
          /*
          |--------------------------------------------------------------------------
          | Back to Doctor List
          |--------------------------------------------------------------------------
          |
          | This method go back to Doctor list
          |
          */           
          backToDoctorList(){
            this.$router.push({ name: 'doctors'});
          },
          /*
          |--------------------------------------------------------------------------
          | Create Doctor Method
          |--------------------------------------------------------------------------
          |
          | This method Add Doctor Info To Database
          |
          */
          createDoctor() {
            this.$refs['form'].validate((valid) => {
                if (valid) 
                  {
                    let newDoctor ={
                    name: this.form.name,
                    description: this.form.description,
                    display_name: this.form.description
                  }
                  axios.post('../api/bahar/doctors',newDoctor).then((response) =>{
                  Fire.$emit('AfterCrud');
                  this.$message({
                    title: '',
                    message: response.data.message,
                    center: true,
                    type: 'success'
                  });
                  this.backToDoctorList();			                  
                })
                .catch((error) => {
                    this.$message({
                      title: error.response.data.message,
                      message:error.response.data.errors,
                      center: true,
                      type: 'error'
                    });
                });
              }
              else {
                return false;
              }
            });
            
          },
          /*
          |--------------------------------------------------------------------------
          | Create Doctor Method
          |--------------------------------------------------------------------------
          |
          | This method Add Doctor Info To Database
          |
          */
          createContinueDoctor() {
            this.$refs['form'].validate((valid) => {
              if (valid) 
              {
                let newDoctor ={
                name: this.form.name,
                description: this.form.description,
                display_name: this.form.description
              }
                  axios.post('../api/bahar/doctors',newDoctor).then((response) =>{
                  Fire.$emit('AfterCrud');
                  this.$message({
                    title: '',
                    message: response.data.message,
                    center: true,
                    type: 'success'
                  });
                  this.resetForm('form');
                })
                .catch((error) => {
                    this.$message({
                      title: error.response.data.message,
                      message:error.response.data.errors,
                      center: true,
                      type: 'error'
                    });
                });
              }
              else {
                return false;
              }
            });            
          },
        /*
        |--------------------------------------------------------------------------
        | Reset Form Method
        |--------------------------------------------------------------------------
        |
        | This method Rest Form After Create User Role
        |
        */          
        resetForm(formName) {
          this.$refs[formName].resetFields();
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
      mounted() {
        this.$refs.name.focus();
        Fire.$on('AfterCrud',() => {
          //
        });    
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
