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
            prop="name"
            :rules="[
              { required: true, message: trans('user.roleNameRequierdError')}
            ]"
            >
            <el-input name="name" type="text" v-model="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('user.roleDescription')"
            prop="description"
            :rules="[
              { required: true, message: trans('user.roleDesRequierdError')}
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
                  v-for="item in permission_options"
                  :key="item.id"
                  :label="item.description"
                  :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-transfer
                filterable
                :filter-method="filterMethod2"
                filter-placeholder="State Abbreviations"
                v-model="value2"
                :data="permission_options">
              </el-transfer>
            </el-form-item>    
            <el-form-item>
              <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button size="mini" type="info" @click="backToUserRoleList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
        const generateData2 = _ => {
        const data = [];
        const states = ['California', 'Illinois', 'Maryland', 'Texas', 'Florida', 'Colorado', 'Connecticut '];
        const initials = ['CA', 'IL', 'MD', 'TX', 'FL', 'CO', 'CT'];
        states.forEach((city, index) => {
          data.push({
            label: city,
            key: index,
            initial: initials[index]
          });
        });
        return data;
      };
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
            },
            permission_options:[],
            value2: [],
              filterMethod2(query, item) {
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
          axios.get("../api/auth/permissions").then(({data})=>(this.permission_options = data.data)).catch(()=>{
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
        | Create User Role Method
        |--------------------------------------------------------------------------
        |
        | This method Add User Role Info To Database
        |
        */
        createUserRole() {
          axios.post('../api/auth/roles',{name: this.form.name,
          description: this.form.description,permissions:this.form.permissions}).then(() =>{
            Fire.$emit('AfterCrud');
            this.$message({
            title: '',
            message: respons.data.message,
            center: true,
            type: 'success'
            });					                    
          })
          .catch(() => {
            this.$message({
              title: error.respons.data.message,
              message: error.respons.data.errors,
              center: true,
              type: 'error'
            });
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Submit Form Method
        |--------------------------------------------------------------------------
        |
        | This method Submit Form
        |
        */                 
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
      mounted() {
        this.loadUserPermission();
        Fire.$on('AfterCrud',() => {
          this.resetForm('form');
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
</style>
