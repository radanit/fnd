<template>
    <div class="container">
        <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item :title="trans('reception.registered_reception_info')" name="receptionInfo">
                <show-reception :apiUrl="apiUrl"></show-reception>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_pictures')" name="receptionPictures">
                <view-pictures></view-pictures>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_opinion')" name="receptionOpinion">
                <opinion-reception></opinion-reception>
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
import ViewPictures from '../reception_picture/ViewPicture.vue';
import ReceptionOpnion from './ReceptionOpnion.vue';
  export default {
    data() {
      return {
        activeNames: ['receptionOpinion'],
        apiUrl:"../api/receptions/"+this.$route.params.receptionId+"/result",
      };
    },
    methods: {
      handleChange(val) {
        //console.log(val);
      }
    },
    created(){
      
    },
    components: {
        'show-reception' : ShowReception,
        'view-pictures' : ViewPictures,
        'opinion-reception' : ReceptionOpnion,
    }
  }
</script>