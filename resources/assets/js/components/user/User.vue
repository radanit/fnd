<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.cardTitle')}}</h3>
                <div class="card-tools">
				<el-button type="success"
				  size="mini"
				  @click="createUsers">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                <el-button type="primary"
                  size="mini"
                  @click="userRole">{{trans('user.roleBtnLbl')}} <i class="fas fa-users"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table
					:data="tableData.filter(data => !search || data.username.toLowerCase().includes(search.toLowerCase())|| data.email.toLowerCase().includes(search.toLowerCase()))"
                    :default-sort = "{prop: 'username', order: 'descending'}"
					style="width: 100%" @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
					<el-table-column
					  :label="trans('user.username')"
                      sortable
					  prop="username">
					</el-table-column>
					<el-table-column
					  :label="trans('user.email')"
                      sortable
					  prop="email">
					</el-table-column>
                    <el-table-column
                        prop="active"
                        :label="trans('user.status')"
                        width="100"
                        :filters="[{ text: 'فعال', value: 1 }, { text: 'غیرفعال', value: 0 }]"
                        :filter-method="filterActive"
                        filter-placement="bottom-end">
                        <template slot-scope="scope">
                            <el-tag
                            :type="scope.row.active === 1 ? 'success' : 'danger'"
                            disable-transitions><span v-if="scope.row.active==1">فعال</span><span v-else>غیرفعال</span></el-tag>
                        </template>
                    </el-table-column>
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input
						  v-model="search"
						  :placeholder="trans('user.searchPlaceholder')"/>
                        <el-input name="id" type="hidden" v-model.number="form.id" autocomplete="off"></el-input>
					  </template>
					  <template slot-scope="scope" class="float-left">
                        <el-button
                        size="mini"
                        @click="editUsers(scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"
						  @click="deleteUsers(scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
					  </template>                    
					</el-table-column>
                    <infinite-loading
                    slot="append"
                    @infinite="infiniteHandler"
                    force-use-infinite-wrapper=".el-table__body-wrapper">
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
        data(){
            return{
                editMod :false,
                users :{},
                userGroups:{},
				form: {
                id: '',
                active:'',
                username: '',
                email: '',
                loadAlert : '',
                deleteAlert : trans('user.deleteAlert'),
                warningAlert : trans('user.warningAlert'),
                failedAlert : trans('app.failedAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText')
				},
				tableData:[],
                search: '',
                page: 1,
                list: [],
                newsType: 'story',
                infiniteId: +new Date(),
            }
        },
        methods :{ 
            infiniteHandler($state) {
                axios.get("../auth/api/users", {
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
            toggleSelection(rows) {
                if (rows) {
                rows.forEach(row => {
                    this.$refs.multipleTable.toggleRowSelection(row);
                });
                } else {
                this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            filterActive(value, row) {
                return row.active === value;
            },
           /*
            * Load Method
            */
            loaduser(){
                axios.get("../auth/api/users").then(({data})=>(this.tableData = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'users'});                 
                });
            },
            /*
            |--------------------------------------------------------------------------
            | Go To Create Profile Page
            |--------------------------------------------------------------------------
            |
            | This method Load Create profile Component
            |
            */      
            createUsers(){
              this.$router.push({ name: 'create_users'});
            },            
            /*
            |--------------------------------------------------------------------------
            | Go To Edit Profile Page
            |--------------------------------------------------------------------------
            |
            | This method Load Edit profile Component
            |
            */      
            editUsers(record){
              this.$router.push({ name: 'edit_users', params: { profileId: record.id } });
            },
            /*
            |--------------------------------------------------------------------------
            | Delete Profile 
            |--------------------------------------------------------------------------
            |
            | This method delete profile info
            |
            */         
            deleteUsers(record){
				    this.$confirm(this.form.warningAlert,this.form.noticTxt, {
                  confirmButtonText: this.form.confirmButtonText,
                  cancelButtonText: this.form.cancelButtonText,
                  type: 'warning',
                  center: true
                }).then(() => {
                  axios.delete('../api/profiles/'+record.id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                     this.$message({
                        type: 'success',
                        center: true,
                        message:this.form.deleteAlert
                      });
                    this.$router.push({name: 'users'});
                }).catch(() => {
                     this.$router.push({name: 'users'});
                    }); 
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    center: true,
                    message: this.form.cancelAlert
                  });          
                });
            },
            /*
            |--------------------------------------------------------------------------
            | Go To Create Profile Page
            |--------------------------------------------------------------------------
            |
            | This method Load Create profile Component
            |
            */      
            userRole(){
              this.$router.push({ name: 'UserRoles'});
            },
        },        
        mounted() {
            this.loaduser();
            Fire.$on('AfterCrud',() => {
                this.loaduser();
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
