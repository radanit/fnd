<template>
    <div class="container" @keydown.esc="backToRadioTypeList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('radioTypeCardTitle')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form @submit.native.prevent @keyup.enter.native="createUserRadioType" :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('radioType.name')"
                prop="name"
                :rules="[
                  { required: true, message: trans('radioType.radioTypeNameRequierdError')}
                ]"
                >
                <el-input ref="name" name="name" type="text" v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('radioType.description')"
                prop="description"
                :rules="[
                  { required: true, message: trans('radioType.radioTypeDescriptionRequierdError')}
                ]"
                >
                <el-input name="description" type="text" v-model="form.description" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                  :label="trans('radioType.roles')"
                  prop="roles"
                  >
                    <el-select
                      v-model.number="form.roles"
                      filterable
                      default-first-option
                      :placeholder="trans('radioType.roles_choose_lbl')">
                      <el-option
                      v-for="item in form.role_options"
                      :key="item.id"
                      :label="item.description"
                      :value="item.id">
                    </el-option>
                  </el-select>
                </el-form-item>                
                <el-form-item>
                  <el-button  size="mini" type="success" @click="createUserRadioType()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button  size="mini" type="primary" @click="createContinueUserRadioType()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
                  <el-button  size="mini" type="info" @click="backToRadioTypeList" plain>{{trans('app.backBtnLbl')}} </el-button>   
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
                roles:'',
                role_options:[],
              },
          }
      },
      methods :{
          /*
          |--------------------------------------------------------------------------
          | Back to RadioType List
          |--------------------------------------------------------------------------
          |
          | This method go back to RadioType list
          |
          */           
          backToRadioTypeList(){
            this.$router.push({ name: 'radio_types'});
          },
          /*
          |--------------------------------------------------------------------------
          | Create RadioType Method
          |--------------------------------------------------------------------------
          |
          | This method Add RadioType Info To Database
          |
          */
          createUserRadioType() {
            this.$refs['form'].validate((valid) => {
                if (valid) 
                  {
                    let newRadioType ={
                    name: this.form.name,
                    description: this.form.description,
                    roles: this.form.roles
                  }
                  axios.post('../api/radiotypes',newRadioType).then((response) =>{
                  Fire.$emit('AfterCrud');
                  this.$message({
                    title: '',
                    message: response.data.message,
                    center: true,
                    type: 'success'
                  });
                  this.backToRadioTypeList();			                  
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
          | Create RadioType Method
          |--------------------------------------------------------------------------
          |
          | This method Add RadioType Info To Database
          |
          */
          createContinueUserRadioType() {
            this.$refs['form'].validate((valid) => {
              if (valid) 
              {
                let newRadioType ={
                name: this.form.name,
                description: this.form.description,
                roles:this.form.roles
              }
                  axios.post('../api/radiotypes',newRadioType).then((response) =>{
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
                this.$message({
                  title: '',
                  message:error.response.data.errors,
                  center: true,
                  type: 'error'
                });             
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
        this.loadRoles();        
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
