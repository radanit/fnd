<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.lblUserRoleCardTitle')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('user.roleName')"
                prop="roleName"
                :rules="[
                  { required: true, message: trans('user.roleNameRequierdError')}
                ]"
                >
                <el-input name="roleName" type="roleName" v-model="form.roleName" autocomplete="off"></el-input>
                </el-form-item>
                  <el-form-item
                :label="trans('user.roleDescription')"
                prop="roleDescription"
                :rules="[
                  { required: true, message: trans('user.roleDesRequierdError')}
                ]"
                >
                <el-input name="roleDescription" type="roleDescription" v-model="form.roleDescription" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('user.permission_lbl')"
                prop="permission">
                  <el-select
                    v-model="permissions"
                    multiple
                    filterable
                    default-first-option
                    :placeholder="trans('user.permission_choose_lbl')">
                    <el-option
                      v-for="item in permission_options"
                      :key="item.id"
                      :label="item.description"
                      :value="item.id">
                    </el-option>
                  </el-select>
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
                  roleName: '',
                  roleDescription: '',
                  loadAlert : '',
                  insertAlert : trans('app.insertAlert'),
                  updateAlert : trans('app.updateAlert'),
                  deleteAlert : trans('app.deleteAlert'),
                  warningAlert : trans('app.warningAlert'),
                  failedAlert : trans('app.failedAlert'),
                  cancelAlert : trans('app.cancelAlert'),
                  noticTxt : trans('app.noticTxt'),
                  cancelButtonText : trans('app.cancelButtonText'),
                  confirmButtonText : trans('app.confirmButtonText')
                },
                permissions: '',
                permission_options:[],
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
              this.$router.push({ name: 'user_roles'});
            },
            loadPermission(){
              axios.get("../api/auth/permissions").then(({data})=>(this.permission_options = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });                
                });
            }, 
            /*
            |--------------------------------------------------------------------------
            | Create Profile Method
            |--------------------------------------------------------------------------
            |
            | This method Add Profile Info To Database
            |
            */
		    	  createUserRole() {
              axios.post('../api/auth/roles',{name: this.form.roleName,
              description: this.form.roleDescription}).then(() =>{
              Fire.$emit('AfterCrud');
              this.$message({
                title: '',
                message: this.form.insertAlert,
                center: true,
                type: 'success'
              });					    
                this.resetForm('form');
                })
                .catch(() => {
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                });
            },
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  this.createUserRole();
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
          this.loadPermission();
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
