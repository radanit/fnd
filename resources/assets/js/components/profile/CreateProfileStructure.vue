<template>
    <div class="container" @keydown.esc="backToProfileList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('profileStructure.lblAddModal')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" @submit.native.prevent @keyup.enter.native="createProfileStructure"  @keyup.alt.enter.native="createContinueProfileStructure" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('profileStructure.name')"
                prop="name"
                :rules="[
                  { required: true, message: trans('profileStructure.nameRequierdError')}
                ]"
                >
                <el-input name="name" ref="name" type="name" v-model.number="form.name" autocomplete="off"></el-input>
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
                prop="structure"
                :rules="[
                  { required: true, message: trans('profileStructure.structureRequierdError')}
                ]">
                  <el-input
                    type="textarea"
                    :rows="2"
                    :placeholder="trans('profileStructure.json')"
                    v-model="form.structure">
                  </el-input>
                </el-form-item>
                <el-form-item>
                  <el-button  size="mini" type="success" @click="createProfileStructure()" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button  size="mini" type="primary" @click="createContinueProfileStructure()" plain>{{trans('app.submitContinueBtnLbl')}} <i class="fas fa-check-double"></i></el-button>
                  <el-button size="mini" type="info" @click="backToProfileList" plain>{{trans('app.backBtnLbl')}} </el-button>                  
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
        this.$refs['form'].validate((valid) => {
            if (valid) 
            {
              let newProfile = {
                name: this.form.name,
                description: this.form.description,
                structure:this.form.structure
              }
              axios.post('../api/profile/profiles',newProfile).then((response) =>{
              Fire.$emit('AfterCrud');
              this.$message({
                title:'',
                message:response.data.message,
                center: true,
                type: 'success'
                });
                  this.backToProfileList();
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
      | Create and Continue Profile Method
      |--------------------------------------------------------------------------
      |
      | This method Add Profile Info To Database
      |
      */
      createContinueProfileStructure() {
        this.$refs['form'].validate((valid) => {
        if (valid) 
        {
          let newProfile = {
            name: this.form.name,
            description: this.form.description,
            structure:this.form.structure
          }
          axios.post('../api/profile/profiles',newProfile).then((response) =>{
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
