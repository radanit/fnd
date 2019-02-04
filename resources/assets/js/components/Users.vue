<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('user.cardTitle')}}</h3>
                <div class="card-tools">
                <button class="btn btn-success pull-left" @click="newModal">{{trans('user.addBtnLbl')}} <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover" :dir="trans('app.dir')">
                  <tbody>
                  <tr>
                    <th>{{trans('user.userId')}}</th>
                    <th>{{trans('user.userName')}}</th>
                    <th>{{trans('user.email')}}</th>
                    <th>{{trans('user.userGroup')}}</th>
                    <th>{{trans('user.createDate')}}</th>
                    <th>{{trans('user.action')}}</th>
                  </tr>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>                    
                    <td>{{user.group_id}}</td>
                    <td v-if="trans('user.fa')=='true'">{{user.created_at | jalaliDate}}</td>
                    <td v-else>{{user.created_at}}</td>
                    <td>
                        <a href="#" @click="editModal(user)"><i class="fa fa-edit blue"></i></a>
                        |
                        <a href="#" @click="deleteUser(user.id)"><i class="fa fa-trash red"></i></a>
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
                    <h5 class="modal-title" v-show="!editMod" id="addNewLabel">{{trans('user.lblAddModal')}}</h5>
                    <h5 class="modal-title" v-show="editMod" id="addNewLabel">{{trans('user.lblUpdateModal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMod? updateUser():createUser()">
                    <div class="modal-body">
                        <div class="form-group">                        
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('user.userName')" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">                        
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('user.email')" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    <div class="form-group">                        
                        <textarea v-model="form.bio" type="email" name="bio" id="bio"
                                    class="form-control" :dir="trans('app.dir')" :placeholder="trans('user.bio')" :class="{ 'is-invalid': form.errors.has('bio') }">
                                <has-error :form="form" field="bio"></has-error>
                        </textarea>
                    </div>
                    <div class="form-group">                        
                        <select v-model="form.group_id"  name="userGroups"
                                    class="form-control" :dir="trans('app.dir')" :class="{ 'is-invalid': form.errors.has('userGroups') }">
                                <option value="" selected="selected">{{trans('user.userGroup')}}</option>    
                                <option v-for="userGroup in userGroups" :key="userGroup.id" :value="userGroup.id" >{{userGroup.groupDes}}</option>                               
                                <has-error :form="form" field="userGroups"></has-error>
                        </select>
                    </div>
                    <div class="form-group">                      
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :dir="trans('app.dir')" :placeholder="trans('user.password')" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('user.btnClose')}}</button>
                        <button type="submit" v-show="editMod" class="btn btn-success">{{trans('user.btnUpdate')}}</button>
                        <button type="submit" v-show="!editMod" class="btn btn-primary">{{trans('user.btnAdd')}}</button>
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
                users :{},
                userGroups:{},
                form : new Form({
                    id : '',
                    name :'',
                    email : '',
                    password :'',
                    group_id :'',
                    bio : '',
                    photo : '',
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
            editModal(user){
                this.form.clear();
                this.editMod = true,
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            loadUser(){
                this.form.failedAlert=trans('user.failedAlert');
                axios.get("../api/user").then(({data})=>(this.users = data.data)).catch(()=>{
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                });
            },
            createUser(){                
                this.$Progress.start();
                this.form.insertAlert=trans('user.insertAlert');
                this.form.post('../api/user').then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.insertAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('user.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.fail();
                })                                
            },
            updateUser(){
                this.form.updateAlert=trans('user.updateAlert');
                this.$Progress.start();
                 this.form.put('../api/user/'+this.form.id).then(() =>{
                    Fire.$emit('AfterCrud');
                    this.Alert.successToast(this.form.updateAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.finish();
                    $('#addNew').modal('hide');
                })
                .catch(() => {
                    this.form.failedAlert=trans('user.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.fail();
                })                     
            },
            deleteUser(id){
                this.form.warningAlert = trans('user.warningAlert');
                this.form.deleteAlert = trans('user.deleteAlert');
                this.form.confirmButtonText = trans('app.confirmButtonText');
                this.form.cancelButtonText = trans('app.cancelButtonText');
                this.form.noticTxt= trans('app.noticTxt')
                Alert.warning(this.form.warningAlert,this.form.noticTxt,this.form.confirmButtonText,this.form.cancelButtonText)
                .then((message) => {
                axios.delete('../api/user/'+id)
                .then(response => {
                    Fire.$emit('AfterCrud');
                    Alert.successToast(this.form.deleteAlert);
                    this.$router.push({name: 'users'});
                }).catch(() => {
                    this.form.failedAlert=trans('user.failedAlert');
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.fail();
                    })  
                })
            },
            loadUserGroup(){
                axios.get("../api/userGroup").then(({data})=>(this.userGroups = data.data)).catch(() => {                    
                    this.Alert.errorToast(this.form.failedAlert).then(() => {
                        this.$router.push({name: 'users'});
                    });
                    this.$Progress.fail();
                })  
                
            }
        },        
        mounted() {
            this.loadUser();
            this.loadUserGroup();
            Fire.$on('AfterCrud',() => {
                this.loadUser();
            });
        }
    }
</script>
