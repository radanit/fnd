<template>
  <div class="panel-body">
    <el-form  :model="form" ref="form" label-width="130px" class="demo-ruleForm mt-3" >
      <el-form-item v-for="(item, key, index) in this.structure" :key="item.key"
      :label="trans(item.label)"
            :prop="item.name"
            :rules="[
              { type:item.type,required:item.required, message: trans(item.errorMsg)}
            ]">
        <el-input v-if="item.item=='el-input' " v-model="form[item.name]" :name="item.name" type="text"></el-input>
        <el-select @focus="loadList(item.apiUrl)" v-if="item.item=='el-select' " v-model="form[item.name]" :name="item.name" >
          <el-option
            v-for="option in lists"
            :key="option.id"
            :label="option.description"
            :value="option.id">
          </el-option>
        </el-select>
        <el-upload action="" v-if="item.item=='el-upload' " type="text"><i class="el-icon-plus"></i></el-upload>        
      </el-form-item>
      <el-form-item>
        <el-button size="mini" type="success" @click="submit('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
        <el-button size="mini" type="info" @click="backToUserList" plain>{{trans('app.backBtnLbl')}} <i class="fas fa-undo"></i></el-button>
      </el-form-item>      
    </el-form>    
   
  </div>
</template>

<script>
import {errorMessage} from '../../utilities';
export default 
{
  props:['profile_id'],
  data: function(){
    return {
      
      lists:{},
      structure:{},
      form:{
         profile_id:this.profile_id,
      }
    }
  },
  methods: {
    /*
    |--------------------------------------------------------------------------
    | Back to User List
    |--------------------------------------------------------------------------
    |
    | This method go back to User list
    |
    */                      
    backToUserList(){
      this.$router.push({ name: 'users'});
    },    
    loadProfileSructure(){     
        axios.get("../api/profiles/"+this.form.profile_id).then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
            let msgErr = errorMessage(error.response.data.errors);
            this.$message({                      
              message:msgErr,
              center: true,
              type: 'error'
            }); 
        });
      },
      /*
      |--------------------------------------------------------------------------
      | Load RadioType Method
      | Added By e.bagherzadegan
      |--------------------------------------------------------------------------
      |
      | This method Load RadioType Info
      |
      */
      loadList(apiUrl){
          axios.get(apiUrl).then(({data})=>(this.lists = data.data)).catch((error)=>{
              let msgErr = errorMessage(error.response.data.errors);
              this.$message({
                title: '',
                message: msgErr,
                center: true,
                type: 'error'
              });         
          });
      },     
      onValidated(isValid, errors) {
        //console.log("Validation result: ", isValid, ", Errors:", errors);
      },
      submit(formName){
        this.$refs[formName].validate((valid) => {
          if (valid) {
                  this.$router.push({ name: 'create_users', params: { profileData: this.form } });
          } else {
            console.log('error submit!!');
            return false;
          }
        });
      }
  },
  mounted(){
     alert(this.form.profile_id);
    this.loadProfileSructure(this.$parent.form.profile_id);
  },
}
</script>