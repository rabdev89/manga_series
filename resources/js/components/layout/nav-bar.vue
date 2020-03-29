<style scoped>
  .navbar-contain {
    background-color:#0f2133;
    margin-right: -15px;
    margin-left: -15px;
  }
  a {
    color: grey;
    font-weight: bold;
    text-decoration: none;
  }
  .menu-items a {
    padding:0 15px;
    color:#dadada;
  }
  a:hover {
    color:#aeea00;
  }
  .homelink {
    color:white;
  }
   .search-container {
    padding-left: 15px;
    padding-right: 15px;
    margin: 15px 0;
    position: relative;
  }
  .results-container {
    background-color:#233a50;
    border: 3px solid #0f2133;
    color:white;
    position: absolute;
    z-index: 1;
    max-height: 50vh;
    overflow-y: scroll;
  }
  .results-container::-webkit-scrollbar {
    width: 10px;
  }
  .results-container::-webkit-scrollbar-track {
    background: #325372;
  }
  .results-container::-webkit-scrollbar-thumb {
    background: #0f2133;
  }
  .results-container::-webkit-scrollbar-thumb:hover {
    background: #0f2133;
  }
  .results-container a {
    color:white;
  }
  .results-container a:hover {
    color:#dcf836;
  }
  .q-item__section--thumbnail img {
    width:50px;
    height:auto;
  }
  .input {
    background: #233a50;
    padding-right: 11px;
    border: 4px solid #020d18;
    padding: 0px 15px;
  }

  .menu-nav {
    background: #020d18;
    padding: 20px 0;
    margin-top: 30px;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .navbar-contain {
      background-color:transparent;
      padding: 15px 0;
      margin:0;
    }

    .search-container {
      width: 90%;
      margin: 0 auto;
    }
  }
  /*Medium devices*/

  /*Large devices*/
  @media (min-width: 1919px) {
  }
  /*Extra large devices*/
  @media (min-width: 1920px) { }


  /*Medium devices*/
  @media (min-width: 1439px) {
    .search-container {
      width: 1170px;
    }
  }
</style>
<template>
  <div class="navbar-contain">
    <q-toolbar class="text-white justify-between">
      <div>
        <a href="/" class="homelink">
          <q-avatar>
            <img src="/img/logo.png">
          </q-avatar>
        </a>
      </div>
     <q-toolbar-title><a href="/" class="homelink">Manga Series</a></q-toolbar-title>
     <div class="search-nav-container">
        <q-input class="input" color="white" input-style="color:white;" v-model="searchText" label="Search">
          <template v-slot:append>
            <q-icon name="search" size="35px" color="white"/>
          </template>
        </q-input>
        <q-list v-show="results.length" class="results-container" bordered>
          <a v-for="(result, i) in results"  :href="'/manga/'+toSlug(result.title)" :key="result.id+''+i">
            <q-item clickable v-ripple>
              <q-item-section thumbnail>
                <img :src="result.imageURL ? result.imageURL : 'https://cdn.mangaeden.com/mangasimg/'+result.image" width="50px" height="auto" />
              </q-item-section>
              <q-item-section>{{result.title}}</q-item-section>
            </q-item>
          </a>
        </q-list>
     </div>
    </q-toolbar>

    <div class="q-toolbar">
      <div class="menu-items gt-sm menu-nav">
        <a href="/">HOME</a>
        <a href="/manga/categories/all">MANGA LIST</a>
        <a href="/manga/categories/hot">HOT MANGA</a>
        <a href="/manga/categories/new">NEW MANGA</a>
        <a href="/manga/categories/latest">LATEST RELEASES</a>
      </div>
      <!-- Hamburger Dropdown -->
      <q-btn-dropdown class="lt-md" flat icon="menu" menu-self="top right" icon-right :content-style="{width:'100vw'}">
        <q-list>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/all">MANGA LIST</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/hot">HOT MANGA</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/new">NEW MANGA</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/latest">LATEST RELEASES</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/advanced-search">ADVANCED SEARCH</a></q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </div>
  </div>
</template>

<script>
import Fetcher from '../../mixins/fetcher.js';
import Strings from '../../mixins/strings.js';

export default {
  mixins: [Fetcher, Strings],
  data() {
    return {
      searchText:'',
      mangas: [],
      results: [],
    }
  },
  watch: {
    searchText: function(newVal) {
      if(newVal.length > 2) {
        if(!this.mangas.length) {
          this.fetchMangaData().then(resp => {
            this.mangas = resp;
            this.search();
          });
        } else {
          this.search();
        }
      } else {
        this.results = [];
      }
    }
  },
  methods: {
    search() {
      let results = this.mangas.filter((manga) => {
        let byTitle = manga.title.toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1;
        let byAka = false;
        manga.aka.forEach((aka) => {
          if(aka.toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1) {
            byAka = true;
          }
        });
        return byTitle || byAka;
      });
      this.results = results.sort((a, b) => { return b.hits - a.hits; });
    }
  }
}
</script>
