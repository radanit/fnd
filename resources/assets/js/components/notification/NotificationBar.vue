<template>
    <ul class="navbar-nav mr-auto">
       <el-header style="text-align: right; font-size: 12px">
          <el-dropdown>
            <i class="el-icon-setting"></i>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>
                <a href="#" @click="editProfile()" id="profile-link" class="lighGray">پروفایل من <i class="fa fa-ellipsis-v mr-1" aria-hidden="true"></i></a>
              </el-dropdown-item>
              <el-dropdown-item>
                <a :title="trans('menus.logout')" :alt="trans('menus.logout')" href="/logout" @click="logout()" id="user-logout" class="lighGray">خروج <i class="fas fa-power-off red" aria-hidden="true"></i></a></el-dropdown-item>
              </el-dropdown-menu>
          </el-dropdown>
       </el-header>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fa fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/media/profile/Mpp5jgadk9wO37iYAgn3fjvx1MSO4OtzrlQJDrZi.jpeg" alt="User Avatar" class="img-size-50 ml-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  test
                  <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">test....</p>
                <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 2 ساعت پیش</p>
              </div>
            </div>
            <!-- Message End -->
          </a>          
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">مشاهده تمام پیغام ها</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" href="#/all_notify" aria-expanded="false">
          <i class="fas fa-bell" v-if="this.eventCnt==0"></i>
          <i class="fa fa-bell faa-ring animated" v-else></i>
          <span class="badge badge-warning navbar-badge">{{this.eventCnt}}</span>
        </a>        
        <!--<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="fas fa-bell" v-if="this.eventCnt==0"></i>
          <i class="fa fa-bell faa-ring animated" v-else></i>
          <span class="badge badge-warning navbar-badge">{{this.eventCnt}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <span class="dropdown-item dropdown-header">{{this.eventCnt}} رویداد جدید</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 0 پیغام جدید دارید
            <span class="float-left text-muted text-sm">3 دقیقه پیش</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 0 درخواست مشورت دارید
            <span class="float-left text-muted text-sm">12 ساعت پیش</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> {{this.receptionCnt}} پرونده بیمار جدید
            <span class="float-left text-muted text-sm">2 روز پیش</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">مشاهده همه ی رویدادها</a>
        </div>-->
      </li>      
    </ul>
</template>
<style>
.el-header{
  padding: 9px 10px !important;
}
</style>

<script>
  export default {
    data() {
      return {
        eventCnt:0,
        user:{}
      }
    },
    created() {
      this.listenForChanges();
      this.getNotify();
    },
    methods: {
      listenForChanges() {        
        Echo.private('bahar.' + window.Laravel.user)
            .notification((notification) => {
            Notification.requestPermission( permission => {
              let notification = new Notification('یک رویداد جدید ثبت گردید', {
                body: '', // content for the alert
                icon: "https://pusher.com/static_logos/320x320.png" // optional image url
              });
              this.eventCnt +=1;
              // link to page on clicking the notification
              notification.onclick = () => {
                window.open(window.location.href);
              };
            });
          })
        },
        editProfile(){
            this.$router.push({ name: 'profiles', params: { profile_id: this.user.profile_id}});
        },
        getNotify(){
              axios.get("../api/users/me/notify").then(({
              data})=>{(this.eventCnt = data.new)}).catch(()=>{
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
      } 
    }
</script>