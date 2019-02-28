<template>
  <div class="panel-body">
    <el-input ref="pid" v-model="this.$parent.profile_id" type="text" :value="this.$parent.profile_id"></el-input>
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
        <el-button v-if="item.item=='el-button' "  size="mini" type="success" @click="submit('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
        
      </el-form-item>
    </el-form>    
   
  </div>
</template>

<script>
export default {
  props: ['userInfo'],
  inherit: true,
  data: function(){
    return {
      structure:{},
      form:{},
      profile_id:this.getProfileId(),
    }
  },
  methods: {
    loadProfileSructure(){
        axios.get("../api/profile/profiles/"+this.profile_id).then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
            this.$message({                      
              message:error.response.data.errors,
              center: true,
              type: 'error'
            }); 
        });
      },
      getProfileId(){
        alert(this.$refs.pid.value);
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
              this.$message({
                title: '',
                message: error.response.data.errors,
                center: true,
                type: 'error'
              });         
          });
      },     
      onValidated(isValid, errors) {
        console.log("Validation result: ", isValid, ", Errors:", errors);
      },
      submit(formName){
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!');
          } else {
            console.log('error submit!!');
            return false;
          }
        });
      }
  },
  mounted(){
    this.getProfileId();
    this.loadProfileSructure();
  },
}
</script>