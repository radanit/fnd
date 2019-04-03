<template>
    <el-form :model="form" @keyup.enter.native="changePassword" ref="form" label-width="130px" class="demo-ruleForm mt-3">
        <el-form-item
        :label="trans('user.currentPassword')"
            prop="current_password"
            :rules="[
              { required: true, message: trans('user.currentPassRequierdError')}
            ]">
            <el-input name="current_password" ref="current_password" type="password" v-model="form.current_password" :placeholder="trans('user.currentPassword')" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item
        :label="trans('user.newPassword')"
            prop="new_password"
            :rules="[
              { required: true, message: trans('user.newPassRequierdError')}
            ]">
            <el-input name="new_password" ref="new_password" type="password" v-model="form.new_password" :placeholder="trans('user.newPassword')" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item
        :label="trans('user.confirmPassword')"
            prop="new_confirm_password"
            :rules="[
              { required: true, message: trans('user.newPassConfirmationRequierdError')}
            ]">
            <el-input name="new_confirm_password" ref="new_confirm_password" type="password" v-model="form.new_confirm_password" :placeholder="trans('user.confirmPassword')" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
        </el-form-item>
    </el-form>
</template>
<style>

</style>
<script>
export default {
    data(){
        return{
            form:{
                current_password:'',
                new_password:'',
                new_confirm_password:''
            },
        }
    },
    methods:{
        /*
        |--------------------------------------------------------------------------
        | Change Password Method
        | Added By e.bagherzadegan        
        |--------------------------------------------------------------------------
        |
        | This method Change User Password
        |
        */              
        changePassword:function(){
            let newPass={
                password : this.form.current_password,
                new_password : this.form.new_password,
                new_password_confirmation : this.form.new_confirm_password
            }
            axios.put('../api/users/me/password',newPass).then(response => {
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
                    this.changePassword();
                    Fire.$emit('AfterCrud');            
                }
                else {
                    return false;
                }
            });
        },
    }
}
</script>
