<style scoped>
  .home-container {
    padding-left: 15px;
    padding-right: 15px;
    margin-top: 15px;
  }
  .bg-theme {
    background:#020d18;
  }
  .bg-contrast {
    background: #0f2133;
    color:white;
  }
  h2 {
    font-family: 'Dosis', sans-serif;
    color: #ffffff;
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
    padding-bottom: 10px;
  }
  .carousel {
    margin-top:30px;
  }
  .spinner-container {
    height:400px;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .home-container {
      width: 90%;
      margin: 0 auto;
    }
    h2 {
      text-align: left;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .home-container {
      width: 1170px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
  .fade-enter-active {
    animation: go 0.7s;
    animation-delay:0.3s;
    opacity: 0;
  }

  @keyframes go {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }
</style>
<template>
  <div class="home-container">
    <!-- Random -->
    <div class="slider-section">
      <h2>Random Manga</h2>
      <div v-show="loading" class="spinner-container row justify-center items-center">
        <q-spinner-cube color="indigo" size="5rem" />
      </div>
      <carousel :autoplay="true" :autoplayTimeout="5000" class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
        <slide v-for="manga in randomManga" :key="'random'+manga.id" class="slide">
          <transition appear appear-active-class="fade-enter-active">
            <manga-card :manga="manga"></manga-card>
          </transition>
        </slide>
      </carousel>
    </div>
    <!-- Latest -->
    <div class="slider-section">
      <h2>Latest Updates</h2>
      <div v-show="loading" class="spinner-container row justify-center items-center">
        <q-spinner-cube color="indigo" size="5rem" />
      </div>
      <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
        <slide v-for="manga in mangaByLatestChapter" :key="'latest'+manga.id" class="slide">
          <manga-card :manga="manga"></manga-card>
        </slide>
      </carousel>
    </div>
    <div class="slider-section">
      <h2>Browse Manga</h2>
      <q-card>
        <q-tabs
          v-model="tab"
          dense
          class="bg-theme text-white"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab name="new" label="NEW" />
          <q-tab name="trending" label="TRENDING" />
          <q-tab name="popular" label="POPULAR" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated class="bg-contrast">
          <q-tab-panel name="new">
            <div class="text-h6">NEW MANGA</div>
            <div v-show="loading" class="spinner-container row justify-center items-center">
              <q-spinner-cube color="indigo" size="5rem" />
            </div>
            <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
              <slide v-for="(manga, i) in newManga" :key="'new'+manga.id+''+i" class="slide">
                <manga-card :manga="manga"></manga-card>
              </slide>
            </carousel>
          </q-tab-panel>

          <q-tab-panel name="trending">
            <div class="text-h6">TRENDING MANGA</div>
            <div v-show="loading" class="spinner-container row justify-center items-center">
              <q-spinner-cube color="indigo" size="5rem" />
            </div>
            <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
              <slide v-for="manga in trendingManga" :key="'trending'+manga.id" class="slide">
                <manga-card :manga="manga"></manga-card>
              </slide>
            </carousel>
          </q-tab-panel>

          <q-tab-panel name="popular">
            <div class="text-h6">MOST POPULAR</div>
            <div v-show="loading" class="spinner-container row justify-center items-center">
              <q-spinner-cube color="indigo" size="5rem" />
            </div>
            <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
              <slide v-for="(manga, i) in popularManga" :key="'popular'+manga.id+''+i" class="slide">
                <manga-card :manga="manga"></manga-card>
              </slide>
            </carousel>
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>
  </div>
</template>

<script>
import MangaCard from '../common/manga-card';
import { Carousel, Slide } from 'vue-carousel';
import Fetcher from '../../mixins/fetcher.js';
export default {
  mixins:[Fetcher],
  components: {
    Carousel,
    Slide,
    'manga-card':MangaCard,
  },
  props: {},
  data() {
    return {
      mangaByLatestChapter: [],
      randomManga: [],
      popularManga: [],
      newManga:[],
      trendingManga:[],
      tab: 'new',
      searchText: '',
      loading:false,
      lala:[],
    }
  },
  computed: {},
  created() {},
  mounted() {
    this.loading = true;
    this.fetchMangaData().then(manga => {
      //cut out manga that dont have chapters, as well as duplicates
      let seenIds = [];
      manga = manga.filter(m => {
        if(seenIds.indexOf(m.id) == -1) {
          seenIds.push(m.id);
          return m.chapters.length && m.title && (m.imageURL || m.image);
        }
          return false;
      });
      let randomNum = Math.floor((Math.random() * 100) + 1) - 12;
      this.pushToArray(this.randomManga, manga.slice(randomNum, randomNum + 12));
      this.pushToArray(this.mangaByLatestChapter, manga.sort((a, b) => { return b.last_chapter_date - a.last_chapter_date}).slice(0, 12));
      this.pushToArray(this.popularManga, manga.sort((a, b) => {return b.hits - a.hits;}).slice(0, 10));
      this.pushToArray(this.newManga, manga.sort((a, b) => {return b.released - a.released;}).slice(0, 10));
      let trending = manga.sort((a, b) => { return b.hits - a.hits});
      this.pushToArray(this.trendingManga, trending.filter((a) => { return a.released >= 2018;}).slice(0, 10));
      
      this.loading = false;
    });
  },
  methods: {
    pushToArray(arr, items) {
      let i = 0;
      let inv = setInterval(() => {
        arr.push(items[i]);
        i++;
        if(i == items.length) {
          clearInterval(inv);
        }
      }, 100);
    }
  }
}
</script>
