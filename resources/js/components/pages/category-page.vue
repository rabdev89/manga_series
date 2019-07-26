<style scoped>
  .category-container {
    margin-top: 15px;
    color:white;
    font-family: 'Dosis', sans-serif;
  }

  .category-links {
    padding:15px;
    background:#0f2133;
    border: 3px solid #233a50;
  }
  .category-links div {
    padding:5px;
    font-family: 'Dosis', sans-serif;
    font-weight: bold;
    text-transform: uppercase;
  }
  .category-links a {
    color:white;
    text-decoration:none;
  }
  .category-links a:hover {
    text-decoration: underline;
  }

  .categories-list {
    text-decoration:none;
    color:#abb7c4;

    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
  }
  .categories-list .list-container, .mangas-container {
    background-color: #0b1a2a;
    border: 3px solid #0f2133;
  }
  .list-container a {
    color: inherit;
    text-decoration: inherit;
  }
  .list-container.cutoff {
    max-height: 50vh;
    overflow: hidden;
  }
  .allcats-link {
    background:rgb(35, 58, 80);
    font-size:24px;
  }
  h1 {
    font-weight: bold;
    text-transform: uppercase;
    font-size:25px;
  }
  h5 {
    margin: 30px;
    padding: 15px;
    border-bottom: 2px solid;
    text-align: center;
  }

  .mangas-container {
    padding:15px;
    border-radius:10px;
  }
  .manga-wrap {
    padding: 5px;
    border: 1px solid #233a50;
    margin: 10px 0;
    background:#172533;
  }

  /*Small devices*/
  @media (min-width: 600px) {
    .category-container {
      padding-left: 15px;
      padding-right: 15px;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .category-container {
      margin:0 auto;
      width: 1170px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div class="category-container row">
    <!-- Top Categories -->
    <div class="category-links row col-xs-12 justify-around gt-sm">
      <div v-for="(cat, i) in catsToShow" class="items-center">
        <q-icon name="label" color="red-13"></q-icon>
        <a :href="'/manga/categories/'+cat.replace(/ /g, '-').toLowerCase()">{{cat}}</a>
      </div>
    </div>
    <!-- Manga of Category -->
    <div class="mangas-container col-xs-12 col-md-8">
      <h1><q-icon name="label" color="red-13"></q-icon> {{catSlug.replace(/-/g,' ').toUpperCase()}}</h1>
      <div class="btns-row row justify-end">
        <q-btn-group push>
          <q-btn push :color="viewAs == 'grid' ? 'lime-14' : ''" size="md" @click="viewAs = 'grid'" icon="grid_on" />
          <q-btn push :color="viewAs == 'list' ? 'lime-14' : ''" size="md" @click="viewAs = 'list'" icon="view_list" />
        </q-btn-group>
      </div>
      <div class="row">
        <!-- Manga Items -->
        <m-card-detail
          v-for="manga in mangas" 
          :key="'catmanga'+manga.i"
          :manga="manga"
          :view-as="viewAs"
          :class="['manga-wrap row', viewAs == 'grid' ? 'col-xs-12 col-sm-6 col-md-4' : 'col-12']">
        </m-card-detail>
      </div>
    </div>
    <!-- All Categories -->
    <div class="categories-list col-xs-12 col-md-4">
      <h5>All Categories</h5>
      <div :class="['list-container', 'q-pa-md', fullCatListShowing ? '' : 'cutoff']">
        <q-list bordered separator class="row">
          <a  class="col-xs-6" :href="'/manga/categories/'+cat.slug" v-for="(cat, i) in categories" :key="cat.slug+'link'">
            <q-item class="items-center" clickable v-ripple>
              <q-icon name="arrow_right" color="red-13"></q-icon> 
            <q-item-section>{{cat.name}}</q-item-section>
            </q-item>
          </a>
        </q-list>
      </div>
      <div class="allcats-link text-center" @click="fullCatListShowing = !fullCatListShowing">
        <q-icon v-show="!fullCatListShowing" name="keyboard_arrow_down"></q-icon>
        <q-icon v-show="fullCatListShowing" name="keyboard_arrow_up"></q-icon>
      </div>
    </div>
  </div>
</template>
<script>
import Fetcher from '../../mixins/fetcher.js';
import MCardDetail from '../common/m-card-detail';
export default {
  mixins:[Fetcher],
  components: {
    'm-card-detail': MCardDetail,
  },
  props: {
    cat: {},
  },
  data() {
    return {
      catsToShow:['Romance','Comedy','Sci-Fi','Drama','School Life','Shounen','Action'],
      categories: [],
      mangas: [],
      loading:false,
      fullCatListShowing:false,
      viewAs:'grid',
      oldData:[],
      newData: [],
      catSlug: this.cat,
      observer: null,
    }
  },
  mounted() {
    //fetch data
    this.loading = true;
    let seenCats = [];
    let catMangas = [];

    // this.fetchManga().then(resp => {
    //   this.oldData = resp;
    //   this.getManga(this.oldData[5693].i, 5693);
    // });
    this.fetchNewData().then(resp => {
      console.log(resp);
    });
    
    this.fetchManga().then(mangas => {
      mangas.forEach((manga) => {
        //extract categories
        manga.c.forEach((cat) => {
          let catObj = {name:cat,slug:cat.replace(/ /g, '-').toLowerCase()};
          //see if this category is the chosen one
          if(catObj.slug == this.catSlug) {
            catMangas.push(manga);
          }
          if(seenCats.indexOf(cat) == -1) {
            seenCats.push(cat);
            this.categories.push(catObj);
          }
        });
      });

      this.categories.sort((a, b) => { return a.name - b.name});
      if(!catMangas.length) {
        //take 20 TODO paginate, probably better to do with laravel
        catMangas = mangas.slice(0,20);// assume category is 'all', invalid or just has no manga, etc
        this.catSlug = 'all';
      }
      
      //sort by latest by default
      catMangas.sort((a, b) => { return a.ld - b.ld});
      //take 20 TODO paginate, probably better to do with laravel
      //this.mangas = catMangas.slice(0, 20);
      this.mangas = catMangas;
      this.loading = false;

    });
  },
  methods: {
    getManga(id, i) {
      axios.get('/data/data.json').then(resp1 => {
        axios.get('https://www.mangaeden.com/ajax/login/?username=mfinnigan&password=F655C2FgZB4cfqt').then(resp2 => {
          axios.get('https://www.mangaeden.com/api/manga/'+id).then(resp3 => {
            console.log((this.oldData.length - i) + ' to go');
            i++;
            this.newData.push(resp3.data);
            console.log(this.newData.length + ' fetched');
            console.log('--------');
            console.log(JSON.stringify(this.newData));
            console.log('----------');
            if(i < this.oldData.length) {
              this.getManga(this.oldData[i].i, i);
            }
          });
        });
      });
    }
  }
}
</script>
