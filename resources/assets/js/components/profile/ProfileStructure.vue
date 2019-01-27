<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('profileStructure.cardTitle')}}</h3>
                <div class="card-tools">
						<el-button type="success"
						  size="mini"
						  @click="">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table
					:data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase())|| data.description.toLowerCase().includes(search.toLowerCase()))"
					style="width: 100%">
					<el-table-column
					  :label="trans('profileStructure.name')"
					  prop="name">
					</el-table-column>
					<el-table-column
					  :label="trans('profileStructure.description')"
					  prop="description">
					</el-table-column>
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input
						  v-model="search"
						  :placeholder="trans('profileStructure.searchPlaceholder')"/>
              <el-input name="id" type="hidden" v-model.number="form.id" autocomplete="off"></el-input>
					  </template>
					  <template slot-scope="scope" class="float-left">
            <el-button
              size="mini"
              @click="editProfileStructure(scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"
						  @click="deleteProfileStructure(scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
					  </template>
					</el-table-column>
				  </el-table>
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
                profileStructures :{},
                profileStructureGroups:{},
				form: {
                id: '',
                name: '',
                description: '',
                structure:'',
                loadAlert : '',
                deleteAlert : trans('profileStructure.deleteAlert'),
                warningAlert : trans('profileStructure.warningAlert'),
                failedAlert : trans('app.failedAlert'),
                cancelAlert : trans('app.cancelAlert'),
                noticTxt : trans('app.noticTxt'),
                cancelButtonText : trans('app.cancelButtonText'),
                confirmButtonText : trans('app.confirmButtonText')
				},
				tableData:[],
					search: '',
            }
        },
        methods :{ 
            /*
            * Load Method
            */
            loadprofileStructure(){
                axios.get("../api/profiles").then(({data})=>(this.tableData = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'profileStructure'});                 
                });
            },
            editProfileStructure(record){
              this.$router.push({ name: 'EditProfileStructure', params: { profileId: record.id } });
            },
            deleteProfileStructure(record){
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
                    this.$router.push({name: 'profileStructure'});
                }).catch(() => {
                     this.$router.push({name: 'profileStructure'});
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
        mounted() {
            this.loadprofileStructure();
            Fire.$on('AfterCrud',() => {
                this.loadprofileStructure();
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
</style>
