<template>
    <div class="box box-primary text-justify">
        <div class="box-header with-border">
            <h3 class="box-title pt-3">کلیه رویدادها</h3>

            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <tbody>
                    <tr v-for="notify in notification " :key="notify.id">
                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                        <td class="mailbox-star"><a href="#"><i class="fa fa-star yellow"></i></a></td>
                        <td class="mailbox-name"><a href="read-mail.html">دکتر کمال امینی</a></td>
                        <td class="mailbox-subject"><b>با توجه به عکس ارسالی</b> - نیاز به جراحی سریع ریشه دندان دارد...
                        </td>
                        <td class="mailbox-attachment"></td>
                        <td class="mailbox-date">5 دقیقه قبل</td>
                    </tr>               
                </tbody>
            </table>
            <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer pt-3 text-center" >
            <a href="#" @click="loadMore">موارد بیشتر ...</a>
        </div>
    </div>
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
        notification :{}
      }
    },
    created() {
      this.getAllNotification();
    },
    methods: {
        getAllNotification(){
              axios.get("../api/users/me/notify/all").then(({
              data})=>{(this.notification = data.data)}).catch(()=>{
              let msgErr = errorMessage(error.response.data.errors);
              this.$message({
                title: '',
                message: msgErr,
                center: true,
                dangerouslyUseHTMLString: true,
                type: 'error'
              });               
          });
        },
        loadMore(){
            alert('loadMore');
        }
      } 
    }
</script>