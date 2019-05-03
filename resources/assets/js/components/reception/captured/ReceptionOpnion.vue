<template>
   <div id="container">
     <vue-editor v-model="content" :editorToolbar="customToolbar"></vue-editor>
   </div>
 </template>
 
 <script>
   import { VueEditor } from 'vue2-editor'
 
   export default {
 
   components: {
      VueEditor
   },
 
   data() {
       return {
         content: '<h1>نظر پزشک</h1>',
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