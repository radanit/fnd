<template>
    <div class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark text-justify">{{trans('dashboard.cardTitle')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Load User Dashboard -->
        <admin-dashboard v-if="user.profile_name==='default'"></admin-dashboard>
        <doctor-dashboard  v-else-if="user.profile_name==='doctor'"></doctor-dashboard>
        <radioadmin-dashboard  v-else-if="user.profile_name==='radioadmin'"></radioadmin-dashboard>
        <receptor-dashboard  v-else-if="user.profile_name==='receptor'"></receptor-dashboard>
    </div>
</template>

<script>
    import {errorMessage} from '../utilities';
    import AdminDashboard from './dashboard/AdminDashboard.vue';
    import DoctorDashboard from './dashboard/DoctorDashboard.vue';
    import RadioAdminDashboard from './dashboard/RadioAdminDashboard.vue';
    import ReceptorDashboard from './dashboard/ReceptorDashboard.vue';   
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
            'receptor-dashboard' : ReceptorDashboard
        }
    }
</script>
