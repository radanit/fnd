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
                        <router-link :to="{ name: 'publicTableRecords', params: { id:publicTable.id,code:publicTable.code,des:publicTable.description }}"><i class="fa fa-list-alt green"></i></router-link>
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
                <form @submit.prevent="editMod? updatepublicTable():createpublicTable()">
                    <div class="modal-body">
                        <div class="form-group">                        
                            <input v-model="form.code" type="text" name="code"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('publicTable.code')" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>
                        <div class="form-group">                        
                            <textarea v-model="form.description" type="text" name="description"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('publicTable.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                            </textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>         
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('publicTable.btnClose')}}</button>
                            <button type="submit" v-show="editMod" class="btn btn-success">{{trans('publicTable.btnUpdate')}}</button>
                            <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('publicTable.btnAdd')}}</button>
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
                publicTables :{},
                publicTableGroups:{},
                form : new Form({
                    id : '',
                    code : '',
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
            createpublicTable(){                
                this.$Progress.start();
                this.form.insertAlert=trans('publicTable.insertAlert');
                this.form.post('../api/publicTable').then(() =>{
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
            updatepublicTable(){
                this.form.updateAlert=trans('publicTable.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/publicTable/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
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
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
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
                })
            },
            showRecords(id){
                redi
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
