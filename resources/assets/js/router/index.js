import VueRouter from 'vue-router';
import routes from './routes';

export default new VueRouter({
    //mode: 'history',
    base: '/dashboard',
    routes,
});