<template>
    <div class="container" @keydown.alt.67="createReception">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('reception.card_title')}}</h3>
                <div class="card-tools">
                  <el-steps :space="200" :active="0" finish-status="success">
                    <el-step title="پذیرش"></el-step>
                    <el-step title="تصویربرداری"></el-step>
                    <el-step title="تکمیل"></el-step>                                                   
                  </el-steps>
                  <el-button type="success"
                    v-focus
                    size="mini"
                    @click="createReception">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
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
					  :label="trans('reception.reception_date')"
                      sortable
            :formatter="dateFormat"
					  prop="reception_date">
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
              :title="trans('app.editBtnLbl')"
              size="mini"
              @click="editReception(scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>              
						<el-button
              :title="trans('app.deleteBtnLbl')"
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
import {errorMessage} from '../../utilities';
    export default 
    {
      props: ['currentuser'],
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
            showToday:0,
            btnType :'warning',
            btnIcon :'fas fa-calendar fa-fw',
            todayBtnLbl:trans('reception.today_recept_btn_lbl')
          }
        },
        methods :{
            /*
            |--------------------------------------------------------------------------
            | Persian Date Format
            | Added By e.bagherzadegan            
            |--------------------------------------------------------------------------
            |
            | This method Is Persian Date Format
            |
            */   
            dateFormat(row, column) {  
              var date = row[column.property];  
              if (date == undefined) {  
                return "";  
              }                    
              return Vue.moment(date).locale('fa').format('jYYYY/jM/jD');
            }, 
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
                axios.get("../api/receptions?filter[status]=recepted&sort=-reception_date", {
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
                axios.get("../api/receptions?filter[status]=recepted&sort=-reception_date",{params:{page:this.page}}).then(({
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
            | Load Today Receptions Method
            | Added By e.bagherzadegan
            |--------------------------------------------------------------------------
            |
            | This method Load Today Receptions Info
            |
            */
            todayReception(){
              if (this.showToday==0)
              {
                this.showToday = 1;
                this.btnType ='primary';
                this.btnIcon = 'fas fa-list fa-fw';
                this.todayBtnLbl =trans('reception.all_recept_btn_lbl');
                axios.get("../api/receptions?filter[status]=recepted&filter[today]=1&sort=-reception_date",{params:{page:this.page}}).then(({
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
              this.$router.push({ name: 'view_receptions', params: { receptionId: record.id } });
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
                this.loadReception();
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
  .el-steps{
    width: 425px !important;
  }
</style>
