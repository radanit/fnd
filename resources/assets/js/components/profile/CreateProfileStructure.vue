<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('profileStructure.lblAddModal')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('profileStructure.name')"
                prop="name"
                :rules="[
                  { required: true, message: trans('profileStructure.nameRequierdError')}
                ]"
                >
                <el-input name="name" type="name" v-model.number="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('profileStructure.description')"
                prop="description"
                :rules="[
                  { required: true, message: trans('profileStructure.desRequierdError')}
                ]"
                >
                <el-input name="description" type="description" v-model="form.description" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('profileStructure.structure')"
                prop="structure">
                  <el-input
                    type="textarea"
                    :rows="2"
                    :placeholder="trans('profileStructure.json')"
                    v-model="form.structure">
                  </el-input>
                </el-form-item>
                <el-form-item>
                  <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button size="mini" type="info" @click="backToProfileList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
    export default {
        data(){
            return{
                form: 
                {
                  name: '',
                  description: '',
                  structure:'',
                  loadAlert : '',
                  insertAlert : trans('profileStructure.insertAlert'),
                  updateAlert : trans('profileStructure.updateAlert'),
                  deleteAlert : trans('profileStructure.deleteAlert'),
                  warningAlert : trans('profileStructure.warningAlert'),
                  failedAlert : trans('app.failedAlert'),
                  cancelAlert : trans('app.cancelAlert'),
                  noticTxt : trans('app.noticTxt'),
                  cancelButtonText : trans('app.cancelButtonText'),
                  confirmButtonText : trans('app.confirmButtonText')
                },
            }
        },
        methods :{
            /*
            |--------------------------------------------------------------------------
            | Back to Profile List
            |--------------------------------------------------------------------------
            |
            | This method go back to profiles list
            |
            */           
            backToProfileList(){
              this.$router.push({ name: 'profile_structures'});
            },
            /*
            |--------------------------------------------------------------------------
            | Create Profile Method
            |--------------------------------------------------------------------------
            |
            | This method Add Profile Info To Database
            |
            */
		    	  createProfileStructure() {
              let currentObj = this;
              var obj = JSON.stringify(this.form.structure);
              axios.post('../api/profiles',{name: this.form.name,
              description: this.form.description,structure:obj}).then(() =>{
              Fire.$emit('AfterCrud');
              this.$message({
                title: '',
                message: this.form.insertAlert,
                center: true,
                type: 'success'
              });					    
                this.resetForm('form');
                })
                .catch((error) => {
                  console.log(error.response.data.errors.name);
                    this.$message({
                      title: '',
                      message: error.response.data.errors,//this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                });
            },
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  this.createProfileStructure();
                }
                else {
                  return false;
                }
              });
           },
            resetForm(formName) {
              this.$refs[formName].resetFields();
            }            
        },        
        mounted() {
          
        }
    }
</script>
<style>
.el-form-item__label:lang(fa){
	float:right;
	text-align:left;
	padding:0 0 0 10px;
}
.el-form-item__content:lang(fa){
	margin-right:100px;
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
