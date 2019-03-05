<template>
    <div class="container" @keydown.esc="backToPasswordPolicyList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('passwordPolicy.lblAddModal')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" @submit.native.prevent @keyup.enter.native="createPasswordPolicy"  @keyup.alt.enter.native="createContinuePasswordPolicyStructure" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('passwordPolicy.name')"
                prop="name"
                :rules="[
                  { required: true, message: trans('passwordPolicy.nameRequierdError')}
                ]"
                >
                <el-input name="name" ref="name" type="name" v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.description')"
                prop="description"
                :rules="[
                  { required: true, message: trans('passwordPolicy.desRequierdError')}
                ]"
                >
                <el-input name="description" type="description" v-model="form.description" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.min_length')"
                prop="min_length"
                :rules="[
                  { required: false, message: trans('passwordPolicy.minLengthRequierdError')}
                ]"
                >
                <el-input name="min_length" type="min_length" v-model.number="form.min_length" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.max_length')"
                prop="max_length"
                :rules="[
                  { required: false, message: trans('passwordPolicy.maxLengthRequierdError')}
                ]"
                >
                <el-input name="max_length" type="max_length" v-model.number="form.max_length" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.upper_case')"
                prop="upper_case"
                :rules="[
                  { required: false, message: trans('passwordPolicy.upperCaseRequierdError')}
                ]"
                >
                <el-input name="upper_case" type="upper_case" v-model.number="form.upper_case" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.lower_case')"
                prop="lower_case"
                :rules="[
                  { required: false, message: trans('passwordPolicy.lowerCaseRequierdError')}
                ]"
                >
                <el-input name="lower_case" type="lower_case" v-model.number="form.lower_case" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.digits')"
                prop="digits"
                :rules="[
                  { required: false, message: trans('passwordPolicy.digitRequierdError')}
                ]"
                >
                <el-input name="digits" type="digits" v-model.number="form.digits" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.special_chars')"
                prop="special_chars"
                :rules="[
                  { required: false, message: trans('passwordPolicy.specialCharRequierdError')}
                ]"
                >
                <el-input name="special_chars" type="special_chars" v-model="form.special_chars" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('passwordPolicy.does_not_contain')"
                prop="does_not_contain"
                :rules="[
                  { required: false, message: trans('passwordPolicy.forbiddenStrRequierdError')}
                ]"
                >
                <el-input name="does_not_contain" type="does_not_contain" v-model="form.does_not_contain" autocomplete="off"></el-input>
                </el-form-item>                                                                                                              
                <el-form-item>
                  <el-button  size="mini" type="success" @click="createPasswordPolicy()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button  size="mini" type="primary" @click="createContinuePasswordPolicyStructure()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
                  <el-button size="mini" type="info" @click="backToPasswordPolicyList" plain>{{trans('app.backBtnLbl')}} </el-button>                  
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
            id:'',            
            name: '',
            description: '',
            min_length:'',
            max_length:'',
            upper_case:'',
            lower_case:'',
            digits:'',
            special_chars:'',
            does_not_contain:'',
          },
        }
      },
      methods :{
      /*
      |--------------------------------------------------------------------------
      | Back to PasswordPolicy List
      |--------------------------------------------------------------------------
      |
      | This method go back to profiles list
      |
      */           
      backToPasswordPolicyList(){
        this.$router.push({ name: 'password_policies'});
      },
      /*
      |--------------------------------------------------------------------------
      | Create PasswordPolicy Method
      |--------------------------------------------------------------------------
      |
      | This method Add PasswordPolicy Info To Database
      |
      */
      createPasswordPolicy() {
        this.$refs['form'].validate((valid) => {
            if (valid) 
            {
              let newPasswordPolicy = {
                name: this.form.name,
                description: this.form.description,
                min_length:this.form.min_length,
                max_length:this.form.max_length,
                upper_case:this.form.upper_case,
                lower_case:this.form.lower_case,
                digits:this.form.digits,
                special_chars:this.form.special_chars,
                does_not_contain:this.form.does_not_contain
              }
              axios.post('../api/policies/password',newPasswordPolicy).then((response) =>{
              Fire.$emit('AfterCrud');
              this.$message({
                title:'',
                message:response.data.message,
                center: true,
                type: 'success'
                });
                  this.backToPasswordPolicyList();
                })
                .catch((error) => {
                    this.$message({
                      title: error.response.data.message,
                      message: error.response.data.errors,
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
      | Create and Continue PasswordPolicy Method
      |--------------------------------------------------------------------------
      |
      | This method Add PasswordPolicy Info To Database
      |
      */
      createContinuePasswordPolicyStructure() {
        this.$refs['form'].validate((valid) => {
        if (valid) 
        {
          let newPasswordPolicy = {
            name: this.form.name,
            description: this.form.description,
            min_length:this.form.min_length,
            max_length:this.form.max_length,
            upper_case:this.form.upper_case,
            lower_case:this.form.lower_case,
            digits:this.form.digits,
            special_chars:this.form.special_chars,
            does_not_contain:this.form.does_not_contain
          }
          axios.post('../api/policies/password',newPasswordPolicy).then((response) =>{
          this.$message({
            title:'',
            message:response.data.message,
            center: true,
            type: 'success'
            });
            this.resetForm('form');
            })
            .catch((error) => {
                this.$message({
                  title: error.response.data.message,
                  message: error.response.data.errors,
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
  mounted() 
  {
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
