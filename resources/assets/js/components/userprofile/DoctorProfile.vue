<template>
  <div class="panel-body">
    <el-form  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
      <el-form-item v-for="(item, key, index) in this.structure" :key="item.key"
      :label="trans(item.label)"
            prop="name"
            :rules="[
              { type:item.type,required:item.required, message: trans(item.errorMsg)}
            ]">
        <el-input v-if="item.item=='el-input' " type="text" :placeholder="item.name"></el-input>
        <el-select v-if="item.item=='el-select' "  :placeholder="item.name" ></el-select>
        <el-upload action="" v-if="item.item=='el-upload' " type="text" :placeholder="item.name" ><i class="el-icon-plus"></i></el-upload>
        <el-button v-if="item.item=='el-button' "  size="mini" type="success" @click="submit('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
//import VueFormGenerator from 'vue-form-generator'
//import 'vue-form-generator/dist/vfg.css'
export default {
  data () {
    return {
      structure:{},
      form:{}
    }
  },
  methods: {
    loadProfileSructure(){
        axios.get("../api/profile/profiles/3").then(({data})=>(this.structure =JSON.parse(data.data.structure))).catch((error)=>{
                  this.$message({                      
                    message:error.response.data.errors,
                    center: true,
                    type: 'error'
                  }); 
              });
              console.log(this.structure);
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
    this.loadProfileSructure();
  },
}
</script>