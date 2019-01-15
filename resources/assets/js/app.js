
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//window.Vue = require('vue');
import Vue from 'vue';
//begin  VueRouter config
import VueRouter from 'vue-router'
Vue.use(VueRouter)
//end  VueRouter config
import router from './router';
//begin Vue Translate
Vue.prototype.trans = string => _.get(window.i18n, string);
window.trans = (string) => _.get(window.i18n, string);
//end Vue Translate

//begin  VueProgressBar config
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
});
//end VueProgressBar config
//begin  sweet alert config
import {Alert} from './utilities';
Vue.prototype.Alert = Alert;
//end  sweet alert config

//begin  vform config
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
//end  vform config

//begin config event listener
window.Fire = new Vue();
//end config event listener

//Begin TimePicker
import { TimePicker,TimeSelect,InputNumber} from 'element-ui';
import lang from 'element-ui/lib/locale/lang/fa'
import locale from 'element-ui/lib/locale'

// configure language
locale.use(lang);
Vue.use(TimePicker);
Vue.use(TimeSelect);
Vue.use(InputNumber);
Vue.component(TimePicker.name, TimePicker);
Vue.component(TimeSelect.name, TimeSelect);
Vue.component(InputNumber.name, InputNumber);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
//End TimePicker

//begin  moment & moment jallali config
import moment from 'moment';
import jalali from 'moment-jalaali';
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', VuePersianDatetimePicker);

Vue.filter('jalaliDate',function(created){
  //var m = moment('1360/5/26', 'jYYYY/jM/jD'); // Parse a Jalaali date.
  return jalali(created, 'YYYY/MM/DD').locale('fa').format('jYYYY/jMM/jDD');
});
//end  moment & moment jallali config


const app = new Vue({
    el: '#app',
    router
});
