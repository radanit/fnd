<template>
  <div class="panel-body">
    <el-form  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
      <el-form-item v-for="(item, key, index) in this.structure" :key="item.key">
        <el-input type="text" :placeholder="item"></el-input>
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
      model: {},
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
      submit(){
        alert(2);
      }
  },
  mounted(){
    this.loadProfileSructure();
  },
}
</script>