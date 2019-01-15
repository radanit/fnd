<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background: url('../images/photo1.png') center center;">
                        <h3 class="widget-user-username">مهدی ریاحی منش</h3>
                        <h5 class="widget-user-desc">برنامه نویس</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="images/user.png" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-sm-4">
                            <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-fa">
                            <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">                            
                            <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">{{trans('profile.settingTabTitle')}}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">{{trans('profile.activityTabTitle')}}</a></li>                            
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
                                فعالیتها                            
                            </div>
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">                                        
                                        <div class="col-sm-10">
                                            <input class="form-control" id="inputUserName" :placeholder="trans('profile.userName')" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">                                       
                                        <div class="col-sm-10">
                                            <input class="form-control" id="inputEmail" :placeholder="trans('profile.email')" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-10">
                                            <input class="form-control" id="inputFullName" :placeholder="trans('profile.fullName')" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-10">
                                            <input class="form-control" id="inputPassword" :placeholder="trans('profile.password')" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">                                      
                                        <div class="col-sm-10">
                                            <input class="form-control" id="inputConfirmPassword" :placeholder="trans('profile.confirmPass')" type="text">
                                        </div>
                                    </div>                                    
                                    <div class="form-group">                                        
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputBiography" :placeholder="trans('profile.bio')"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">{{trans('profile.btnSubmitLbl')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style>
.border-fa{
    border-right: 1px solid #dee2e6 !important;
    border-left: 1px solid #dee2e6 !important;
}
</style>
