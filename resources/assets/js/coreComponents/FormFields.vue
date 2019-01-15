<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('formField.cardTitle')}} {{forms.description}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('formField.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>                
                <router-link to="/forms" class="btn btn-danger pull-left">{{trans('formField.backBtnLbl')}} <i class="fas fa-undo fa-fw"></i></router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle" :dir="trans('formField.dir')">
                  <tbody>
                  <tr>
                    <th class="text-center">{{trans('forms.id')}}</th>
                    <th class="text-center">{{forms.field_label[0]}}</th>
                    <th class="text-center">{{forms.field_label[1]}}</th>
                    <th class="text-center">{{forms.field_label[2]}}</th>
                  </tr>
                  <tr v-for="FormField in FormFields " :key="FormField.id">
                    <td class="text-center">{{FormField.id}}</td>
                    <td class="text-center">{{FormField.fieldName}}</td>
                    <td class="text-center">{{FormField.fieldLbl}}</td>
                    <td class="text-center">
                        <a href="#" @click="editModal(FormField)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deleteFormField(FormField.id)"><i class="fa fa-trash red"></i></a>                
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('formField.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('formField.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMod? updateFormField():createFormField()">
                    <input type="hidden" name="form_id" v-model="form.form_id ">
                    <div class="modal-body">
                        <div class="form-group">                        
                            <input v-model="form.fieldName" type="text" :name="forms.field_name[0]"
                                class="form-control" :dir="trans('formField.dir')" :placeholder="forms.field_label[0]" :class="{ 'is-invalid': form.errors.has('fieldName') }">
                            <has-error :form="form" field="fieldName"></has-error>
                        </div>
                        <div class="form-group">                        
                            <input v-model="form.fieldName" type="text" :name="forms.field_name[1]"
                                class="form-control" :dir="trans('formField.dir')" :placeholder="forms.field_label[1]" :class="{ 'is-invalid': form.errors.has('fieldName') }">
                            <has-error :form="form" field="fieldName"></has-error>
                        </div>
                        <div class="form-group">                        
                            <input v-model="form.fieldName" type="text" :name="forms.field_name[2]"
                                class="form-control" :dir="trans('formField.dir')" :placeholder="forms.field_label[2]" :class="{ 'is-invalid': form.errors.has('fieldName') }">
                            <has-error :form="form" field="fieldName"></has-error>
                        </div>
                        <div class="form-group">  
                            <component :is="form.fieldName"></component>                         
                        </div>                           
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('formField.btnClose')}}</button>
                            <button type="submit" v-show="editMod" class="btn btn-success">{{trans('formField.btnUpdate')}}</button>
                            <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('formField.btnAdd')}}</button>
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
                FormFields :{},
                forms :{},
                fieldTypes :[],
                form : new Form({
                    id : '',
                    date: '',
                    fieldType_id: '',
                    form_id :this.$route.params.id,
                    fieldName : '',
                    fieldLbl :'',
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
            editModal(FormField){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(FormField);
            },
            loadForm(){
                this.form.failedAlert=trans('form.failedAlert');
                axios.get("../api/form/"+this.form.form_id).then(({data})=>(this.forms = data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                })
            },
            loadfieldType(){
                axios.get("../api/publicTableRecord/2").then(({data})=>(this.fieldTypes =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.fail();
                })                  
            },
            createFormField(){                
                this.$Progress.start();
                this.form.insertAlert=trans('formField.insertAlert');
                this.form.post('../api/formField').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('formField.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updateFormField(){
                this.form.updateAlert=trans('formField.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/FormField/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('formField.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.fail();
                })                     
            },
             deleteFormField(id){
                this.form.warningAlert = trans('formField.warningAlert');
                this.form.deleteAlert = trans('formField.deleteAlert');
                this.form.confirmButtonText = trans('formField.confirmButtonText');
                this.form.cancelButtonText = trans('formField.cancelButtonText');
                this.form.noticTxt= trans('formField.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/FormField/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'formFields'});
                }).catch(() => {
                    this.form.failedAlert=trans('formField.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'formFields'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
        },        
        mounted() {
            //this.loadFormField();
            this.loadForm()
            Fire.$on('AfterCrud',() => {
                //this.loadFormField();
            });
        }
    }
</script>
