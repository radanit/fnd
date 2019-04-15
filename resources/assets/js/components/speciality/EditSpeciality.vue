<template>
  <div class="container" @keydown.esc="backToSpecialityList">
    <div class="row justify-content-center mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('speciality.lblUpdateSpecialityCardTitle')}}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <el-form  :model="form" @keyup.enter.native="updateSpeciality" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
            <el-form-item
            :label="trans('speciality.name')"
            prop="name"
            :rules="[
              { required: true, message: trans('speciality.nameRequierdError')}
            ]"
            >
            <el-input name="name" ref="name" type="text" :disabled="true" v-model.number="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item
            :label="trans('speciality.description')"
            prop="description"
            :rules="[
              { required: true, message: trans('speciality.descriptionRequierdError')}
            ]"
            >
            <el-input name="description" type="text" ref="description" v-model="form.description" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
              <el-button size="mini" type="info" @click="backToSpecialityList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
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
import {errorMessage} from '../../utilities';
  export default 
  {
    data(){
        return{
            form: 
            {
              id: '',
              name: '',
              description: '',          
            },
        }
    },
    methods :{
        /*
        |--------------------------------------------------------------------------
        | Load Selected Speciality Info
        | Added By e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method load Speciality info for edit
        |
        */
        loadSpeciality(){
          this.form.id=this.$route.params.radioTypeId;
          axios.get("../api/specialities/"+this.form.id).then(({data})=>(this.form = data.data)).catch((error)=>{
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({
                  title: msgErr,
                  dangerouslyUseHTMLString: true,
                  message: error.response.data.errors,
                  center: true,
                  type: 'error'
                });
              this.$router.push({name: 'edit_specialities'});                 
          });
        },
        /*
        |--------------------------------------------------------------------------
        | Back to Speciality List
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method go back to specialities list
        |
        */
        
        backToSpecialityList(){
          this.$router.push({ name: 'specialities'});
        },
        /*
        |--------------------------------------------------------------------------
        | Update Speciality Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Update Speciality Info To Database
        |
        */          
        updateSpeciality(){
          axios.put('../api/specialities/'+this.form.id,{name: this.form.name,
          description: this.form.description}).then(response => {
          this.$message({
            type: 'success',
            center: true,
            message:response.data.message
          });          
            }).catch((error) => {              
                let msgErr = errorMessage(error.response.data.errors);
                this.$message({
                  title: msgErr,
                  dangerouslyUseHTMLString: true,
                  message: error.response.data.errors,
                  center: true,
                  type: 'error'
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
              this.updateSpeciality();
              this.backToSpecialityList();
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
        this.loadSpeciality();        
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
