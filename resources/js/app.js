require('./bootstrap');
window.Vue = require('vue');
import Quasar from 'quasar';
import 'quasar/dist/quasar.min.css';

Vue.use(Quasar);
axios.defaults.headers.get['Access-Control-Allow-Origin'] = 'http://localhost:8000/';
//axios.defaults.headers.get['X-RapidAPI-Host'] = 'community-manga-eden.p.rapidapi.com';
//axios.defaults.headers.get['X-RapidAPI-Key'] = '40ae237048mshe16e4269a69e6eep10ec6fjsnf54b841f37c4';
//consistent compoents
const NavBar = () => import('./components/layout/nav-bar');

//pages
import LandingPage from './components/pages/landing-page';

const app = new Vue({
  el: '#app',
  components: {
    'landing-page':LandingPage,
    'nav-bar':NavBar,
  }
});
