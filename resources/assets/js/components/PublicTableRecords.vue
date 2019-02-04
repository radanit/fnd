<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('publicTableRecord.cardTitle')}} {{this.$route.params.des}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('publicTableRecord.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>                
                <router-link to="/publictable" class="btn btn-danger pull-left">{{trans('publicTableRecord.backBtnLbl')}} <i class="fas fa-undo fa-fw"></i></router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle" :dir="trans('app.dir')">
                  <tbody>
                  <tr>
                    <th class="text-center">{{trans('publicTableRecord.id')}}</th>
                    <th class="text-center">{{trans('publicTableRecord.code')}}</th>
                    <th class="text-center">{{trans('publicTableRecord.description')}}</th>
                    <th class="text-center">{{trans('publicTableRecord.action')}}</th>
                  </tr>
                  <tr v-for="publicTableRecord in publicTableRecords " :key="publicTableRecord.id">
                    <td class="text-center">{{publicTableRecord.id}}</td>
                    <td class="text-center">{{publicTableRecord.code}}</td>
                    <td class="text-center">{{publicTableRecord.description}}</td>
                    <td class="text-center">
                        <a href="#" @click="editModal(publicTableRecord)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deletePublicTableRecord(publicTableRecord.id)"><i class="fa fa-trash red"></i></a>                
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('publicTableRecord.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('publicTableRecord.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMod? updatePublicTableRecord():createPublicTableRecord()">
                    <input type="hidden" name="publictable_id" v-model="form.publictable_id ">
                    <div class="modal-body">
                        <div class="form-group">                        
                            <input v-model="form.code" type="text" name="code"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('publicTableRecord.code')" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>
                        <div class="form-group">                        
                            <textarea v-model="form.description" type="text" name="description"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('publicTableRecord.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                            </textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>         
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('publicTableRecord.btnClose')}}</button>
                            <button type="submit" v-show="editMod" class="btn btn-success">{{trans('publicTableRecord.btnUpdate')}}</button>
                            <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('publicTableRecord.btnAdd')}}</button>
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
                publicTableRecords :{},
                publicTable_code :this.$route.params.code,                
                form : new Form({
                    publictable_id :this.$route.params.id,
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
            editModal(publicTableRecord){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(publicTableRecord);
            },
            loadPublicTableRecord(){
                this.form.failedAlert=trans('publicTableRecord.failedAlert');
                axios.get("../api/publicTableRecord/"+this.publicTable_code).then(({data})=>(this.publicTableRecords = data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                });
            },
            createPublicTableRecord(){                
                this.$Progress.start();
                this.form.insertAlert=trans('publicTableRecord.insertAlert');
                this.form.post('../api/publicTableRecord').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('publicTableRecord.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updatePublicTableRecord(){
                this.form.updateAlert=trans('publicTableRecord.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/publicTableRecord/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('publicTableRecord.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                    this.$Progress.fail();
                })                     
            },
             deletePublicTableRecord(id){
                this.form.warningAlert = trans('publicTableRecord.warningAlert');
                this.form.deleteAlert = trans('publicTableRecord.deleteAlert');
                this.form.confirmButtonText = trans('publicTableRecord.confirmButtonText');
                this.form.cancelButtonText = trans('publicTableRecord.cancelButtonText');
                this.form.noticTxt= trans('publicTableRecord.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/publicTableRecord/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'publicTableRecords'});
                }).catch(() => {
                    this.form.failedAlert=trans('publicTableRecord.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'publicTableRecords'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
        },        
        mounted() {
            this.loadPublicTableRecord();
            Fire.$on('AfterCrud',() => {
                this.loadPublicTableRecord();
            });
        }
    }
</script>
