<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('speciality.cardTitle')}}</h3>
                <div class="card-tools">
						<el-button type="success"
						  size="mini"
						  @click="newModal">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table
					:data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
					style="width: 100%">
					<el-table-column
					  label="Date"
					  prop="date">
					</el-table-column>
					<el-table-column
					  label="Name"
					  prop="name">
					</el-table-column>
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input
						  v-model="search"
						  :placeholder="trans('speciality.searchPlaceholder')"/>
					  </template>
					  <template slot-scope="scope">
						<el-button
						  size="mini"
						  @click="handleEdit(scope.$index, scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"
						  @click="handleDelete(scope.$index, scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
					  </template>
					</el-table-column>
				  </el-table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('speciality.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('speciality.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

				<el-form :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
				  <el-form-item
					:label="trans('speciality.code')"
					prop="code"
					:rules="[
					  { required: true, message: trans('speciality.codeRequierdError')}
					]"
				  >
					<el-input name="code" type="code" v-model.number="form.code" autocomplete="off"></el-input>
				  </el-form-item>
				  <el-form-item
					:label="trans('speciality.description')"
					prop="description"
					:rules="[
					  { required: true, message: trans('speciality.desRequierdError')}
					]"
				  >
					<el-input name="description" type="description" v-model="form.description" autocomplete="off"></el-input>
				  </el-form-item>
				  <el-form-item>
				    <el-button type="success" @click="submitForm('form')" plain>{{trans('app.addBtnLbl')}} </el-button>
					<el-button @click="resetForm('form')">Reset</el-button>
				  </el-form-item>
				</el-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                editMod :false,
                specialitys :{},
                specialityGroups:{},
				form: {
				  code: '',
				  description: '',
				  loadAlert : '',
                    insertAlert : '',
                    updateAlert : '',
                    deleteAlert : '',
                    warningAlert : '',
                    failedAlert : '',
                    noticTxt : '',
                    cancelButtonText : '',
                    confirmButtonText : ''
				},
				tableData: [{
					  date: '2016-05-03',
					  name: 'Tom',
					  address: 'No. 189, Grove St, Los Angeles'
					}, {
					  date: '2016-05-02',
					  name: 'John',
					  address: 'No. 189, Grove St, Los Angeles'
					}, {
					  date: '2016-05-04',
					  name: 'Morgan',
					  address: 'No. 189, Grove St, Los Angeles'
					}, {
					  date: '2016-05-01',
					  name: 'Jessy',
					  address: 'No. 189, Grove St, Los Angeles'
					}],
					search: '',
            }
        },
        methods :{            
            newModal(){
                this.editMod = false,
                 $('#addNew').modal('show');
            },
            editModal(speciality){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(speciality);
            },
            loadspeciality(){
                this.form.failedAlert=trans('speciality.failedAlert');
                axios.get("../api/speciality").then(({data})=>(this.specialitys = data.data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'speciality'});
                    });
                });
            },
			createSpeciality() {
				this.form.insertAlert=trans('speciality.insertAlert');
                let currentObj = this;
				 axios.post('../api/speciality',{code: this.form.code,
                    description: this.form.description}).then(() =>{
                    Fire.$emit('AfterCrud');
                    /*Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'userGroups'});
                    });*/
					this.$notify({
					  title: '',
					  message: this.form.insertAlert,
					  type: 'success'
					});
					this.resetForm('form');
                    $('#addNew').modal('hide');
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            },
            updateSpeciality(){
                this.form.updateAlert=trans('speciality.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/speciality/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    Alert.success(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'speciality'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('speciality.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'speciality'});
                    });
                    this.$Progress.fail();
                })                     
            },
            deleteSpeciality(id){
                this.form.warningAlert = trans('speciality.warningAlert');
                this.form.deleteAlert = trans('speciality.deleteAlert');
                this.form.confirmButtonText = trans('app.confirmButtonText');
                this.form.cancelButtonText = trans('app.cancelButtonText');
                this.form.noticTxt= trans('app.noticTxt')
                /*Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((messcode) => {
                axios.delete('../api/speciality/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'speciality'});
                }).catch(() => {
                    this.form.failedAlert=trans('speciality.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'speciality'});
                    });
                    this.$Progress.fail();
                    })  
                })*/
				this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
				  confirmButtonText: 'OK',
				  cancelButtonText: 'Cancel',
				  type: 'warning'
				}).then(() => {
				  this.$message({
					type: 'success',
					message: 'Delete completed'
				  });
				}).catch(() => {
				  this.$message({
					type: 'info',
					message: 'Delete canceled'
				  });          
				});
            },
            submitForm(formName) {
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				if (this.editMod)
				{
					this.updateSpeciality();
				}
				else
				{
					this.createSpeciality();
				}
			  }
			  else {
				console.log('error submit!!');
				return false;
			  }
			});
		  },
		  resetForm(formName) {
			this.$refs[formName].resetFields();
		  }
        },        
        mounted() {
            this.loadspeciality();
            Fire.$on('AfterCrud',() => {
                this.loadspeciality();
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
</style>
