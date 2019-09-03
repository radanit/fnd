<template>
  <div class="card direct-chat direct-chat-primary">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
      <h3 class="card-title">{{trans('chat.recivedFile')}}</h3>
    </div>
    <div class="card-body" v-for="file in orderdList" :key="file.id">
      <div v-if="trans('app.dir')=='rtl'" class="direct-chat-messages right">
        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-right">رادیولوژی بهار</span>
            <span class="direct-chat-timestamp float-left">{{ file.reception_date | moment("jYYYY/jM/jD") }}</span>
          </div>
          <img src="assets/images/logo.png" alt="message user image" class="direct-chat-img">
          <div class="direct-chat-text">{{trans('chat.fileDes')}}<a href="#" @click="viewReception(file.id)">{{file.id}}</a>{{trans('chat.patientName')}}{{file.patient.fullname}}{{trans('chat.receivedMsg')}}</div>
        </div>
      </div>
      <div v-if="trans('app.dir')=='ltr'" class="direct-chat-messages left">
        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-left">‌Bahar Radiology</span>
            <span class="direct-chat-timestamp float-right">{{ file.reception_date }}</span>
          </div>
          <img src="assets/images/logo.png" alt="message user image" class="direct-chat-img">
          <div class="direct-chat-text">{{trans('chat.fileDes')}}<a href="#" @click="viewReception(file.id)">{{file.id}}</a>{{trans('chat.patientName')}}{{file.patient.fullname}}{{trans('chat.receivedMsg')}}</div>
        </div>
      </div>      
    </div>
  </div>
</template>
<style>
.right .direct-chat-text{
    text-align: justify;
}
.input-group > .input-group-append > .btn:lang(fa), .input-group > .input-group-append > .input-group-text:lang(fa), .input-group > .input-group-prepend:not(:first-child) > .btn:lang(fa), .input-group > .input-group-prepend:not(:first-child) > .input-group-text:lang(fa), .input-group > .input-group-prepend:first-child > .btn:not(:first-child):lang(fa), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child):lang(fa) {

    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;

}
.input-group > .form-control:not(:last-child):lang(fa), .input-group > .custom-select:not(:last-child):lang(fa) {

    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;

}
.input-group > .input-group-append > .btn:lang(en), .input-group > .input-group-append > .input-group-text:lang(en), .input-group > .input-group-prepend:not(:first-child) > .btn:lang(en), .input-group > .input-group-prepend:not(:first-child) > .input-group-text:lang(en), .input-group > .input-group-prepend:first-child > .btn:not(:first-child):lang(en), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child):lang(en) {

    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-left-radius:0;
    border-bottom-left-radius: 0;

}
.input-group> .form-control:not(:last-child):lang(en), .input-group > .custom-select:not(:last-child):lang(en) {

    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;

}
.direct-chat-messages{
  height: auto !important;
}
</style>
<script>
import {errorMessage} from '../../utilities';
export default {
  props: ['list'],
  data(){
    return{

    }
  },
  computed: {
    orderdList: function () {
      return _.orderBy(this.list, ['reception_date'],['desc'])
    }
  },
  methods:{
    /*
    |--------------------------------------------------------------------------
    | Go To Edit Profile Page
    | Added By e.bagherzadegan            
    |--------------------------------------------------------------------------
    |
    | This method Load Edit profile Component
    |
    */      
    viewReception(id){
      this.$router.push({ name: 'view_captured_reception', params: { receptionId: id } });
    },  
  }
};
</script>
