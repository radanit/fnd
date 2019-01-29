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
						  @click="newModal">{{trans('app.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></el-button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
				<el-table
					:data="tableData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase())|| data.description.toLowerCase().includes(search.toLowerCase()))"
					style="width: 100%">
					<el-table-column
					  :label="trans('user.name')"
					  prop="name">
					</el-table-column>
					<el-table-column
					  :label="trans('user.description')"
					  prop="description">
					</el-table-column>
					<el-table-column class="float-left"
					  align="right">
					  <template slot="header" slot-scope="scope">
						<el-input
						  v-model="search"
						  :placeholder="trans('user.searchPlaceholder')"/>
					  </template>
					  <template slot-scope="scope" class="float-left">
						<el-button
						  size="mini"
						  @click="editModal(scope.$index, scope.row)">{{trans('app.editBtnLbl')}} <i class="fa fa-edit blue"></i></el-button>
						<el-button
						  size="mini"
						  type="danger"
						  @click="deleteuser(scope.row)">{{trans('app.deleteBtnLbl')}} <i class="fa fa-trash red"></i></el-button>
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('user.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('user.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

				<el-form  :model="form" ref="form" label-width="100px" class="demo-ruleForm mt-3" >
				  <el-form-item
					:label="trans('user.name')"
					prop="name"
					:rules="[
					  { required: true, message: trans('user.nameRequierdError')}
					]"
				  >
					<el-input name="name" type="name" v-model.number="form.name" autocomplete="off"></el-input>
				  </el-form-item>
				  <el-form-item
					:label="trans('user.description')"
					prop="description"
					:rules="[
					  { required: true, message: trans('user.desRequierdError')}
					]"
				  >
					<el-input name="description" type="description" v-model="form.description" autocomplete="off"></el-input>
          </el-form-item>
          <!--<el-form-item  v-for="(structure, index) in form.structures"
          :label="trans('user.field')+index"
          prop="structure"                    
          >
          <el-input :placeholder="trans('user.structure.name')" name="structure.name" type="structure.name" v-model="structure.name" autocomplete="off"></el-input>
          <el-select class="select-list" :placeholder="trans('user.structure.type')" v-model="structure.type">
            <el-option :label="trans('user.stringType')" value="string"></el-option>
            <el-option :label="trans('user.numberType')" value="number"></el-option>
          </el-select>                    
        </el-form-item>
        <el-form-item :label="trans('user.structure')"
          prop="structures">
          <el-button  size="mini" @click="addRow" plain>
            <i class="fas fa-plus fa-fw"></i></el-button>
          <el-button  size="mini" @click="deleteRow" plain>
            <i class="fas fa-minus"></i></el-button>
          </el-form-item>-->
          <el-form-item
          :label="trans('user.structure')"
          prop="structure">
            <el-input
              type="textarea"
              :rows="2"
              :placeholder="trans('user.json')"
              v-model="form.structure">
            </el-input>
          </el-form-item>
				  <el-form-item>
				    <el-button  size="mini" type="success" @click="submitForm('form')" plain>{{trans('app.submitBtnLbl')}} <i class="fas fa-check fa-fw"></i></el-button>
					  <el-button size="mini" type="info" data-dismiss="modal" plain>{{trans('app.cancelBtnLbl')}} <i class="fas fa-times"></i> </el-button>
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
                users :{},
                userGroups:{},
				form: {
                name: '',
                description: '',
                structure:'',
                loadAlert : '',
                insertAlert : trans('user.insertAlert'),
                updateAlert : trans('user.updateAlert'),
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
            }
        },
        methods :{            
            newModal(){
                this.editMod = false,                
                $('#addNew').modal('show');
                this.resetForm('form');
            },
            editModal(index, row){
                this.editMod = true,
                $('#addNew').modal('show');
                this.form=row;
            },
            addRow() {
                  this.form.structures.push({
                    name: '',
                    type: ''
                  })
                },
                deleteRow(index) {
                  this.form.structures.splice(index,1)
                },
            /*
            * Load Method
            */
            loaduser(){
                axios.get("../api/profiles").then(({data})=>(this.tableData = data.data)).catch(()=>{
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                    this.$router.push({name: 'user'});                 
                });
            },
			createuser() {
          let currentObj = this;
          var obj = JSON.stringify(this.form.structure);
				  axios.post('../api/profiles',{name: this.form.name,
          description: this.form.description,structure:obj}).then(() =>{
          Fire.$emit('AfterCrud');
					this.$message({
					  title: '',
					  message: this.form.insertAlert,
            center: true,
					  type: 'success'
					});
					this.resetForm('form');
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.$message({
                      title: '',
                      message: this.form.failedAlert,
                      center: true,
                      type: 'error'
                    });
                });
            },
            updateuser(){
                  var obj = JSON.stringify(this.form.structure);
                  axios.put('../api/profiles/'+this.form.id,{name: this.form.name,
                    description: this.form.description,structure:obj}).then(() =>{
                    Fire.$emit('AfterCrud');              
                    this.$router.push({name: 'user'});
                    $('#addNew').modal('hide');
                    this.resetForm('form');
                })
                .catch(() => {    
                  this.$router.push({name: 'user'});             
                })                     
            },
            deleteuser(record){
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
                    this.$router.push({name: 'user'});
                }).catch(() => {
                     this.$router.push({name: 'user'});
                    }); 
                }).catch(() => {
                  this.$message({
                    type: 'info',
                    center: true,
                    message: this.form.cancelAlert
                  });          
                });
            },
            submitForm(formName) {
              this.$refs[formName].validate((valid) => {
                if (valid) 
                {
                  if (this.editMod)
                  {
                    this.updateuser();
                  }
                  else
                  {
                    this.createuser();
                  }
                }
                else {
                  console.log('error submit!!');
                  //return false;
                }
              });
           },
           resetForm(formName) {
            this.$refs[formName].resetFields();
           }
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
</style>
