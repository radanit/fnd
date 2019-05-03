<template>
    <div class="container">
        <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item :title="trans('reception.registered_reception_info')" name="receptionInfo">
                <show-reception></show-reception>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_pictures')" name="receptionPicture">
                <add-pictures></add-pictures>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>
<style>
.el-collapse-item__arrow{
  float:right;
  padding: 15px;
}
.el-collapse-item__header{
  display: block;
  text-align: justify;
}
.el-collapse-item__content{
  text-align: justify;
}
</style>
<script>
import ShowReception from '../ShowReception.vue';
import AddPictures from '../receptionPicture/AddPicture.vue';
  export default {
    data() {
      return {
        activeNames: ['receptionPicture']
      };
    },
    methods: {
      handleChange(val) {
        console.log(val);
      }
    },
    created(){
      
    },
    components: {
        'show-reception' : ShowReception,
        'add-pictures' : AddPictures,
    }
  }
</script>