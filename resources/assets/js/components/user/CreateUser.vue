<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.lblAddCardTitle')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
	              <el-form  :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
                <el-form-item
                :label="trans('user.username')"
                prop="username"
                :rules="[
                  { required: true, message: trans('user.usernameRequierdError')}
                ]"
                >
                <el-input name="username" type="username" v-model="form.username" :placeholder="trans('user.username')" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item
                :label="trans('user.email')"
                prop="email"
                :rules="[
                  { required: true, message: trans('user.emailRequierdError')},
                  { type: 'email', message: trans('app.emailFormatError'), trigger: ['blur'] }
                ]"
                >
                <el-input name="email" type="email" 
                v-model="form.email" :placeholder="trans('user.email')" autocomplete="off">
                </el-input>
                </el-form-item>
                <el-form-item :label="trans('user.password')" prop="password"
                :rules="[
                  { required: true, message: trans('user.passwordRequierdError')},
                  { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
                ]"
                >
                <el-input type="password" :placeholder="trans('user.password')" v-model="form.password">
                </el-input>
                </el-form-item>
                <el-form-item :label="trans('user.confirmPassword')" prop="confirmPassword"
                :rules="[
                  { required: true, message: trans('user.confirmPasswordRequierdError')},
                  { min: 6, message: trans('app.minPassLengthError'),trigger: ['blur'] }
                ]"
                >
                <el-input type="password" :placeholder="trans('user.confirmPassword')" v-model="form.confirmPassword">
                </el-input>
                </el-form-item>                
                <el-form-item
                :label="trans('user.roles_lbl')"
                prop="roles">
                  <el-select
                    v-model="form.roles"
                    multiple
                    filterable
                    default-first-option
                    :placeholder="trans('user.role_choose_lbl')">
                    <el-option
                      v-for="item in form.role_options"
                      :key="item.id"
                      :label="item.description"
                      :value="item.id">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item
                :label="trans('user.profile_lbl')"
                prop="profile_id">
                  <el-select
                    v-model.number="form.profile_id"
                    filterable
                    default-first-option
                    :placeholder="trans('user.profile_choose_lbl')">
                    <el-option
                      v-for="p_item in form.profile_options"
                      :key="p_item.id"
                      :label="p_item.description"
                      :value="p_item.id">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item :label="trans('user.active')" prop="active">
                <el-switch
                  v-model="form.active"
                  active-color="#13ce66"
                  inactive-color="#ff4949">
                </el-switch>
                </el-form-item>                                     
                <el-form-item>
                  <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
                  <el-button size="mini" type="info" @click="backToUserList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
                </el-form-item>
              </el-form>
              <el-card class="form2">
                <form-schema ref="reform"
                  :schema="schema" v-model="model" @submit.prevent="submit">
                  <el-button type="primary" @click="submit">Subscribe</el-button>
                </form-schema>
              </el-card>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      
    </div>
</template>
<script>
import FormSchema from 'vue-json-schema';
import {
    Form,
    FormItem,
    Input,
    Radio,
    Checkbox,
    Switch,
    Select,
    Option,
    Button
  } from 'element-ui'
FormSchema.setComponent('reform', Form, (vm) => {
    // vm is the FormSchema VM

    const labelWidth = '120px'
    const model = vm.data
    const rules = {}

    vm.fields.forEach((field) => {
      rules[field.name] = {
        required: field.required,
        message: field.title
      }
    })

    return { labelWidth, rules, model }
  })

// Use `FormSchema.setComponent(type, component[, props = {}])` to define custom element to use for rendering.
  FormSchema.setComponent('label', FormItem)
  FormSchema.setComponent('email', Input)
  FormSchema.setComponent('text', Input)
  FormSchema.setComponent('textarea', Input)
  FormSchema.setComponent('checkbox', Checkbox)
  FormSchema.setComponent('checkbox', Switch)
  FormSchema.setComponent('radio', Radio)
  FormSchema.setComponent('select', Select)
  FormSchema.setComponent('option', Option)
    export default {
        data(){
            return{
                schema:{},
                model: {},
                form: 
                {
                  username: '',
                  email: '',
                  password: '',
                  confirmPassword: '',
                  roles:'',
                  role_options: [],
                  profile_id:1,
                  profile_data:'',
                  profile_options:[],
                  active:false
                },
                loadAlert : '',
                insertAlert : trans('app.insertAlert'),
                updateAlert : trans('app.updateAlert'),
                deleteAlert : trans('app.deleteAlert'),
                warningAlert : trans('app.warningAlert'),
                failedAlert : trans('app.failedAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText'),                

            }
        },
        methods :{ 
            submit (e) {
                  // this.model contains the valid data according your JSON Schema.
                  // You can submit your model to the server here
                  console.log(JSON.stringify(this.model))
                },                      
            backToUserList(){
              this.$router.push({ name: 'users'});
            },
            loadProfiles(){
              axios.get("../api/profile/profiles").then(({data})=>(this.form.profile_options = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'edit_users'});                 
                });

            },
            loadProfileStructure(){
              axios.get("../api/profile/profiles/1").then(({data})=>(this.schema =data.data.structure)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });             
                });

            },
            loadRoles(){
              axios.get("../api/auth/roles").then(({data})=>(this.form.role_options = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'edit_users'});                 
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
              this.$router.push({ name: 'users'});
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
              let currentObj = this;
              var obj = JSON.stringify(this.form.structure);
              axios.post('../api/profile/users',{username: this.form.username,
              email: this.form.email,password:this.form.password,password_confirmation:this.form.confirmPassword,profile_id:this.form.profile_id,roles:this.form.roles,active:this.form.active}).then((response) =>{
              Fire.$emit('AfterCrud');
              this.$message({
                        type: 'success',
                        center: true,
                        message:response.data.message
                      });				    
                this.resetForm('form');
                })
                .catch(() => {
                    this.$message({
                      message: response.data.message,
                      center: true,
                      type: 'error'
                    });
                });
            },
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  this.createProfileStructure();
                }
                else {
                  return false;
                }
              });
           },
            resetForm(formName) {
              this.$refs[formName].resetFields();
            }            
        },        
        mounted() {
          this.loadProfiles();
          this.loadRoles();
          this.loadProfileStructure();
           Fire.$on('AfterCrud',() => {
            this.loadProfiles();
            this.loadRoles();
            });
        },
            components: { FormSchema }

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
