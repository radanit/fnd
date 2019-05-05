<template>
   <div id="container">
     <el-form>
       <el-form-item>
         <vue-editor v-model="result" :editorToolbar="customToolbar"></vue-editor>
       </el-form-item>        
        <el-form-item :label="trans('app.graphy_rate')">
          <el-rate
              v-model="rate"
              :colors="colors">
            </el-rate>
        </el-form-item>
     </el-form>

   </div>
   
 </template>
 <style>
 .ql-snow .ql-picker-label{
     padding-right: 15px !important;
 }
 .ql-container{
   font-family: Vazir, Tahoma, sans-serif !important;
 }
 </style>
 
 <script>
   import { VueEditor } from 'vue2-editor'
 
   export default {
 
   components: {
      VueEditor
   },
 
   data() {
       return {
         rate:null,
         colors: ['#99A9BF', '#F7BA2A', '#FF9900'], // same as { 2: '#99A9BF', 4: { value: '#F7BA2A', excluded: true }, 5: '#FF9900' }
         result: '',
         customToolbar: [
            [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline','strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': 'center'}, { 'align': 'justify' },{ 'align': 'right'},{ 'align': '' }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'direction': 'rtl' }],
          ] 
       }
     }
   }
 </script> 