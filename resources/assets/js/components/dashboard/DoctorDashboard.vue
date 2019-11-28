<template>
    <div class="content">
        <chat-message :list="list"></chat-message>
    </div>
</template>

<script>
    import ChatMessage from '../chat/ChatMessage.vue';
    import {errorMessage} from '../../utilities';    
    export default {
         data()
        {
          return{
              list:{}
          }
        },
        methods:{
            loadReceptions(){
                axios.get("../api/receptions/result?sort=-reception_date&filter[status]=captured",{params:{page:this.page}}).then(({
                    data})=>{(this.list = data.data),(this.pagination= data.meta)}).catch(()=>{
                    let msgErr = errorMessage(error.response.data.errors);
                    this.$message({
                      title: '',
                      message: msgErr,
                      center: true,
                      dangerouslyUseHTMLString: true,
                      type: 'error'
                    });               
                });
            }
        },
        created() {
            this.loadReceptions();
        },
        components: {
            'chat-message' : ChatMessage
        }
    }
</script>
