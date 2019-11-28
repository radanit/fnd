<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('reception.card_title')}}</h3>
                <div class="card-tools">
                  <el-steps :space="300" :active="2" process-status="error" >
                    <el-step title="پذیرش"></el-step>
                    <el-step title="تصویربرداری"></el-step>
                    <el-step title="رد"></el-step>                                                   
                  </el-steps>
                  <el-button :type="btnType"
                    size="mini"
                    @click="todayReception">{{todayBtnLbl}} <i :class="btnIcon"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">                
				<el-table
					:data="tableData.filter(data => !search || data.patient.fullname.toLowerCase().includes(search.toLowerCase())|| data.patient.national_id.toLowerCase().includes(search.toLowerCase())|| data.patient.mobile.toLowerCase().includes(search.toLowerCase()))"
          :default-sort = "{prop: 'id', order: 'descending'}"
					style="width: 100%"
          :empty-text = "trans('app.no_data_found')"
          @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
					<el-table-column
					  :label="trans('reception.file_number')"
                      sortable
					  prop="id">
					</el-table-column>
					<el-table-column
					  :label="trans('reception.national_id')"
                      sortable
					  prop="patient.national_id">
					</el-table-column>                             
					<el-table-column
					  :label="trans('reception.fullname')"
                      sortable
					  prop="patient.fullname">
					</el-table-column>
					<el-table-column
					  :label="trans('reception.mobile_number')"
                      sortable
					  prop="patient.mobile">
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
              :title="trans('app.showBtnLbl')"
              size="mini"
              @click="viewReception(scope.row)">{{trans('app.showBtnLbl')}} <i class="fa fa-eye blue"></i></el-button>
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
                            @current-change="loadReception"
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
import {errorMessage} from '../../../utilities';
    export default 
    {
      props: ['currentuser'],
        data()
        {
          return{
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
            showToday:0,
            btnType :'warning',
            btnIcon :'fas fa-calendar fa-fw',
            todayBtnLbl:trans('reception.today_recept_btn_lbl')
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
                axios.get("../api/receptions?filter[status]=rejected&sort=-reception_date", {
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
            loadReception(){                
                axios.get("../api/receptions?filter[status]=rejected&sort=-reception_date",{params:{page:this.page}}).then(({
                    data})=>{(this.tableData = data.data),(this.pagination= data.meta)}).catch(()=>{
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
            /*
            |--------------------------------------------------------------------------
            | Load Today Reception Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Today Reception Info
            |
            */
            todayReception(){
                if (this.showToday==0)
                {
                  this.showToday = 1;
                  this.btnType ='primary';
                  this.btnIcon = 'fas fa-list fa-fw';
                  this.todayBtnLbl =trans('reception.all_recept_btn_lbl');
                  axios.get("../api/receptions?filter[status]=rejected&filter[today]=1&sort=-reception_date",{params:{page:this.page}}).then(({
                      data})=>{(this.tableData = data.data),(this.pagination= data.meta)}).catch(()=>{
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
                else {
                  this.showToday = 0;
                  this.btnType ='warning';
                  this.btnIcon = 'fas fa-calendar fa-fw';
                  this.todayBtnLbl =trans('reception.today_recept_btn_lbl');
                  this.loadReception();
                }                
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
            viewReception(record){
              this.$router.push({ name: 'view_rejected_receptions', params: { receptionId: record.id } });
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
                  axios.delete('../api/receptions/'+record.id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                     this.$message({
                        type: 'success',
                        center: true,
                        message: response.data.message
                      });
                }).catch((error) => {
                  let msgErr = errorMessage(error.response.data.errors);
                     this.$message({
                        title: error.response.data.message,
                        type: 'error',
                        center: true,
                        dangerouslyUseHTMLString: true,
                        message: msgErr,
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
          this.loadReception();
            Fire.$on('AfterCrud',() => {
                //
            });
        }
    }
</script>
<style>
.el-row {
  margin: 0px !important;
}
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
    margin-right:130px!important;
    margin-left:0px;
    text-align: right;
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
  .el-radio-button:last-child .el-radio-button__inner{
    border-radius: 4px 0px 0px 4px !important;
  }
  .el-radio-button:first-child .el-radio-button__inner{
     border-radius: 0px 4px 4px 0px !important;
  }
  .el-radio-button:first-child .el-radio-button__inner{
    border-right: 1px solid #dcdfe6 !important;
  }
  .el-radio-button:last-child .el-radio-button__inner{
    border-left: 1px solid #dcdfe6 !important;
  }
  .el-button + .el-button{
    margin-left: 0px !important;
  }
</style>
