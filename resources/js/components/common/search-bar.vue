<style scoped>
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
    width: 90%;
    margin-top: -20px;
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

  /*Small devices*/
  @media (min-width: 600px) {
    .search-container {
      width: 90%;
      margin: 0 auto;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .search-container {
      width: 1170px;
    }
  }
</style>
<template>
  <div class="search-container">
    <q-input input-style="background-color:#233a50;color:white;" color="white" bottom-slots v-model="searchText" label="Search" counter maxlength="100">
      <template v-slot:append>
        <q-icon name="search" color="white"/>
      </template>
    </q-input>
    <q-list v-show="results.length" class="results-container" bordered>
      <a v-for="(result, i) in results"  :href="'/manga/'+toSlug(result.title)" :key="result.id+''+i">
        <q-item clickable v-ripple>
          <q-item-section thumbnail>
            <img :src="result.imageURL ? result.imageURL : 'https://cdn.mangaeden.com/mangasimg/'+result.image" width="50px" height="auto">
          </q-item-section>
          <q-item-section>{{result.title}}</q-item-section>
        </q-item>
      </a>
    </q-list>
  </div>
</template>

<script>
import Fetcher from '../../mixins/fetcher.js';
import Strings from '../../mixins/strings.js';

export default {
  mixins: [Fetcher, Strings],
  props: {},
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
