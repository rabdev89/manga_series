<style>
  .chapter-page {
    font-family: 'Dosis', sans-serif;
    color: #ffffff;
  }
  .chapter-container {
    background-color: #0b1a2a;
    border: 3px solid #0f2133;
  }
  .tool-bar {
    flex-wrap: wrap !important;
  }
  .tool-bar>* {
    margin:10px 0;
  }
  .bottom-tool-bar {
    flex-direction: column-reverse;
  }

  h2 {
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
    line-height: 3rem;
  }
  .spinner-container {
    height:400px;
  }

  .chapter-select {
    background-color:rgb(35, 58, 80);
  }
  .q-field__native {
    color: white !important;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    h2 {
      font-size: 24px;
    }
    .bottom-tool-bar {
      flex-direction: row;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .chapter-page {
      margin:0 auto;
      width: 1170px;
    }
    .tool-bar>* {
      margin:0px;
      padding:0px 5px;
    }
    .tool-bar {
      flex-wrap:nowrap !important;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div v-if="manga" class="chapter-page container">
    <h2><q-icon size="30px" color="red-13" name="label_important"></q-icon> {{manga.title}}</h2>
    <div v-show="!chapter || loading" class="spinner-container row justify-center items-center">
      <q-spinner-cube color="indigo" size="5rem" />
    </div>
    <div v-if="chapter" v-show="!loading" class="chapter-container">
      <!-- Toolbar -->
      <q-toolbar class="text-white tool-bar row q-my-md shadow-2">
        <q-select
          class="col-xs-12 col-md-4 chapter-select"
          outlined 
          v-model="chapter" 
          :options="manga.chapters" 
          option-label="title"
          option-value="id"
          color="text-white"
        >
          <template v-slot:prepend>
            <q-icon name="book" color="white"/>
          </template>
        </q-select>
        <div class="col-xs-12 col-md-2 row justify-center" style="padding:0 10px;">
          <q-btn :disable="true" color="positive" icon="favorite" label="Favorite" />
        </div>
        <div class="col-xs-12 col-md-3 row justify-center">
          <q-radio v-model="showAllPages" :val="true" label="All Pages" color="lime-14"/>
          <q-radio v-model="showAllPages" :val="false" label="One Page" color="lime-14"/>
        </div>
        <q-btn-group v-show="!showAllPages" push class="col-xs-12 col-md-3 justify-between">
          <q-btn :disable="!isPrevPage" @click="prevPage()" color="red-13" icon="arrow_left" label="Prev" />
          <q-btn :disable="!isNextPage" @click="nextPage()" color="red-13" icon-right="arrow_right" label="Next" />
        </q-btn-group>
      </q-toolbar>
      <!-- Page(s) -->
      <page-container v-if="chapter.pages" :pages="chapter.pages" :show-all="showAllPages" ref="page_container"></page-container>
      <!-- Toolbar 2 -->
      <q-toolbar class="text-white tool-bar bottom-tool-bar row q-my-md shadow-2">
        <q-select
          class="col-xs-12 col-md-4 chapter-select"
          outlined 
          v-model="chapter" 
          :options="manga.chapters" 
          option-label="title"
          option-value="id"
          color="text-white"
        >
          <template v-slot:prepend>
            <q-icon name="book" color="white"/>
          </template>
        </q-select>
        <div class="col-xs-12 col-md-2 row justify-center" style="padding:0 10px;">
          <q-btn :disable="true" color="positive" icon="favorite" label="Favorite" />
        </div>
        <div class="col-xs-12 col-md-3 row justify-center">
          <q-radio v-model="showAllPages" :val="true" label="All Pages" color="lime-14"/>
          <q-radio v-model="showAllPages" :val="false" label="One Page" color="lime-14"/>
        </div>
        <q-btn-group push v-show="!showAllPages" class="col-xs-12 col-md-3 justify-between">
          <q-btn :disable="!isPrevPage" @click="prevPage()" color="red-13" icon="arrow_left" label="Prev" />
          <q-btn :disable="!isNextPage" @click="nextPage()" color="red-13" icon-right="arrow_right" label="Next" />
        </q-btn-group>
      </q-toolbar>
    </div>
  </div>
</template>

<script>
import Fetcher from '../../../mixins/fetcher.js';
import Strings from '../../../mixins/strings.js';

import PageContainer from './page-container';

export default {
  mixins:[Fetcher, Strings],
  components: {
    'page-container':PageContainer,
  },
  props: {
    slug: {},
    initChapterNo:{}
  },
  data() {
    return {
      manga: null,
      chapter: null,
      index:null,
      loading:false,
      showAllPages: false,
      isPrevPage:false,
      isNextPage:true,
    }
  },
  mounted() {
    this.fetchMangaData().then(mangas => {
      //find manga
      mangas.forEach((manga) => {
        if(this.toSlug(manga.title) == this.slug) {
          this.manga = manga;
        }
      });
      if(!this.manga) {
        console.log('Not Found');
      } else {
        //map the chapters
        let i = 0;
        this.manga.chapters.forEach((chapter) => {
          this.manga.chapters[i] = {
            num: chapter[0],
            date: chapter[1],
            title: chapter[2] != chapter[0] ? 'Chapter '+ chapter[0] +' - '+chapter[2] : 'Chapter '+chapter[0],
            id: chapter[3]
          }
          i++;
        });
        //find the chapter
        this.manga.chapters.forEach((chapter) => {
          if(chapter.num == this.initChapterNo) {
            this.chapter = chapter;//triggers 'watch'
          }
        });
      }
    });

    this.$on('nextPage', () => {this.nextPage()});
  },
  watch: {
    'chapter.id':function(newVal, old) {
      //have this always run 'this.fetchPages()' if you want this to be SPA (with vue router, ofcourse)
      if(!old) {
        this.fetchPages();
      } else {
        //reroute (would just change vue-router $route here if were SPA)
        //find the chapter
        this.manga.chapters.forEach((chapter) => {
          if(newVal == chapter.id) {
            window.location.href = '/manga/'+this.toSlug(this.manga.title)+'/chapter/'+chapter.num;
          }
        });

      }
    }
  },
  methods: {
    fetchPages() {
      this.loading = true;
      //fetch the chapter pages
      this.fetchChapterPages(this.chapter.id).then(resp => {
        //map pages
        let i = 0;
        resp.forEach((page) => {
          resp[i] = {
            num:page[0],
            url:page[1],
            idk:page[2],
            idk2:page[3]
          }
          i++;
        });
        this.chapter.pages = resp.sort((a, b) => { return a.num - b.num});
        this.loading = false;
      });
    },
    nextPage() {
      this.isNextPage = this.$refs.page_container.nextPage();
      this.isPrevPage = true;
    },
    prevPage() {
      this.isPrevPage = this.$refs.page_container.prevPage();
      this.isNextPage = true;
    }
  }
}
</script>
