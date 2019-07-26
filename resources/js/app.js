require('./bootstrap');
require('intersection-observer');//IE pollyfill
window.Vue = require('vue');
import Quasar from 'quasar';
import 'quasar/dist/quasar.min.css';

Vue.use(Quasar);
axios.defaults.headers.get['Access-Control-Allow-Origin'] = 'http://localhost:8000/';
//axios.defaults.headers.get['X-RapidAPI-Host'] = 'community-manga-eden.p.rapidapi.com';
//axios.defaults.headers.get['X-RapidAPI-Key'] = '40ae237048mshe16e4269a69e6eep10ec6fjsnf54b841f37c4';
//consistent compoents
const NavBar = () => import('./components/layout/nav-bar');
import SearchBar from './components/common/search-bar';
//pages
import HomePage from './components/pages/home-page';
import CategoryPage from './components/pages/category-page';
import MangaPage from './components/pages/manga-page';

const app = new Vue({
  el: '#app',
  components: {
    'nav-bar':NavBar,
    'home-page':HomePage,
    'category-page':CategoryPage,
    'manga-page': MangaPage,
    'search-bar':SearchBar,
  }
});
