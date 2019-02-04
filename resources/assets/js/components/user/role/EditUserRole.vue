<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.lblUpdateRoleCardTitle')}}</h3>
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
                <el-input name="roleName" type="roleName" v-model.number="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('user.roleDescription')"
                prop="description"
                :rules="[
                  { required: true, message: trans('user.roleDescriptionRequierdError')}
                ]"
                >
                <el-input name="roleDescription" type="roleDescription" v-model="form.description" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item>
                  <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button size="mini" type="info" @click="backToRoleList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
                  id: '',
                  rname: '',
                  description: '',
            
                },
                insertAlert : trans('app.insertAlert'),
                updateAlert : trans('app.updateAlert'),
                deleteAlert : trans('app.deleteAlert'),
                warningAlert : trans('app.warningAlert'),
                failedAlert : trans('app.failedAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText')
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
                axios.get("../api/auth/roles/"+this.form.id).then(({data})=>(this.form = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'edit_user_roles'});                 
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
           
            backToRoleList(){
              this.$router.push({ name: 'user_roles'});
            },
            updateuser(){
            var obj = JSON.stringify(this.form.structure);
            axios.put('../api/auth/roles/'+this.form.id,{name: this.form.name,
              description: this.form.description}).then(response => {
              this.$message({
                type: 'success',
                center: true,
                message:this.updateAlert
              });
              Fire.$emit('AfterCrud');                  
                }).catch((error) => {
                  console.log(error.response.status);
                  this.$message({
                    type: 'error',
                    center: true,
                    message:error.response.data.errors.name
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
</style>
