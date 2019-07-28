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
    min-height:100vh;
    padding:15px;
    border-radius:10px;
    margin-top: 15px;
  }
  .manga-items-contain {
    min-height: 100vh;
  }
  .manga-wrap {
    padding: 5px;
    border: 1px solid #233a50;
    margin: 10px 0;
    background:#172533;
    max-width: 100%;
    overflow: hidden;
  }

  .spinner-container {
    height:100vh;
  }

  .no-results {
    height: 60vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  h6 {
    color: gray;
    margin: 0;
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
      <div v-for="cat in catsToShow" :key="'toplink'+cat" class="items-center">
        <q-icon name="label" color="red-13"></q-icon>
        <a :href="'/manga/categories/'+toSlug(cat)">{{cat}}</a>
      </div>
    </div>
    <!-- Manga of Category -->
    <div class="mangas-container col-xs-12 col-md-8">
      <h1>
        <q-icon name="label" color="red-13"></q-icon> 
         {{normalize(catSlug)}}<span v-show="catSlug !== 'Search Results'"> Manga</span>
      </h1>
      <p v-if="catSlug == 'Search Results'">{{formatNum(mangas.length)}} results found.</p>
      <div class="btns-row row justify-end">
        <q-btn-group push>
          <q-btn push :color="viewAs == 'grid' ? 'lime-14' : ''" size="md" @click="viewAs = 'grid'" icon="grid_on" />
          <q-btn push :color="viewAs == 'list' ? 'lime-14' : ''" size="md" @click="viewAs = 'list'" icon="view_list" />
        </q-btn-group>
      </div>
      <div class="row justify-center">
        <q-pagination
          v-model="currPage"
          color="teal"
          :max="parseInt((mangas.length / perPage).toFixed(0))"
          :max-pages="4"
          :direction-links="true"
          >
        </q-pagination>
      </div>
      <div v-show="loading" class="row manga-items-contain">
        <m-card-detail
          v-for="(fakeManga, i) in 10"
          :key="'fakeManga'+i"
          :manga="null"
          :view-as="viewAs"
          :class="['manga-wrap row', viewAs == 'grid' ? 'col-xs-12 col-sm-6' : 'col-12']">
        </m-card-detail>
      </div>
      <div v-show="!loading && mangas.length" class="row manga-items-contain">
        <!-- Manga Items -->
        <m-card-detail
          v-for="(manga, i) in mangas"
          v-if="((i + 1) < (currPage * perPage) + 1) && ((i + 1) >= (currPage * perPage) - 9)"
          :key="'catmanga'+manga.id"
          :manga="manga"
          :view-as="viewAs"
          :class="['manga-wrap row', viewAs == 'grid' ? 'col-xs-12 col-sm-6' : 'col-12']">
        </m-card-detail>
      </div>
      <div v-show="!loading && !mangas.length" class="no-results">
        <div class="img-contain text-center">
          <img src='/img/shrug.png' width="25%" />
        </div>
        <h6 class="text-center">No Results Found.</h6>
        <p class="text-center"><a href="/advanced-search" style="color:#dcf836">Go Back</a></p>
      </div>
      <div class="row justify-center">
        <q-pagination
          v-model="currPage"
          color="teal"
          :max="parseInt((mangas.length / perPage).toFixed(0))"
          :max-pages="4"
          :direction-links="true"
          >
        </q-pagination>
      </div>
    </div>
    <!-- All Categories -->
    <div class="categories-list col-xs-12 col-md-4">
      <h5>All Categories</h5>
      <div :class="['list-container', 'q-pa-md', fullCatListShowing ? '' : 'cutoff']">
        <q-list bordered separator class="row">
          <a  class="col-xs-6" :href="'/manga/categories/'+cat.slug" v-for="cat in categories" :key="cat.slug+'link'">
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
import Strings from '../../mixins/strings';
import MCardDetail from '../common/m-card-detail';
export default {
  mixins:[Fetcher, Strings],
  components: {
    'm-card-detail': MCardDetail,
  },
  props: {
    cat: {},
    params:{},
  },
  data() {
    return {
      catsToShow:['Romance','Comedy','Sci-Fi','Drama','School Life','Shounen','Action'],
      categories: [],
      mangas: [],
      loading:false,
      fullCatListShowing:false,
      viewAs:'grid',
      catSlug: this.cat,
      observer: null,
      currPage:1,
      perPage: 10,
    }
  },
  mounted() {
    //fetch data
    this.loading = true;
    let seenCats = [];
    let catMangas = [];
    
    this.fetchMangaData().then(mangas => {
      mangas.forEach((manga) => {
        //extract categories
        manga.categories.forEach((cat) => {
          let catObj = {name:cat,slug:this.toSlug(cat)};
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
        if(this.catSlug == 'hot') {
          catMangas = mangas.sort((a, b) => { return b.hits - a.hits});
          catMangas = catMangas.filter((a) => { return a.released >= 2018;});
        } else if(this.catSlug == 'latest') {
          catMangas = mangas.sort((a, b) => { return b.released - a.released; });
        } else if(this.catSlug == 'Search Results') {
          catMangas = this.advancedSearch(mangas, this.params);
        } else {
          catMangas = mangas;// assume category is 'all', invalid or just has no manga, etc
          this.catSlug = 'all';
          //sort by views by default
          catMangas.sort((a, b) => { return b.hits - a.hits});
        }
      } else {
        //sort by views by default
        catMangas.sort((a, b) => { return b.hits - a.hits});
      }
      if(catMangas.length) {
        this.mangas.push(catMangas[0]);
        this.pushToArray(this.mangas, catMangas.slice(1, catMangas.length - 1));
      }
      this.loading = false;
    });
  },
  methods: {
    pushToArray(arr, items) {
      let i = 0;
      let inv = setInterval(() => {
        arr.push(items[i]);
        i++;
        if(i == this.perPage) {
          this.mangas = this.mangas.concat(items.slice(this.perPage, items.length - 1));
          clearInterval(inv);
        }
      }, 100);
    },
  },
}
</script>
