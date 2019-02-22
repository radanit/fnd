<template>
  <div class="panel-body">
    <el-form  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
     <vue-form-generator @validated="onValidated" :schema="this.structure.schema" :model="this.structure.model" :options="this.structure.formOptions"></vue-form-generator>
    </el-form>
  </div>
</template>

<script>
import VueFormGenerator from 'vue-form-generator'
import 'vue-form-generator/dist/vfg.css'
export default {
  data () {
    return {
      structure:{},
      model: {},
      schema: {},
      formOptions: {},
      form:{}
    }
  },
  methods: {
    loadProfileSructure(){
        axios.get("../api/profile/profiles/3").then(({data})=>(this.structure = JSON.parse(data.data.structure))).catch((error)=>{
                  this.$message({                      
                    message:error.response.data.errors,
                    center: true,
                    type: 'error'
                  }); 
              });
              console.log(this.schema);
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
  components: {
		"vue-form-generator": VueFormGenerator.component
	}
}
</script>