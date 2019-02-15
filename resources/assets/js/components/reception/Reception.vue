<template>
    <div class="container" @keydown.alt.67="createReception">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('reception.card_title')}}</h3>
                <div class="card-tools">
				<el-button type="success"
                  v-focus
				  size="mini"
				  @click="createReception">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">                
				<el-table
					:data="tableData.filter(data => !search || data.first_name.toLowerCase().includes(search.toLowerCase())|| data.last_name.toLowerCase().includes(search.toLowerCase()))"
                    :default-sort = "{prop: 'first_name', order: 'ascending'}"
					style="width: 100%" @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
					<el-table-column
					  :label="trans('reception.file_number')"
                      sortable
					  prop="file_number">
					</el-table-column>                    
					<el-table-column
					  :label="trans('reception.first_name')"
                      sortable
					  prop="first_name">
					</el-table-column>
					<el-table-column
					  :label="trans('reception.last_name')"
                      sortable
					  prop="last_name">
					</el-table-column>
					<el-table-column
					  :label="trans('reception.mobile_number')"
                      sortable
					  prop="mobile_number">
					</el-table-column>                    
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input
						  v-model="search"
						  :placeholder="trans('app.searchPlaceholder')"/>
                        <el-input first_name="id" type="hidden" v-model.number="form.id" autocomplete="off"></el-input>
					  </template>
					  <template slot-scope="scope" class="float-left">
                        <el-button
                        size="mini"
                        @click="editReception(scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"
						  @click="deleteReception(scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
					  </template>                    
					</el-table-column>
                    <!--<infinite-loading
                    slot="append"
                    @infinite="infiniteHandler"
                    force-use-infinite-wrapper=".el-table__body-wrapper">
                    </infinite-loading>-->
				  </el-table>
                  <div class="block">
                        <el-pagination
                            background
                            layout="prev, pager, next"
                            prev-text="<"
                            next-text=">"
                            :page-size="pagination.per_page"                         
                            :total="pagination.total"
                            @current-change="page"
                            :current-page.sync="page">
                        </el-pagination>             
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
    export default 
    {
        data()
        {
            return{
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText'),
                warningAlert : trans('app.warningAlert'),
                editMod :false,
                receptions :{},
                form: 
                {
                    id: '',
                    first_name: '',
                    last_name: '',
                    structure:'',
				},
				tableData:[],
                search: '',
                page:0,
                pagination:{},
                list: [],
                infiniteId: +new Date(),
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
                axios.get("../api/profile/profiles", {
                    params: {
                    page: this.page,
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
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
            | Load Profile Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Load Profile Info
            |
            */
            loadReception(page){                
                axios.get("../api/profile/profiles",{params:{page:this.page}}).then(({
                    data})=>{(this.tableData = data.data),(this.pagination= data.meta)}).catch(()=>{
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
            | Go To Create Profile Page
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method Load Create profile Component
            |
            */      
            createReception(){
              this.$router.push({ name: 'create_receptions'});
            },
            /*
            |--------------------------------------------------------------------------
            | Go To Edit Profile Page
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method Load Edit profile Component
            |
            */      
            editReception(record){
              this.$router.push({ name: 'edit_receptions', params: { receptionId: record.id } });
            },
            /*
            |--------------------------------------------------------------------------
            | Delete Profile 
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method delete profile info
            |
            */         
            deleteReception(record){
				  this.$confirm(this.noticTxt,this.warningAlert, {
                  confirmButtonText: this.confirmButtonText,
                  cancelButtonText: this.cancelButtonText,
                  type: 'warning',
                  center: true
                }).then((response) => {
                  axios.delete('../api/profile/profiles/'+record.id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                     this.$message({
                        type: 'success',
                        center: true,
                        message: response.data.message
                      });
                }).catch((error) => {
                     this.$message({
                        title: error.response.data.message,
                        type: 'error',
                        center: true,
                        message: error.response.data.errors,
                      }); 
                    }); 
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    center: true,
                    message: this.cancelAlert
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
                //
            });
        }
    }
</script>
<style>

    .el-form-item__error:lang(fa){
        right:0;
        left:auto;
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
    .el-checkbox{
        top:6px;
    }
</style>
