<template>
    <div class="content">
        <!-- Load User Dashboard -->
        <admin-dashboard v-if="user.profile_name==='default'"></admin-dashboard>
        <doctor-dashboard  v-else-if="user.profile_name==='doctor'"></doctor-dashboard>
        <radioadmin-dashboard  v-else-if="user.profile_name==='radioadmin'"></radioadmin-dashboard>
        <receptor-dashboard  v-else-if="user.profile_name==='receptor'"></receptor-dashboard>
         <!--<chat-message></chat-message>-->
    </div>
</template>

<script>
    import {errorMessage} from '../utilities';
    import AdminDashboard from './dashboard/AdminDashboard.vue';
    import DoctorDashboard from './dashboard/DoctorDashboard.vue';
    import RadioAdminDashboard from './dashboard/RadioAdminDashboard.vue';
    import ReceptorDashboard from './dashboard/ReceptorDashboard.vue';
    import ChatMessage from './chat/ChatMessage.vue';   
    export default {
        data(){
            return{ 
                user:{}
            }
        },
        methods:{
            /*
            |--------------------------------------------------------------------------
            | Load User Info Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Load User Info
            |
            */
            loadUserInfo(){					
                axios.get("../api/users/me").then(({data})=>{(this.user =data.data),(this.profile_id =data.data.profile_id) }).catch((error)=>{
                    let msgErr = errorMessage(error.response.data.errors);
                    this.$message({                      
                        message:msgErr,
                        center: true,
                        type: 'error'
                    });
                });
            },
        },
        created() {
            this.loadUserInfo();
        },        
        components: {
            'admin-dashboard' : AdminDashboard,
            'doctor-dashboard': DoctorDashboard,
            'radioadmin-dashboard' : RadioAdminDashboard,
            'receptor-dashboard' : ReceptorDashboard,
            'chat-message' : ChatMessage
        }
    }
</script>
