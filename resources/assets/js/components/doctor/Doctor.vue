<template>
    <div class="container" @keydown.alt.67="createDoctor">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-md"></i> {{trans('doctor.cardTitle')}}</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table 
					:data="list.filter(data => !search || data.first_name.toLowerCase().includes(search.toLowerCase())|| data.last_name.toLowerCase().includes(search.toLowerCase())|| data.speciality_description.toLowerCase().includes(search.toLowerCase()))"
                    :default-sort = "{prop: 'name', order: 'descending'}"
                    :empty-text = "trans('app.no_data_found')"
					style="width: 100%">
					<el-table-column
					  :label="trans('doctor.avatar')"
                      ref="avatar"
                      sortable>
                      <template slot-scope="scope">
                        <span style="margin-left: 10px"><img width="40%" class="img-circle el-icon-plus elevation-2" alt="doctor-img" :src="scope.row.avatar"></span>
                      </template>
					</el-table-column>
                    <el-table-column
					  :label="trans('doctor.first_name')"
                      ref="first_name"
                      sortable
					  prop="first_name">
					</el-table-column>
					<el-table-column
					  :label="trans('doctor.last_name')"
                      sortable
					  prop="last_name">
					</el-table-column>
                    <el-table-column prop="speciality_description" :label="trans('doctor.speciality')" sortable>                        
                    </el-table-column>
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input                          
						  v-model="search"
						  :placeholder="trans('app.searchPlaceholder')" />
                        <el-input name="id" type="hidden" v-model.number="form.id" autocomplete="off"></el-input>
					  </template>
					  <template slot-scope="scope" class="float-left">
                        <el-button
                        size="mini"
                        @click="dialogVisible = true">{{trans('app.showBtnLbl')}} <i class="fas fa-eye"></i></el-button>
					  </template>                    
					</el-table-column>
                    <infinite-loading
                    slot="append"
                    @infinite="infiniteHandler"
                    force-use-infinite-wrapper=".el-table__body-wrapper">
                      <div slot="no-more"></div>
                      <div slot="no-results"></div>                      
                    </infinite-loading>
				  </el-table>
                  <div class="block">
                       <!-- <el-pagination
                            background
                            layout="prev, pager, next"
                            prev-text="<"
                            next-text=">"
                            :page-size="1"
                            :total="10"
                            :data="tableData">
                        </el-pagination>-->              
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['test'],
        data(){
            return{
                warningAlert : trans('app.warningAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText'),
                form: 
                {
                    id: '',
                    active:'',
                    first_name: '',
                    last_name: '',
				},
				tableData:[],
                search: '',
                page: 1,
                list: [],
                infiniteId: +new Date(),
                dialogVisible: false
            }
        },
        methods :{ 
            /*
            |--------------------------------------------------------------------------
            | Lazy Load Method
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method Is For Lazy Load Users Info
            |
            */     
            infiniteHandler($state) {
                axios.get("../api/doctors", {
                    params: {
                    page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.data.length>0) {
                        this.page += 1;
                        this.list.unshift(...data.data.reverse());
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
            /*
            |--------------------------------------------------------------------------
            | handleSelectionChange Method
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method handle Selection User Change
            |
            */              
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            /*
            |--------------------------------------------------------------------------
            | Load Doctor Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Load Doctor Info
            |
            */
            loadDoctors(){
                axios.get("../api/doctors").then(({data})=>(this.list = data.data)).catch((error)=>{
                    this.$message({
                      title: '',
                      message: error.response.data.errors,
                      center: true,
                      type: 'error'
                    });         
                });                
            },
            /*
            |--------------------------------------------------------------------------
            | Delete Doctor
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method delete Doctor info
            |
            */         
            deleteUserDoctors(record){
				  this.$confirm(this.noticTxt,this.warningAlert, {
                  confirmButtonText: this.confirmButtonText,
                  cancelButtonText: this.cancelButtonText,
                  type: 'warning',
                  center: true
                }).then((response) => {
                  axios.delete('../api/doctors/'+record.id)
                .then(response => {
                   this.loadDoctors();
                        this.$message({
                        type: 'success',
                        center: true,
                        message:response.data.message
                      });
                }).catch((error) => {
                        this.$message({
                        type: 'error',
                        center: true,
                        message:error.response.data.errors                        
                      }); 
                    }); 
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    center: true,
                    message: this.form.cancelAlert
                  });          
                });
            },
        },
        directives: {
            focus: {
                // directive definition
                inserted: function (el) {
                el.focus()
                }
            }
        },
        created() {              
            Fire.$on('AfterCrud',() => {
                //this.loadDoctors();
            });
        },
        mounted(){
            console.log(this.test);
        }
    }
</script>
<style>
    .el-form-item__label:lang(fa){
        float:right;
        text-align:left;
        padding:0 0 0 10px;
    }
    .el-form-item__label:lang(en){
        float: left;
        text-align: right;
        padding: 0 10px 0 0;
        white-space: nowrap;
    }    
    .el-form-item__content:lang(fa){
        margin-right:100px;
        margin-left:0px;
    }
    .el-form-item__content:lang(en){
        margin-right:100px;
        margin-left:100px;
    }
    .el-form-item__error:lang(fa){
        right:0;
        left:auto;
    }
    .el-table .cell:lang(fa){
        float: right;
        text-align: right;
        direction: rtl;
    }
    .el-table .cell:lang(en){
        float: left;
        text-align: left;
        direction: ltr;
    }
    .el-popper:lang(en){
        text-align:left;
    }
    .el-popper:lang(fa){
        text-align:right;
    }
    .el-message-box__header:lang(fa)
    {
        direction:rtl;
    }
    .el-pagination{
        text-align: center;
    }
    .el-dialog__headerbtn:lang(fa){
        right: auto;
        left: 20px;
    }
</style>
