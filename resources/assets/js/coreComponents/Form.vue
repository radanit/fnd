<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('form.cardTitle')}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('form.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle" :dir="trans('form.dir')">
                  <tbody>
                  <tr>
                    <th class="text-center">{{trans('form.id')}}</th>
                    <th class="text-center">{{trans('form.code')}}</th>
                    <th class="text-center">{{trans('form.description')}}</th>
                    <th class="text-center">{{trans('form.action')}}</th>
                  </tr>
                  <tr v-for="form in forms" :key="form.id">
                    <td class="text-center">{{form.id}}</td>
                    <td class="text-center">{{form.name}}</td>
                    <td class="text-center">{{form.description}}</td>
                    <td class="text-center">
                        <a href="#" @click="editModal(form)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deleteForm(form.id)"><i class="fa fa-trash red"></i></a>
                        |                        
                        <router-link :to="{ name: 'formFields', params: { id:form.id,name:form.formDes }}"><i class="fa fa-list-alt green"></i></router-link>
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('form.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('form.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMod? updateForm():createForm()">
                    <div class="modal-body">
                        <div class="form-group">                        
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :dir="trans('form.dir')" :placeholder="trans('form.name')" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">                        
                            <textarea v-model="form.description" type="text" name="description"
                                class="form-control" :dir="trans('form.dir')" :placeholder="trans('form.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                            </textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="form-group">                        
                            <input v-model="form.field_name" type="text" name="field_name"
                                class="form-control" :dir="trans('form.dir')" :placeholder="trans('form.fieldName')" :class="{ 'is-invalid': form.errors.has('field_name') }">
                            <has-error :form="form" field="field_name"></has-error>
                        </div>
                        <div class="form-group">                        
                            <input v-model="form.field_label" type="text" name="field_label"
                                class="form-control" :dir="trans('form.dir')" :placeholder="trans('form.fieldLabel')" :class="{ 'is-invalid': form.errors.has('field_label') }">
                            <has-error :form="form" field="field_label"></has-error>
                        </div>                                                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('form.btnClose')}}</button>
                            <button type="submit" v-show="editMod" class="btn btn-success">{{trans('form.btnUpdate')}}</button>
                            <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('form.btnAdd')}}</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Alert} from '../utilities';
    export default {
        data(){
            return{
                editMod :false,
                forms :{},
                formGroups:{},
                form : new Form({
                    id : '',
                    name : '',
                    field_name : [],
                    field_label :{},
                    description :'',
                    loadAlert : '',
                    insertAlert : '',
                    updateAlert : '',
                    deleteAlert : '',
                    warningAlert : '',
                    failedAlert : '',
                    noticTxt : '',
                    cancelButtonText : '',
                    confirmButtonText : ''

                })
            }
        },
        methods :{            
            newModal(){
                this.editMod = false,
                this.form.reset();
                this.form.clear();
                 $('#addNew').modal('show');
            },
            editModal(form){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(form);
            },
            loadForm(){
                this.form.failedAlert=trans('form.failedAlert');
                axios.get("../api/form").then(({data})=>(this.forms = data.data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'form'});
                    });
                });
            },
            createForm(){                
                this.$Progress.start();
                this.form.insertAlert=trans('form.insertAlert');
                this.form.post('../api/form').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'forms'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('form.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'forms'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updateForm(){
                this.form.updateAlert=trans('form.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/form/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'forms'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('form.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'forms'});
                    });
                    this.$Progress.fail();
                })                     
            },
            deleteForm(id){
                this.form.warningAlert = trans('form.warningAlert');
                this.form.deleteAlert = trans('form.deleteAlert');
                this.form.confirmButtonText = trans('app.confirmButtonText');
                this.form.cancelButtonText = trans('app.cancelButtonText');
                this.form.noticTxt= trans('app.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/form/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'forms'});
                }).catch(() => {
                    this.form.failedAlert=trans('form.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'forms'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
            showRecords(id){
                redi
            }
        },        
        mounted() {
            this.loadForm();
            Fire.$on('AfterCrud',() => {
                this.loadForm();
            });
        }
    }
</script>
