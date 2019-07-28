require('./bootstrap');
require('intersection-observer');//IE pollyfill
window.Vue = require('vue');
import Quasar from 'quasar';
import 'quasar/dist/quasar.min.css';
Vue.use(Quasar);

axios.defaults.headers.get['Access-Control-Allow-Origin'] = 'http://localhost:8000/';

//consistent compoents
import NavBar from './components/layout/nav-bar';
import SearchBar from './components/common/search-bar';
//pages
import HomePage from './components/pages/home-page';
import CategoryPage from './components/pages/category-page';
import MangaPage from './components/pages/manga-page';
import ChapterPage from './components/pages/chapter-page/chapter-page';
import AdvancedSearch from './components/pages/advanced-search';

const app = new Vue({
  el: '#app',
  components: {
    'nav-bar':NavBar,
    'home-page':HomePage,
    'category-page':CategoryPage,
    'manga-page': MangaPage,
    'chapter-page':ChapterPage,
    'advanced-search': AdvancedSearch,
    'search-bar':SearchBar,
  }
});
