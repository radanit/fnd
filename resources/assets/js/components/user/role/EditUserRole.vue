<template>
  <div class="container" @keydown.esc="backToUseRoleList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('user.lblUpdateUserRoleCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form  :model="form" @keyup.enter.native="updateUserRole" ref="form" label-width="140px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('user.roleName')"
            prop="name"
            :rules="[
              { required: true, message: trans('user.roleNameRequierdError')}
            ]"
            >
            <el-input name="name" ref="name" type="text" :disabled="true" v-model.number="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('user.roleDescription')"
            prop="description"
            :rules="[
              { required: true, message: trans('user.roleDescriptionRequierdError')}
            ]"
            >
            <el-input name="description" ref="description" type="text" v-model="form.description" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
              :label="trans('user.permission_lbl')"
              prop="permission">
              <el-select
                v-model="form.permissions"
                multiple
                value-key="id"
                filterable
                default-first-option
                :placeholder="trans('user.permission_choose_lbl')">
                <el-option
                  v-for="item in permission_options"
                  :key="item.id"
                  :label="item.description"
                  :value="item">
                </el-option>
              </el-select>
            </el-form-item>
              <el-form-item>
                <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                <el-button size="mini" type="info" @click="backToUseRoleList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
              id: '',
              name: '',
              description: '', 
              permissions: [],
            },
            permission_options:[],
        }
    },
    methods :{
        /*
        |--------------------------------------------------------------------------
        | Load Selected User Role Info
        | Added By e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method load User Role info for edit
        |
        */
        loadUserRole(){
          this.form.id=this.$route.params.roleId;
          axios.get("../api/auth/roles/"+this.form.id).then(({data})=>(this.form = data.data)).catch(()=>{
              this.$message({
                title: '',
                message:error.response.data.errors,
                center: true,
                type: 'error'
              });
              this.$router.push({name: 'edit_user_roles'});                 
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Load Permissions
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method Permissions list
        |
        */    
        loadUserPermission(){
          axios.get("../api/auth/permissions").then(({data})=>(this.permission_options = data.data)).catch((error)=>{
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
        | Back to User Role List
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method go back to User Roles list
        |
        */
        
        backToUseRoleList(){
          this.$router.push({ name: 'user_roles'});
        },
        /*
        |--------------------------------------------------------------------------
        | Update User Role Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Update User Role Info To Database
        |
        */          
        updateUserRole(){
          var permissions_id=[];
            this.form.permissions.forEach((permission, index) => {
              if (permission){
                permissions_id.push({
                id: permission.id,
              });
              }
            });
          let userRoleInfo = {
            //name: this.form.name,
            description: this.form.description,
            display_name: this.form.description,
            permissions:permissions_id
          }          
          axios.put('../api/auth/roles/'+this.form.id,userRoleInfo).then(response => {
          this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });
          Fire.$emit('AfterCrud');                  
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
              this.updateUserRole();
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
    mounted() {
        this.loadUserRole();
        this.loadUserPermission()
         this.$refs.description.focus();
        Fire.$on('AfterCrud',() => {
            //this.loadUserRole();
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
