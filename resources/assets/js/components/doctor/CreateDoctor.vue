<template>
  <div class="container" @keydown.esc="backToUserList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('user.lblAddCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form id="insert_form"  @submit.native.prevent  @keyup.enter.native="createUser" :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('user.username')"
            
            prop="username"
            :rules="[
              { required: true, message: trans('user.usernameRequierdError')}
            ]"
            >
            <el-input name="username"  ref="username"   type="text" v-model="form.username" :placeholder="trans('user.username')" autocomplete="off"></el-input>
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
              { required: true, message: trans('user.passwordRequierdError')},
              { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
            ]"
            >
            <el-input type="password" :placeholder="trans('user.password')" v-model="form.password">
            </el-input>
            </el-form-item>
            <el-form-item :label="trans('user.confirmPassword')" prop="confirmPassword"
            :rules="[
              { required: true, message: trans('user.confirmPasswordRequierdError')},
              { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
            ]"
            >
            <el-input type="password" :placeholder="trans('user.confirmPassword')" v-model="form.confirmPassword">
            </el-input>
            </el-form-item>
            <el-form-item :label="trans('user.status')" prop="status">
            <el-switch
              v-model="form.active"
              active-color='#13ce66'
              inactive-color='#ff4949'
              >
            </el-switch>
            </el-form-item>
            <user-profile :user='form'></user-profile>                                         
            <el-form-item>
              <el-button  size="mini" type="success" @click="createUser()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button  size="mini" type="primary" @click="createContinueUser()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>              
              <el-button size="mini" type="info" @click="backToUserList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
            </el-form-item>
          </el-form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- modal -->
  </div>
</template>
<script>
import {errorMessage} from '../../utilities';
import userProfile from '../user/userProfile';
  export default {
    data(){
      return{
          structure:{},
          model: {},
          lists:{},
          form: 
          {
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
            roles:[],
            role_options: [],
            profile_id:4,            
            profile_options:[],
            active:false
          },
          user:{},
          headerInfo: {
            'Accept': 'application/json'
          },
          formData:'',
      }
  },
  methods :{
    /*
    |--------------------------------------------------------------------------
    | Back to User List
    |--------------------------------------------------------------------------
    |
    | This method go back to User list
    |
    */                      
    backToUserList(){
      this.$router.push({ name: 'doctors'});
    },
    /*
    |--------------------------------------------------------------------------
    | Load Profiles Method
    | Added By e.bagherzadegan
    |--------------------------------------------------------------------------
    |
    | This method Load Profiles Info
    |
    */
    loadProfiles(){      
      axios.get("../api/profiles").then(({data})=>(this.form.profile_options = data.data)).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              title: '',
              message: msgErr,
              center: true,
              type: 'error'
            });              
        });

    },
    loadProfileSructure(){
        axios.get("../api/profiles/4").then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({                      
              message:msgErr,
              center: true,
              type: 'error'
            }); 
        });
         console.log(this.structure);
      },
    /*
    |--------------------------------------------------------------------------
    | Load Roles Method
    | Added By e.bagherzadegan
    |--------------------------------------------------------------------------
    |
    | This method Load Roles Info
    |
    */        
    loadRoles(){
      axios.get("../api/auth/roles").then(({data})=>(this.form.role_options = data.data)).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              title: '',
              message:msgErr,
              center: true,
              type: 'error'
            });
            this.$router.push({name: 'edit_users'});                 
        });
    }, 
    /*
    |--------------------------------------------------------------------------
    | Back to User List
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
    | Create User Method
    |--------------------------------------------------------------------------
    |
    | This method Add User Info To Database
    |
    */
    createUser() {
      this.$refs['form'].validate((valid) => {
      if (valid) 
      {
      var jsonData = {};
      for (var i=0 ;i<this.structure.length;i++)
      {
          var columnName = this.structure[i].name;
          jsonData[columnName] = this.form[this.structure[i].name];
      };
      var roles_id=[];
      this.form.roles.forEach((role, index) => {
        if (role){
          roles_id.push({
          id: role.id,
        });
        }
      });
      this.formData = new FormData( document.getElementById("insert_form") );
      this.formData.append('active',this.form.active);
      this.formData.append('password',this.form.password);
      this.formData.append('password_confirmation',this.form.confirmPassword);
      this.formData.append('profile_id',this.form.profile_id);
     this.formData.append('roles',JSON.stringify(roles_id));
      let newUser ={            
        username: this.form.username,
        email: this.form.email,
        password: this.form.password,
        password_confirmation:  this.form.confirmPassword,
        profile_id: this.form.profile_id,
        roles:  this.form.roles,
        active: this.form.active,
        profile_data :JSON.stringify(jsonData)
      }
      axios.post('../api/users',this.formData).then((response) =>{
      Fire.$emit('AfterCrud');
      this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });
          this.backToUserList();
        })
        .catch((error) => {
          let msgErr = errorMessage(error.response.data.errors);
          this.$message({
            message: msgErr,
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
    | Load RadioType Method
    | Added By e.bagherzadegan
    |--------------------------------------------------------------------------
    |
    | This method Load RadioType Info
    |
    */
    loadList(apiUrl){
        axios.get(apiUrl).then(({data})=>(this.lists = data.data)).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({
              title: '',
              message: msgErr,
              center: true,
              type: 'error'
            });         
        });
    },     
    /*
    |--------------------------------------------------------------------------
    | Create User Method
    |--------------------------------------------------------------------------
    |
    | This method Add User Info To Database
    |
    */
    createContinueUser() {
      this.$refs['form'].validate((valid) => {
      if (valid) 
      {
      var jsonData = {};
      for (var i=0 ;i<this.structure.length;i++)
      {
          var columnName = this.structure[i].name;
          jsonData[columnName] = this.form[this.structure[i].name];
      };
      let newUser ={            
        username: this.form.username,
        email: this.form.email,
        password: this.form.password,
        password_confirmation:  this.form.confirmPassword,
        profile_id: this.form.profile_id,
        roles:  this.form.roles,
        active: this.form.active,
        profile_data :JSON.stringify(jsonData)
      }
      axios.post('../api/users',newUser).then((response) =>{
      Fire.$emit('AfterCrud');
      this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });
          this.resetForm('form');
        })
        .catch((error) => {
          let msgErr = errorMessage(error.response.data.errors);
          this.$message({
            message: msgErr,
            center: true,
            type: 'error'
          });
        });     
      }
      else 
      {
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
      }            
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
      
    },
    mounted(){
      this.$refs.username.focus();
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
</style>
