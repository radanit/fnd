<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('preventiveService.cardTitle')}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('preventiveService.addBtnLbl')}} <i class="fas fa-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle" :dir="trans('app.dir')">
                  <tbody>
                  <tr>
                    <th class="text-center">{{trans('preventiveService.id')}}</th>
                    <th class="text-center">{{trans('preventiveService.code')}}</th>
                    <th class="text-center">{{trans('preventiveService.description')}}</th>
                    <th class="text-center">{{trans('preventiveService.action')}}</th>
                  </tr>
                  <tr v-for="preventiveService in preventiveServices" :key="preventiveService.id">
                    <td class="text-center">{{preventiveService.id}}</td>
                    <td class="text-center">{{preventiveService.code}}</td>
                    <td class="text-center">{{preventiveService.description}}</td>
                    <td class="text-center">
                        <a href="#" @click="editModal(preventiveService)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deletePreventiveService(preventiveService.id)"><i class="fa fa-trash red"></i></a>
                        |                        
                        <router-link :to="{ name: 'pmActivities', params: { id:preventiveService.id,name:preventiveService.description }}"><i class="fa fa-list-alt green"></i></router-link>
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('preventiveService.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('preventiveService.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMod? updatePreventiveService():createPreventiveService()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="code" class="col-sm-6 control-label">{{trans('preventiveService.code')}}</label>
                                <input v-model="form.code" type="text" name="code"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('preventiveService.code')" :class="{ 'is-invalid': form.errors.has('code') }">
                                <has-error :form="form" field="code"></has-error>
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="old_code" class="col-sm-12 control-label">{{trans('preventiveService.old_code')}}</label>
                                <input v-model="form.old_code" type="text" name="old_code"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('preventiveService.old_code')" :class="{ 'is-invalid': form.errors.has('old_code') }">
                                <has-error :form="form" field="old_code"></has-error>
                            </div>                                                       
                        </div>
                        <div class="row">                        
                            <div class="form-group col-xs-12 col-md-12">
                                <label for="description" class="col-sm-9 control-label">{{trans('preventiveService.description')}}</label>                      
                                <textarea v-model="form.description" type="text" name="description"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('preventiveService.description')" :class="{ 'is-invalid': form.errors.has('description') }">
                                </textarea>
                                <has-error :form="form" field="description"></has-error>
                            </div>                                                        
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="latin_name" class="col-sm-6 control-label">{{trans('preventiveService.latin_name')}}</label>
                                <input v-model="form.latin_name" type="text" name="latin_name"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('preventiveService.latin_name')" :class="{ 'is-invalid': form.errors.has('latin_name') }">
                                <has-error :form="form" field="latin_name"></has-error>
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="persian_name" class="col-sm-6 control-label">{{trans('preventiveService.persian_name')}}</label>
                                <input v-model="form.persian_name" type="text" name="persian_name"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('preventiveService.persian_name')" :class="{ 'is-invalid': form.errors.has('persian_name') }">
                                <has-error :form="form" field="persian_name"></has-error>
                            </div>
                        </div>
                        <div class="row">                        
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="duration" class="col-sm-9 control-label">{{trans('preventiveService.pmDuration')}}</label>
                                <br/>                            
                                <el-time-select
                                    v-model="form.duration"        
                                    :picker-options="{
                                        start: '00:15',
                                        step: '00:15',
                                        end: '48:00',
                                        required:true 
                                    }"
                                    format="HH:mm"
                                    value-format="HH:mm"
                                    :placeholder="trans('preventiveService.pmDuration')">
                                </el-time-select>
                            </div>                            
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="periodType_id" class="col-sm-6 control-label">{{trans('preventiveService.periodType')}}</label>                        
                                <select v-model="form.periodType_id"  name="periodType_id"
                                            class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('periodType_id') }">
                                        <option value="" selected="selected">{{trans('preventiveService.periodType')}}</option>    
                                        <option v-for="periodType in periodTypes" :key="periodType.id" :value="periodType.id" >{{periodType.code}}-{{periodType.description}}</option>                                    
                                </select>
                                <has-error :form="form" field="periodType_id"></has-error>                        
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="quantity_ferquancy" class="col-sm-6 control-label">{{trans('preventiveService.qtyFerquancy')}}</label>
                                <br/>
                                <el-input-number v-model="form.quantity_ferquancy" :min="1"  :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('quantity_ferquancy') }"></el-input-number>
                                <has-error :form="form" field="quantity_ferquancy"></has-error>
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="second_quantity_ferquancy" class="col-sm-6 control-label">{{trans('preventiveService.qtySecondFerquancy')}}</label>
                                <br/>
                                <el-input-number v-model="form.second_quantity_ferquancy" :min="0"  :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('second_quantity_ferquancy') }"></el-input-number>
                                <has-error :form="form" field="second_quantity_ferquancy"></has-error>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6 col-md-6">  
                                <label for="stopCode_id" class="col-sm-6 control-label">{{trans('preventiveService.stopCode')}}</label>                      
                                <select v-model="form.stopCode_id"  name="stopCode_id"
                                            class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('stopCode_id') }">
                                        <option value="" selected="selected">{{trans('preventiveService.stopCode')}}</option>    
                                        <option v-for="stopCode in stopCodes" :key="stopCode.id" :value="stopCode.id" >{{stopCode.code}}-{{stopCode.description}}</option>                                    
                                </select>
                                <has-error :form="form" field="stopCode_id"></has-error>                           
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="pmType_id" class="col-sm-6 control-label">{{trans('preventiveService.pmType')}}</label>                     
                                <select v-model="form.pmType_id"  name="pmType_id"
                                            class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('pmType_id') }">
                                        <option value="" selected="selected">{{trans('preventiveService.pmType')}}</option>    
                                        <option v-for="pmType in pmTypes" :key="pmType.id" :value="pmType.id" >{{pmType.code}}-{{pmType.description}}</option>                                    
                                </select>
                                <has-error :form="form" field="pmType_id"></has-error>                           
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="mai_executive_department_id" class="col-sm-6 control-label">{{trans('preventiveService.exeDepart')}}</label>                        
                                <select v-model="form.mai_executive_department_id"  name="mai_executive_department_id"
                                            class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('mai_executive_department_id') }">
                                        <option value="" selected="selected">{{trans('preventiveService.exeDepart')}}</option>    
                                        <option v-for="exeDepart in exeDeparts" :key="exeDepart.id" :value="exeDepart.id" >{{exeDepart.code}}-{{exeDepart.description}}</option>                                    
                                </select>
                                <has-error :form="form" field="mai_executive_department_id"></has-error>                        
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label for="programType_id" class="col-sm-6 control-label">{{trans('preventiveService.programType')}}</label>                        
                                <select v-model="form.programType_id"  name="programType_id"
                                            class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('programType_id') }">
                                        <option value="" selected="selected">{{trans('preventiveService.programType')}}</option>    
                                        <option v-for="programType in programTypes" :key="programType.id" :value="programType.id" >{{programType.code}}-{{programType.description}}</option>                                    
                                </select>
                                <has-error :form="form" field="programType_id"></has-error>
                                <!--<vue-single-select
                                        name="programTypes"
                                        :placeholder="trans('preventiveService.programType')"
                                        v-model="form.programType_id"
                                        :options="programTypes"
                                        required
                                        option-key="code"
                                        option-label="description"                                   
                                >
                                </vue-single-select>-->                             
                            </div>
                        </div>                                    
                        <div class="modal-footer">                            
                            <button type="submit" v-show="editMod" class="btn btn-success">{{trans('preventiveService.btnUpdate')}}</button>
                            <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('preventiveService.btnAdd')}}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('preventiveService.btnClose')}}</button>
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
                preventiveServices :{},
                stopCodes :[],
                pmTypes :[],
                exeDeparts :[],
                programTypes :[],
                periodTypes :[],
                form : new Form({
                    id : '',
                    stopCode_id: '',
                    pmType_id: '',
                    duration :'',
                    mai_executive_department_id: '',
                    programType_id: '',
                    periodType_id: '',
                    code : '',
                    old_code : '',
                    latin_name : '',
                    persian_name : '',
                    description :'',
                    quantity_ferquancy: '',
                    second_quantity_ferquancy : '',
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
            editModal(preventiveService){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(preventiveService);
            },
            loadPreventiveService(){
                this.form.failedAlert=trans('preventiveService.failedAlert');
                axios.get("../api/preventiveService").then(({data})=>(this.preventiveServices = data.data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                });
            },
            createPreventiveService(){                
                this.$Progress.start();
                this.form.insertAlert=trans('preventiveService.insertAlert');
                this.form.post('../api/preventiveService').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('preventiveService.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updatePreventiveService(){
                this.form.updateAlert=trans('preventiveService.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/preventiveService/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('preventiveService.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                     
            },
            deletePreventiveService(id){
                this.form.warningAlert = trans('preventiveService.warningAlert');
                this.form.deleteAlert = trans('preventiveService.deleteAlert');
                this.form.confirmButtonText = trans('app.confirmButtonText');
                this.form.cancelButtonText = trans('app.cancelButtonText');
                this.form.noticTxt= trans('app.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/preventiveService/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'preventiveService'});
                }).catch(() => {
                    this.form.failedAlert=trans('preventiveService.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
            loadStopCode(){
                axios.get("../api/publicTableRecord/stopCodes").then(({data})=>(this.stopCodes =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            },
            loadPmType(){
                axios.get("../api/publicTableRecord/pmTypes").then(({data})=>(this.pmTypes =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            },
            loadProgramType(){
                axios.get("../api/publicTableRecord/programTypes").then(({data})=>(this.programTypes =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            },
            loadPeriodType(){
                axios.get("../api/publicTableRecord/periodTypes").then(({data})=>(this.periodTypes =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            },            
            loadExeDepart(){
                axios.get("../api/publicTableRecord/exeDeparts").then(({data})=>(this.exeDeparts =data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'preventiveService'});
                    });
                    this.$Progress.fail();
                })                  
            }
        },        
        mounted() {
            this.loadPreventiveService();
            this.loadStopCode();
            this.loadPmType();
            this.loadExeDepart();
            this.loadProgramType();
            this.loadPeriodType();
            Fire.$on('AfterCrud',() => {
                this.loadPreventiveService();
            });
        }
    }
</script>
