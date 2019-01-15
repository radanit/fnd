<template>
    <div class="card  mt-4">
        <div class="card-header">
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link active show" href="#tab_1" data-toggle="tab">{{trans('pmActivity.actTabTitle')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">{{trans('pmSparePart.sparepartTabTitle')}}</a></li>
            </ul>             
        </div><!-- /.card-header -->
        <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active show" id="tab_1">
                <div class="container">
                    <div class="row justify-content-center mt-4">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{trans('pmActivity.cardActTitle')}} {{this.$route.params.name}}</h3>
                            <div class="card-tools">
                            <button class="btn btn-success pull-left" @click="newModal('addNewAct')">{{trans('pmActivity.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>                
                            <router-link to="/preventiveService" class="btn btn-danger pull-left">{{trans('pmActivity.backBtnLbl')}} <i class="fas fa-undo fa-fw"></i></router-link>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover align-middle" :dir="trans('app.dir')">
                            <tbody>
                            <tr>
                                <th class="text-center">{{trans('pmActivity.id')}}</th>
                                <th class="text-center">{{trans('pmActivity.code')}}</th>
                                <th class="text-center">{{trans('pmActivity.description')}}</th>
                                <th class="text-center">{{trans('pmActivity.action')}}</th>
                            </tr>
                            <tr v-for="pmActivity in pmActivities " :key="pmActivity.id">
                                <td class="text-center">{{pmActivity.id}}</td>
                                <td class="text-center">{{pmActivity.code}}</td>
                                <td class="text-center">{{pmActivity.description}}</td>
                                <td class="text-center">
                                    <a href="#" @click="editModal('addNewAct',pmActivity)"><i class="fa fa-edit blue"></i></a>
                                    |
                                    <a href="#" @click="deletePmActivity(pmActivity.id)"><i class="fa fa-trash red"></i></a>                
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
                    <div class="modal fade" id="addNewAct" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('pmActivity.lblAddModal')}}</h5>
                                <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('pmActivity.lblUpdateModal')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editMod? updatePmActivity('addNewAct'):createPmActivity('addNewAct')">
                                <input type="hidden" name="pmActivity_id" v-model="form.pmActivity_id ">
                                <div class="modal-body">
                                    <div class="form-group"> 
                                         <label for="code" class="col-sm-6 control-label">{{trans('pmActivity.code')}}</label>                      
                                        <input v-model="form.code" type="text" name="code"
                                            class="form-control" :dir="trans('app.dir')" :placeholder="trans('pmActivity.code')" :class="{ 'is-invalid': form.errors.has('code') }">
                                        <has-error :form="form" field="code"></has-error>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-6 control-label">{{trans('pmActivity.description')}}</label>                                            
                                        <textarea v-model="form.description" type="text" name="description"
                                            class="form-control" :dir="trans('app.dir')" :placeholder="trans('pmActivity.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                                        </textarea>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="safty_description" class="col-sm-6 control-label">{{trans('pmActivity.saftyDscription')}}</label>                      
                                        <textarea v-model="form.safty_description" type="text" name="safty_description"
                                            class="form-control" :dir="trans('app.dir')" :placeholder="trans('pmActivity.saftyDscription')" :class="{ 'is-invalid': form.errors.has('safty_description') }">
                                        </textarea>
                                        <has-error :form="form" field="safty_description"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration" class="col-sm-6 control-label">{{trans('pmActivity.actDuration')}}</label>
                                        <br/>                                        
                                        <el-time-select
                                            v-model="form.duration"                        
                                            :picker-options="{
                                                start: '00:15',
                                                step: '00:15',
                                                end: '48:00'
                                            }"
                                            format="HH:mm"
                                            value-format="HH:mm"
                                            :placeholder="trans('pmActivity.actDuration')">
                                        </el-time-select>
                                    </div>         
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('pmActivity.btnClose')}}</button>
                                        <button type="submit" v-show="editMod" class="btn btn-success">{{trans('pmActivity.btnUpdate')}}</button>
                                        <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('pmActivity.btnAdd')}}</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                        <div class="container">
                    <div class="row justify-content-center mt-4">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{trans('pmSparePart.cardSparePartTitle')}} {{this.$route.params.name}}</h3>
                            <div class="card-tools">
                            <button class="btn btn-success pull-left" @click="newModal('addNewSparePart')">{{trans('pmSparePart.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>                
                            <router-link to="/preventiveService" class="btn btn-danger pull-left">{{trans('pmSparePart.backBtnLbl')}} <i class="fas fa-undo fa-fw"></i></router-link>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover align-middle" :dir="trans('app.dir')">
                            <tbody>
                            <tr>
                                <th class="text-center">{{trans('pmSparePart.id')}}</th>
                                <th class="text-center">{{trans('pmSparePart.code')}}</th>
                                <th class="text-center">{{trans('pmSparePart.description')}}</th>
                                <th class="text-center">{{trans('pmSparePart.action')}}</th>
                            </tr>
                            <tr v-for="pmSparePart in pmSpareParts " :key="pmSparePart.id">
                                <td class="text-center">{{pmSparePart.id}}</td>
                                <td class="text-center">{{pmSparePart.code}}</td>
                                <td class="text-center">{{pmSparePart.description}}</td>
                                <td class="text-center">
                                    <a href="#" @click="editModal('addNewSparePart','pmSparePart')"><i class="fa fa-edit blue"></i></a>
                                    |
                                    <a href="#" @click="deletePmActivity(pmSparePart.id)"><i class="fa fa-trash red"></i></a>                
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
                    <div class="modal fade" id="addNewSparePart" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('pmSparePart.lblAddModal')}}</h5>
                                <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('pmSparePart.lblUpdateModal')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editMod? updatePmSparePart('addNewSparePart'):createPmSparePart('addNewSparePart')">
                                <input type="hidden" name="pmService_id" v-model="form.pmService_id ">
                                <div class="modal-body">
                                    <div class="form-group">                        
                                        <input v-model="form.code" type="text" name="code"
                                            class="form-control" :dir="trans('pmSparePart.dir')" :placeholder="trans('pmSparePart.code')" :class="{ 'is-invalid': form.errors.has('code') }">
                                        <has-error :form="form" field="code"></has-error>
                                    </div>
                                    <div class="form-group">                        
                                        <textarea v-model="form.description" type="text" name="description"
                                            class="form-control" :dir="trans('pmSparePart.dir')" :placeholder="trans('pmSparePart.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                                        </textarea>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    <div class="form-group">                        
                                        <input v-model="form.quantity" type="text" name="quantity"
                                            class="form-control" :dir="trans('pmSparePart.dir')" :placeholder="trans('pmSparePart.quantity')" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                        <has-error :form="form" field="quantity"></has-error>
                                    </div> 
                                    <div class="form-group">  
                                        <label for="measurementUnits" class="col-sm-6 control-label">{{trans('pmSparePart.measurementUnit')}}</label>                      
                                        <select v-model="form.measurementUnit_id"  name="measurementUnits"
                                                    class="form-control" :dir="trans('pmSparePart.dir')" :class="{ 'is-invalid': form.errors.has('measurementUnit_id') }">
                                                <option value="" selected="selected">{{trans('pmSparePart.measurementUnit')}}</option>    
                                                <option v-for="measurementUnit in measurementUnits" :key="measurementUnit.id" :value="measurementUnit.id" >{{measurementUnit.code}}-{{measurementUnit.description}}</option>                                    
                                        </select>
                                        <has-error :form="form" field="measurementUnits"></has-error>                         
                                    </div>      
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('pmSparePart.btnClose')}}</button>
                                        <button type="submit" v-show="editMod" class="btn btn-success">{{trans('pmSparePart.btnUpdate')}}</button>
                                        <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('pmSparePart.btnAdd')}}</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
</template>
<script>
import {Alert} from '../utilities';
    export default {
        data(){
            return{
                editMod :false,
                pmActivities :{},
                pmSpareParts :{},
                measurementUnits :[],
                form : new Form({
                    id : '',
                    duration: '',
                    quantity : '',
                    mai_preventive_service_id :this.$route.params.id,                   
                    code : '',
                    description :'',
                    safty_description : '',
                    loadAlert : '',
                    insertAlert : '',
                    updateAlert : '',
                    deleteAlert : '',
                    warningAlert : '',
                    failedAlert : '',
                    noticTxt : '',
                    cancelButtonText : '',
                    confirmButtonText : ''

                }),
            }
        },
        methods :{
            newModal(modalName){
                this.editMod = false,
                this.form.reset();
                this.form.clear();
                 $('#'+modalName).modal('show');
            },
            editModal(modalName,pmObj){
                this.form.clear();
                this.editMod = true,
                $('#'+modalName).modal('show');
                this.form.fill(pmObj);
            },
            loadPmActivity(){
                this.form.failedAlert=trans('pmActivity.failedAlert');
                axios.get("../api/pmActivity/"+this.form.mai_preventive_service_id).then(({data})=>(this.pmActivities = data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'pmActivities'});
                    });
                });
            },
            createPmActivity(modalName){                
                this.$Progress.start();
                this.form.insertAlert=trans('pmActivity.insertAlert');
                this.form.post('../api/pmActivity').then(() =>{
                //var self = this;
                //let params = Object.assign({}, self.form);
                //axios.post('../api/pmActivity', params).then(() =>{
                Fire.$emit('AfterCrud');
                this.Alert.successToast(this.form.insertAlert).then(() => {
                    this.$router.push({name: 'pmActivities'});
                });
                this.$Progress.finish();
                $('#'+modalName).modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('pmActivity.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'pmActivities'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updatePmActivity(modalName){
                this.form.updateAlert=trans('pmActivity.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/pmActivity/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'pmActivities'});
                    });
                    this.$Progress.finish();
                     $('#'+modalName).modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('pmActivity.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'pmActivities'});
                    });
                    this.$Progress.fail();
                })                     
            },
             deletePmActivity(id){
                this.form.warningAlert = trans('pmActivity.warningAlert');
                this.form.deleteAlert = trans('pmActivity.deleteAlert');
                this.form.confirmButtonText = trans('pmActivity.confirmButtonText');
                this.form.cancelButtonText = trans('pmActivity.cancelButtonText');
                this.form.noticTxt= trans('pmActivity.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/pmActivity/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'pmActivities'});
                }).catch(() => {
                    this.form.failedAlert=trans('pmActivity.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'pmActivities'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
            loadMeasurementUnit(){
                axios.get("../api/publicTableRecord/6").then(({data})=>(this.measurementUnits = data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            },
        },        
        mounted() {
            this.loadPmActivity();
            this.loadMeasurementUnit();
            Fire.$on('AfterCrud',() => {
                this.loadPmActivity();
            });
        }
    }
</script>
