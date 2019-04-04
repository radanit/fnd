<template>
  <div class="container" @keydown.esc="backToUserRoleList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('user.lblAddUserRoleCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responseive p-0">
            <el-form @submit.native.prevent  @keyup.enter.native="createUserRole" :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('user.roleName')"
            prop="name"
            :rules="[
              { required: true, message: trans('user.roleNameRequierdError')}
            ]"
            >
            <el-input ref="name" name="name" type="text" v-model="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('user.roleDescription')"
            prop="description"
            :rules="[
              { required: true, message: trans('user.roleDescriptionRequierdError')}
            ]"
            >
            <el-input name="description" type="text" v-model="form.description" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
              :label="trans('user.permission_lbl')"
              prop="permission">
                <el-select
                  v-model="form.permissions"
                  multiple
                  filterable
                  default-first-option
                  :placeholder="trans('user.permission_choose_lbl')">
                  <el-option
                    v-for="item in form.permission_options"
                    :key="item.id"
                    :label="item.description"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item>

                <!--<el-transfer
                  filterable
                  :filter-method="filterMethod"
                  filter-placeholder="State Abbreviations"
                  v-model="value2"
                  :titles="['کلیه سطوح دسترسی','اختصاص یافته']"
                  :props="{
                      key:'name',
                      label: 'description',
                      initial:'name'
                    }"
                  :data="permission_options">
                </el-transfer>-->                  
            </el-form-item>    
            <el-form-item>
              <el-button  size="mini" type="success" @click="createUserRole()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button  size="mini" type="primary" @click="createContinueUserRole()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
              <el-button size="mini" type="info" @click="backToUserRoleList" plain>{{trans('app.backBtnLbl')}} </el-button>   
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
  import {errorMessage} from '../../../utilities';
  export default {
    data(){ 
      return{
            warningAlert : trans('app.warningAlert'),
            failedAlert : trans('app.failedAlert'),
            cancelAlert : trans('app.cancelAlert'),
            noticTxt : trans('app.noticTxt'),
            cancelButtonText : trans('app.cancelButtonText'),
            confirmButtonText : trans('app.confirmButtonText'),
            form: 
            {
              name: '',
              description: '',
              permissions: '',
              permission_options:[],
            },                        
            data2:[],
            value2: [],
            filterMethod(query, item) {
              return item.initial.toLowerCase().indexOf(query.toLowerCase()) > -1;
            }
          };
    },
    methods :{
        /*
        |--------------------------------------------------------------------------
        | Back to User Role List
        |--------------------------------------------------------------------------
        |
        | This method go back to User Role list
        |
        */           
        backToUserRoleList(){
          this.$router.push({ name: 'user_roles'});
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
          axios.get("../api/auth/permissions").then(({data})=>(this.form.permission_options = data.data)).catch((error)=>{
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
        | Create User Role Method
        |--------------------------------------------------------------------------
        |
        | This method Add User Role Info To Database
        |
        */
        createUserRole() {
            this.$refs['form'].validate((valid) => {
            if (valid) 
            {
              let newRole = {
                name: this.form.name,
                description: this.form.description,
                display_name: this.form.description,
                permissions:this.form.permissions
              }
              axios.post('../api/auth/roles',newRole).then((response) =>{
                Fire.$emit('AfterCrud');
                this.$message({
                title: '',
                message: response.data.message,
                center: true,
                type: 'success'
                });
                this.backToUserRoleList();
              })
              .catch((error) => {
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({
                  title: error.response.data.message,
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
        | Create and contine User Role Method
        |--------------------------------------------------------------------------
        |
        | This method Add User Role Info To Database
        |
        */
        createContinueUserRole() {
           this.$refs['form'].validate((valid) => {
            if (valid) 
            {
              let newRole = {
                name: this.form.name,
                description: this.form.description,
                display_name: this.form.description,
                permissions:this.form.permissions
              }
              axios.post('../api/auth/roles',newRole).then((response) =>{
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
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({
                  title: error.response.data.message,
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
        this.loadUserPermission();        
        Fire.$on('AfterCrud',() => {
          //
        });
      },
      mounted(){
        this.$refs.name.focus();
      }
    }
</script>
<style>
.el-form-item__label:lang(fa){
	float:right;
	text-align:left;
	padding:0 0 0 10px;
  white-space: nowrap;
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
