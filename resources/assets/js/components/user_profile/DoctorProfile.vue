<template>
  <div class="panel-body">
    <el-form  :model="form" @keyup.enter.native="updateDoctorProfile" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
      <el-form-item
      :label="trans('doctor.first_name')"
      prop="first_name"
      :rules="[
        { required: true, message: trans('doctor.first_nameRequierdError')}
      ]"
      >
      <el-input name="first_name" ref="first_name" type="text"  v-model="form.first_name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item
      :label="trans('doctor.last_name')"
      prop="last_name"
      :rules="[
        { required: true, message: trans('doctor.last_nameRequierdError')}
      ]"
      >
      <el-input name="last_name" ref="last_name" type="text" v-model="form.last_name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item
        :label="trans('doctor.speciality')"
        prop="speciality">
        <el-select
          v-model="form.specialities"
          value-key="id"
          filterable
          default-first-option
          :placeholder="trans('doctor.speciality_choose_lbl')">
          <el-option
            v-for="item in speciality_options"
            :key="item.id"
            :label="item.description"
            :value="item">
          </el-option>
        </el-select>
      </el-form-item>
        <el-form-item>
          <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>    
        </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import {errorMessage} from '../../utilities';
  export default 
  {
    props:['user'],
    data(){
        return{
            form: 
            {
              id: this.$parent.user.id,
              first_name: this.$parent.user.roles,
              last_name:  this.$parent.user.email, 
              specialities: [],
            },
            speciality_options:[],
        }
    },
    methods :{
        /*
        |--------------------------------------------------------------------------
        | Load specialities
        | Added by e.bagherzadegan
        |--------------------------------------------------------------------------
        |
        | This method specialities list
        |
        */    
        loadSpeciality(){
          axios.get("../api/bahar/specialities").then(({data})=>(this.speciality_options = data.data)).catch((error)=>{
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
        | Update User Role Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Update User Role Info To Database
        |
        */          
        updateDoctorProfile(){
          let doctorProfileInfo = {
            //name: this.form.name,
            description: this.form.description,
            display_name: this.form.description,
           // specialities:thisspecialities_id
          }          
          axios.put('../api/profile/user/',doctorProfileInfo).then(response => {
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
              this.updateDoctorProfile();
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
        this.loadSpeciality()         
        Fire.$on('AfterCrud',() => {
            //
        });
    },
    mounted(){
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
