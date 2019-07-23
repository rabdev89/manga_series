require('./bootstrap');

window.Vue = require('vue');

//dependancies
require('quasar-framework/dist/quasar.mat.css');
import Quasar from 'quasar-framework';
Vue.use(Quasar);

//consistent compoents
const NavBar = () => import('./components/layout/nav-bar');

//pages
const LandingPage = () => import('./components/pages/landing-page');


const app = new Vue({
  el: '#app',
  components: {
    'landing-page':LandingPage,
    'nav-bar':NavBar,
  }
});
