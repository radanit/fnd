<template>
  <div class="container" @keydown.esc="backToRadioTypeList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('radioTypelblUpdateRadioTypeCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form  :model="form" @keyup.enter.native="updateUserRadioType" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('radioTyperadioTypeName')"
            prop="name"
            :rules="[
              { required: true, message: trans('radioTyperadioTypeNameRequierdError')}
            ]"
            >
            <el-input name="name" ref="name" type="text" :disabled="true" v-model.number="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('radioTyperadioTypeDescription')"
            prop="description"
            :rules="[
              { required: true, message: trans('radioTyperadioTypeDescriptionRequierdError')}
            ]"
            >
            <el-input name="description" type="text" ref="description" v-model="form.description" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
              :label="trans('radioType.roles')"
              prop="roles"
              >
                <el-select
                  v-model="form.role"
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
              <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button size="mini" type="info" @click="backToRadioTypeList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
        | Load Selected RadioType Info
        | Added By e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method load RadioType info for edit
        |
        */
        loadUserRadioType(){
          this.form.id=this.$route.params.radioTypeId;
          axios.get("../api/bahar/radioTypes/"+this.form.id).then(({data})=>(this.form = data.data)).catch((error)=>{
              this.$message({
                title: '',
                message:error.response.data.errors,
                center: true,
                type: 'error'
              });
              this.$router.push({name: 'edit_radio_types'});                 
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Back to RadioType List
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method go back to RadioTypes list
        |
        */
        
        backToRadioTypeList(){
          this.$router.push({ name: 'radio_types'});
        },
        /*
        |--------------------------------------------------------------------------
        | Update RadioType Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Update RadioType Info To Database
        |
        */          
        updateUserRadioType(){
          axios.put('../api/bahar/radioTypes/'+this.form.id,{name: this.form.name,
          description: this.form.description}).then(response => {
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
              this.updateUserRadioType();
              this.backToRadioTypeList();
            }
            else {
              return false;
            }
          });
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
        this.loadUserRadioType();
        this.loadRoles();      
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
