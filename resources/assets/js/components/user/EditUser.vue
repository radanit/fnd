<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.lblUpdateCardTitle')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <el-form  :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('user.username')"
                prop="username"
                :rules="[
                  { required: true, message: trans('user.usernameRequierdError')}
                ]"
                >
                <el-input name="username" type="username" v-model="form.username" :placeholder="trans('user.username')" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('user.email')"
                prop="email"
                :rules="[
                  { required: true, message: trans('user.emailRequierdError')},
                  { type: 'email', message: trans('app.emailFormatError'), trigger: ['blur'] }
                ]"
                >
                <el-input name="email" type="email" 
                v-model="form.email" :placeholder="trans('user.email')" autocomplete="off">
                </el-input>
                </el-form-item>
                <el-form-item :label="trans('user.password')" prop="password"
                :rules="[
                  { required: false, message: trans('user.passwordRequierdError')},
                  { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
                ]"
                >
                <el-input type="password" :placeholder="trans('user.password')" v-model="form.password">
                </el-input>
                </el-form-item>
                <el-form-item :label="trans('user.confirmPassword')" prop="password_confirmation"
                :rules="[
                  { required: false, message: trans('user.confirmPasswordRequierdError')},
                  { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
                ]"
                >
                <el-input type="password" :placeholder="trans('user.confirmPassword')" v-model="form.password_confirmation">
                </el-input>
                </el-form-item>                             
                <el-form-item
                :label="trans('user.roles_lbl')"
                prop="roles">
                  <el-select
                    v-model="form.roles"
                    multiple
                    filterable
                    default-first-option
                    :placeholder="trans('user.role_choose_lbl')">
                    <el-option
                      v-for="item in role_options"
                      :key="item.id"
                      :label="item.description"
                      :value="item.id">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item
                :label="trans('user.profile_lbl')"
                prop="profile_id">
                  <el-select
                    v-model="form.profile_id"
                    filterable
                    default-first-option
                    :placeholder="trans('user.profile_choose_lbl')">
                    <el-option
                      v-for="item in profile_options"
                      :key="item.id"
                      :label="item.description"
                      :value="item.id">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item :label="trans('user.active')" prop="active">
                  <el-switch
                    v-model='form.active'
                    active-color="#13ce66"
                    active-value=1
                    inactive-value=0
                    inactive-color="#ff4949">
                  </el-switch>
                </el-form-item>              
                <el-form-item>
                  <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button size="mini" type="info" @click="backToUserList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
                  id:'',
                  username: '',
                  email: '',
                  password: '',
                  password_confirmation: '',
                  roles:[],                  
                  profile_id:'',
                  profile_data:'',
                  role_options: [],
                  active:'1'
               
                },
                   profile_options:[],
                   role_options: [],
                      
                loadAlert : '',
                insertAlert : trans('app.insertAlert'),
                updateAlert : trans('app.updateAlert'),
                deleteAlert : trans('app.deleteAlert'),
                warningAlert : trans('app.warningAlert'),
                failedAlert : trans('app.failedAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText'),                      
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
            loaduser(){
                this.form.id=this.$route.params.profileId;
                axios.get("../api/profile/users/"+this.form.id).then(({data})=>(this.form = data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: response.data.message,
                      center: true,
                      type: 'error'
                    });              
                });
            },
            loadProfiles(){
              axios.get("../api/profile/profiles").then(({data})=>(this.profile_options = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: response.data.message,
                      center: true,
                      type: 'error'
                    });              
                });
            },
            loadRoles(){
              axios.get("../api/auth/roles").then(({data})=>(this.role_options = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: response.data.message,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'edit_users'});                 
                });
            },            
            /*
            |--------------------------------------------------------------------------
            | Back to Profile List
            |--------------------------------------------------------------------------
            |
            | This method go back to profiles list
            |
            */
           
            backToUserList(){
              this.$router.push({ name: 'users'});
            },
            updateuser(){
            var obj = JSON.stringify(this.form.structure);
            axios.put('../api/profile/users/'+this.form.id,{name: this.form.name,
              description: this.form.description,structure:obj}).then(response => {
              this.$message({
                type: 'success',
                center: true,
                message:this.updateAlert
              });
              Fire.$emit('AfterCrud');                  
                }).catch(() => {
                  this.$message({
                    type: 'error',
                    center: true,
                    message:response.data.message
                  });
              }); 
            },
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  this.updateuser();
                }
                else {
                  return false;
                }
              });
           },
        },      
        mounted() {
            this.loaduser();
            this.loadProfiles();
            this.loadRoles();
            Fire.$on('AfterCrud',() => {
                this.loaduser();
            });
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
.el-select__tags:lang(fa){
  right:15%;
}
.el-select:lang(fa) .el-tag__close.el-icon-close:lang(fa){
  right:0px !important;
}
.el-select-dropdown__item{
  padding: 0 35px !important;
}
</style>
