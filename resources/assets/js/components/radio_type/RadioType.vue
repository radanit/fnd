<template>
    <div class="container" @keydown.alt.67="createRadioType">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('radioType.radioTypeCardTitle')}}</h3>
                <div class="card-tools">
				<el-button type="success"
				  size="mini"
                   v-focus
				  @click="createRadioType">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table 
					:data="list.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase())|| data.description.toLowerCase().includes(search.toLowerCase()))"
                    :default-sort = "{prop: 'name', order: 'descending'}"
                    :empty-text = "trans('app.no_data_found')"
					style="width: 100%" @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
                    <el-table-column
                        prop="category"
                        :label="trans('radioType.category')"
                        width="150"
                        :filters="[{ text:trans('radioType.sonography'), value:2 }, { text: trans('radioType.photography'), value:1 }]"
                        :filter-method="filterCategory"
                        filter-placement="bottom-end">
                        <template slot-scope="scope">
                            <el-tag
                            disable-transitions><span v-if="scope.row.category==2">{{trans('radioType.sonography')}}</span><span v-else>{{trans('radioType.photography')}}</span></el-tag>
                        </template>
                    </el-table-column>                    
					<el-table-column
					  :label="trans('radioType.name')"
                      ref="name"
                      sortable
					  prop="name">
					</el-table-column>
					<el-table-column
					  :label="trans('radioType.description')"
                      sortable
					  prop="description">
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
                        @click="editUsers(scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"                        
						  @click="deleteUserRadioTypes(scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
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
                        <el-pagination
                            background
                            layout="prev, pager, next"
                            prev-text="<"
                            next-text=">"
                             :page-size="pagination.per_page"                         
                            :total="pagination.total"
                            @current-change="loadRadioTypes"
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
    export default {
        data(){
            return{
                warningAlert : trans('app.warningAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText'),
                radioTypes :{},
                form: 
                {
                    id: '',
                    name: '',
                    description: '',
                    category:'',
				},
				tableData:[],
                search: '',
                page: 0,
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
                axios.get("../api/radiotypes", {
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
            | Filter Active user Method
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method Filter Active Users
            |
            */  
            filterCategory(value, row) {
                return row.category === value;
            },
            /*            
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
            | Load RadioType Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Load RadioType Info
            |
            */
            loadRadioTypes(){
                axios.get("../api/radiotypes").then(({data})=>(this.list = data.data),(this.pagination= data.meta)).catch((error)=>{
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
            | Go To Create RadioType Page
            | Added By e.bagherzadegan                 
            |--------------------------------------------------------------------------
            |
            | This method Load Create RadioType Component
            |
            */      
            createRadioType(){
              this.$router.push({ name: 'create_radio_types'});
            },
            /*
            |--------------------------------------------------------------------------
            | Go To Edit RadioType Page
            | Added By e.bagherzadegan                 
            |--------------------------------------------------------------------------
            |
            | This method Load Edit RadioType Component
            |
            */      
            editUsers(record){
              this.$router.push({ name: 'edit_radio_types', params: { radioTypeId: record.id } });
            },
            /*
            |--------------------------------------------------------------------------
            | Delete RadioType
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method delete RadioType info
            |
            */         
            deleteUserRadioTypes(record){
				  this.$confirm(this.noticTxt,this.warningAlert, {
                  confirmButtonText: this.confirmButtonText,
                  cancelButtonText: this.cancelButtonText,
                  type: 'warning',
                  center: true
                }).then((response) => {
                  axios.delete('../api/radiotypes/'+record.id)
                .then(response => {
                   this.loadRadioTypes();
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
                //this.loadRadioTypes();
            });
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
</style>
