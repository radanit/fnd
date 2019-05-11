<template>
    <div class="content">
        <div class="content-header">
            <div class="container-fluid text-justify">
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
        <section class="content">
            <div class="container-fluid text-justify">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>

                                <p>{{trans('dashboard.totalFileCount')}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>                        
                            <router-link to="/receptions" class="small-box-footer">{{trans('dashboard.view')}} <i class="fa fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px"></sup></h3>
                                <p>{{trans('dashboard.totalActiveDoctorCount')}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>                        
                            <router-link :to="{ name: 'doctors'}" class="small-box-footer">{{trans('dashboard.view')}} <i class="fa fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>{{trans('dashboard.totalTodayFileCount')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <router-link :to="{ name: 'receptions', params: { reception_date: 'today' }}" class="small-box-footer">{{trans('dashboard.view')}} <i class="fa fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>{{trans('dashboard.totalCompleteFileCount')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <router-link :to="{ name: 'receptions', params: { reception_status: 'completed' }}" class="small-box-footer">{{trans('dashboard.view')}} <i class="fa fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
    import {errorMessage} from '../../utilities';    
    export default {
        created() {
            console.log('Component mounted.')
        }
    }
</script>
