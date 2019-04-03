<template>
    <div class="container" @keydown.esc="backToProfileList">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('profileStructure.lblUpdateModal')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" @keyup.enter.native="updateprofileStructure" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('profileStructure.name')"
                prop="name"
                :rules="[
                  { required: true, message: trans('profileStructure.nameRequierdError')}
                ]"
                >
                <el-input name="name" ref="name" type="text" :disabled="true" v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('profileStructure.description')"
                prop="description"
                :rules="[
                  { required: true, message: trans('profileStructure.desRequierdError')}
                ]"
                >
                <el-input name="description" ref="description" type="text" v-model="form.description" autocomplete="off"></el-input>
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
        data()
        {
          return{
            form: 
            {
              id: '',
              name: '',
              description: '',
              structure:{},        
            },
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
            loadProfileStructure(){
                this.form.id=this.$route.params.profileId;
                axios.get("../api/profiles/"+this.form.id).then(({data})=>(this.form = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message:error.response.data.errors,
                      center: true,
                      type: 'error'
                    });                
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
            backToProfileList(){
              this.$router.push({ name: 'profile_structures'});
            },
            /*
            |--------------------------------------------------------------------------
            | Update Profile Method
            |--------------------------------------------------------------------------
            |
            | This method Update Profile Info To Database
            |
            */
            updateprofileStructure(){
            axios.put('../api/profiles/'+this.form.id,{name: this.form.name,
              description: this.form.description,structure:this.form.structure}).then(response => {
              this.$message({
                type: 'success',
                center: true,
                message:response.data.message
              });                
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
            |--------------------------------------------------------------------------
            |
            | This method Submit Form
            |
            */
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  this.updateprofileStructure();
                  this.backToProfileList();
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
            this.loadProfileStructure();            
            Fire.$on('AfterCrud',() => {
                //
            });
        },
        mounted(){
          this.$refs.description.focus();
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
