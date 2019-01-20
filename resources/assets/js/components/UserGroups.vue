<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('publicTable.cardTitle')}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('publicTable.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle" :dir="trans('app.dir')">
                  <tbody>
                  <tr>
                    <th class="text-center">{{trans('publicTable.id')}}</th>
                    <th class="text-center">{{trans('publicTable.code')}}</th>
                    <th class="text-center">{{trans('publicTable.description')}}</th>
                    <th class="text-center">{{trans('publicTable.action')}}</th>
                  </tr>
                  <tr v-for="publicTable in publicTables" :key="publicTable.id">
                    <td class="text-center">{{publicTable.id}}</td>
                    <td class="text-center">{{publicTable.code}}</td>
                    <td class="text-center">{{publicTable.description}}</td>
                    <td class="text-center">
                        <a href="#" @click="editModal(publicTable)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deletepublicTable(publicTable.id)"><i class="fa fa-trash red"></i></a>
                        |                        
                        <router-link :to="{ name: 'userGroups', params: { id:publicTable.id,code:publicTable.code,des:publicTable.description }}"><i class="fa fa-list-alt green"></i></router-link>
                    </td>
                  </tr>  
                                
                </tbody></table>
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('publicTable.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('publicTable.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

				<el-form :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
				  <el-form-item
					:label="trans('publicTable.code')"
					prop="code"
					:rules="[
					  { required: true, message: trans('publicTable.codeRequierdError')}
					]"
				  >
					<el-input name="code" type="code" v-model.number="form.code" autocomplete="off"></el-input>
				  </el-form-item>
				  <el-form-item
					:label="trans('publicTable.description')"
					prop="description"
					:rules="[
					  { required: true, message: trans('publicTable.desRequierdError')}
					]"
				  >
					<el-input name="description" type="description" v-model="form.description" autocomplete="off"></el-input>
				  </el-form-item>
				  <el-form-item>
					<el-button type="primary" @click="submitForm('form')">Submit</el-button>
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
                publicTables :{},
                publicTableGroups:{},
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
            }
        },
        methods :{            
            newModal(){
                this.editMod = false,
                //this.form.reset();
                //this.form.clear();
                 $('#addNew').modal('show');
            },
            editModal(publicTable){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(publicTable);
            },
            loadpublicTable(){
                this.form.failedAlert=trans('publicTable.failedAlert');
                axios.get("../api/publicTable").then(({data})=>(this.publicTables = data.data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
                    });
                });
            },
            createpublicTable2(){                
                this.$Progress.start();
                this.form.insertAlert=trans('publicTable.insertAlert');
                axios.post('../api/publicTable').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('publicTable.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
                    });
                    this.$Progress.fail();
                })                                
            },
			createpublicTable() {
				this.$Progress.start();
				this.form.insertAlert=trans('publicTable.insertAlert');
                let currentObj = this;
                /*axios.post('../api/publicTable', {
                    code: this.form.code,
                    description: this.form.description
                })
                .then(function (response) {				   
                   $('#addNew').modal('hide');                    
                })*/
				 axios.post('../api/publicTable',{code: this.form.code,
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
            updatepublicTable(){
                this.form.updateAlert=trans('publicTable.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/publicTable/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    Alert.success(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('publicTable.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
                    });
                    this.$Progress.fail();
                })                     
            },
            deletepublicTable(id){
                this.form.warningAlert = trans('publicTable.warningAlert');
                this.form.deleteAlert = trans('publicTable.deleteAlert');
                this.form.confirmButtonText = trans('app.confirmButtonText');
                this.form.cancelButtonText = trans('app.cancelButtonText');
                this.form.noticTxt= trans('app.noticTxt')
                /*Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((messcode) => {
                axios.delete('../api/publicTable/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'publicTable'});
                }).catch(() => {
                    this.form.failedAlert=trans('publicTable.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTable'});
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
					this.updatepublicTable();
				}
				else
				{
					this.createpublicTable();
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
            this.loadpublicTable();
            Fire.$on('AfterCrud',() => {
                this.loadpublicTable();
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
</style>
