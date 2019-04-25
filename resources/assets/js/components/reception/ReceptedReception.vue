<template>
    <div class="container">
        <el-collapse v-model="activeNames" @change="handleChange">
            <el-collapse-item :title="trans('reception.registered_reception_info')" name="receptionInfo">
                <show-reception></show-reception>
            </el-collapse-item>
            <el-collapse-item :title="trans('reception.reception_pictures')" name="2">
                <add-picture v-if=""></add-picture>
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
import ShowReception from './ShowReception.vue';
import AddPicture from '../AddPicture.vue';
  export default {
    data() {
      return {
        activeNames: ['receptionInfo']
      };
    },
    methods: {
      handleChange(val) {
        console.log(val);
      }
    },
    components: {
        'show-reception' : ShowReception,
        'add-picture' : AddPicture,
    }
  }
</script>