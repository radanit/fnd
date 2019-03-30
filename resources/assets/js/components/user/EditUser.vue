<template>
  <div class="container" @keydown.esc="backToUserList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('user.lblUpdateCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form id="update_form"  :model="form" @keyup.enter.native="updateUser" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('user.username')"
            prop="username"
            :rules="[
              { required: true, message: trans('user.usernameRequierdError')}
            ]"
            >
            <el-input name="username" ref="username" type="text" :disabled="true" v-model="form.username" :placeholder="trans('user.username')" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('user.email')"
            prop="email"
            :rules="[
              { required: true, message: trans('user.emailRequierdError')},
              { type: 'email', message: trans('app.emailFormatError'), trigger: ['blur'] }
            ]"
            >
            <el-input name="email" type="email" ref="email"
            v-model="form.email" :placeholder="trans('user.email')" autocomplete="off">
            </el-input>
            </el-form-item>
            <el-form-item :label="trans('user.password')" prop="password"
            :rules="[
              { required: false, message: trans('user.passwordRequierdError')},
              { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
            ]"
            >
            <el-input type="password" name="password" :placeholder="trans('user.password')" v-model="form.password">
            </el-input>
            </el-form-item>
            <el-form-item :label="trans('user.confirmPassword')" prop="password_confirmation"
            :rules="[
              { required: false, message: trans('user.confirmPasswordRequierdError')},
              { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
            ]"
            >
            <el-input type="password" name="password_confirmation" :placeholder="trans('user.confirmPassword')" v-model="form.password_confirmation">
            </el-input>
            </el-form-item>                             
            <el-form-item
             :label="trans('user.roles_lbl')"
             prop="roles">
              <el-select
                v-model="form.roles"
                multiple
                value-key="id"
                filterable
                default-first-option
                :placeholder="trans('user.role_choose_lbl')">
                <el-option
                  v-for="item in role_options"
                  :key="item.id"
                  :label="item.description"
                  :value="item">
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
            <el-form-item :label="trans('user.status')" prop="status">
            <el-switch
              v-model="form.active"
              active-color='#13ce66'         
              inactive-color='#ff4949'
              >
            </el-switch>
            </el-form-item>
            <user-profile :user='user'></user-profile>               
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
import {msg} from '../../utilities';
import userProfile from './userProfile';
  export default {
    data(){
      return{
          structure:{},
          model: {},
          lists:{},
          fileList:[],
          form: 
          {
            id:'',
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
            roles:[],                  
            profile_id:'',
            data:'',
            active:''            
          },
        user:{},
        headerInfo: {
            'Accept': 'application/json'
        },
        formData:'',
        profile_options:[],
        role_options: [],                  
      }
    },
    methods :{
      /*
      |--------------------------------------------------------------------------
      | Load Selected User Info
      | Added By e.bagherzadegan        
      |--------------------------------------------------------------------------
      |
      | This method load Selected User info for edit
      |
      */
      LoadUser(){
          this.form.id=this.$route.params.userId;
          axios.get("../api/profile/users/"+this.form.id).then(({data})=>{(this.form = data),(this.user=data.data)}).catch((error)=>{
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
      | Load User Profiel Info
      | Added By e.bagherzadegan        
      |--------------------------------------------------------------------------
      |
      | This method load User Profiel info for edit
      |
      */      
      loadProfiles(){
        axios.get("../api/profile/profiles").then(({data})=>(this.profile_options = data.data)).catch((error)=>{
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
      | Load User Roles Info
      | Added By e.bagherzadegan        
      |--------------------------------------------------------------------------
      |
      | This method load User Roles info for edit
      |
      */          
      loadRoles(){
        axios.get("../api/auth/roles").then(({data})=>(this.role_options = data.data)).catch((error)=>{
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
      | Back to User List
      | Added By e.bagherzadegan             
      |--------------------------------------------------------------------------
      |
      | This method go back to User list
      |
      */      
      backToUserList(){
        this.$router.push({ name: 'users'});
      },
      /*
      |--------------------------------------------------------------------------
      | Update User Method
      | Added By e.bagherzadegan        
      |--------------------------------------------------------------------------
      |
      | This method Update User Info To Database
      |
      */          
      updateUser(){      
      var roles_id=[];
      this.form.roles.forEach((role, index) => {
        if (role){
          roles_id.push({
          id: role.id,
        });
        }
      });
      var jsonData = {};
      for (var i=0 ;i<this.structure.length;i++)
      {
          var columnName = this.structure[i].name;
          jsonData[columnName] = this.form.data[this.structure[i].name];
      };
      this.formData = new FormData( document.getElementById("update_form") );
      this.formData.append('active',this.form.active);
      this.formData.append('roles',JSON.stringify(roles_id));
      let arr = ['item1', 'item2', 'item3'];
      axios.post('../api/profile/users/'+this.form.id+'?_method=put',this.formData).then(response => {      
          this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });
          this.backToUserList();   
          }).catch((error) => {
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              type: 'error',
              dangerouslyUseHTMLString: true,
              message:msgErr             
            });
        });        
      },
      /*
      |--------------------------------------------------------------------------
      | handleAvatarSuccess
      |--------------------------------------------------------------------------
      |
      | This method handleAvatarSuccess
      |
      */        
      handleAvatarSuccess(res, file) {
        this.user.avatar = URL.createObjectURL(file.raw);
      },
      /*
      |--------------------------------------------------------------------------
      | Validate Avatar Befor Upload
      |--------------------------------------------------------------------------
      |
      | This method Validate Avatar Befor Upload
      |
      */     
      onBeforeUpload(file) {
          const isJPG = file.type === 'image/jpeg';
          const isLt2M = file.size / 1024 / 1024 < 2;
          if (!isJPG) {
              this.$message.error('Avatar picture must be JPG format!');
          }
          if (!isLt2M) {
              this.$message.error('Avatar picture size can not exceed 2MB!');
          }
          return (isJPG & isLt2M);
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
            this.updateUser();
            Fire.$emit('AfterCrud');            
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
      this.LoadUser();
      this.loadProfiles();
      this.loadRoles(); 
    },
    mounted(){    
      this.$refs.email.focus();
    },
    components :{'userProfile':userProfile}
  }
</script>
<style>
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
  .el-message:lang(fa){
    text-align: right;
    direction: rtl;
  }
  .el-message:lang(en){
    text-align: left;
    direction: ltr;
  }
</style>
