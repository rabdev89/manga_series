<style scoped>
  .home-container {
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
  .carousel, .mangas-container {
    margin-top:30px;
  }
  .spinner-container {
    height:400px;
  }
  .slider-section,.latest-section {
    min-height: 400px;
    margin:35px 0;
  }

  .manga-wrap {
    padding: 5px;
    border: 1px solid #233a50;
    margin: 10px 0;
    background:#172533;
    max-width: 100%;
    overflow: hidden;
  }


  /*Small devices*/
  @media (min-width: 600px) {
    h2 {
      text-align: left;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {

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
      <div v-show="loading" class="spinner-container row justify-center items-center">
        <q-spinner-cube color="indigo" size="5rem" />
      </div>
      <carousel
        :autoplay="false"
        :autoplayTimeout="5000"
        class="carousel"
        :scrollPerPage="true"
        :perPage="1"
        :perPageCustom="[[768, 3],[1024, 4]]"
        paginationActiveColor="#aeea00"
      >
        <slide v-for="manga in randomManga" :key="'random'+manga.id" class="slide">
          <transition appear appear-active-class="fade-enter-active">
            <manga-card :manga="manga"></manga-card>
          </transition>
        </slide>
      </carousel>
    </div>
    <!-- Latest -->
    <div class="row">
      <div class="latest-section col-xs-12 col-md-8">
        <h2 class="row justify-between">Latest Releases <a style="font-size:65%;color:#dcf836;" href="/manga/categories/latest">See All</a></h2>
        <div v-show="loading" class="spinner-container row justify-center items-center">
          <q-spinner-cube color="indigo" size="5rem" />
        </div>
        <div v-show="!loading" class="mangas-container row">
          <m-card-detail
            v-for="manga in mangaByLatestChapter"
            :key="'catmanga'+manga.id"
            :manga="manga"
            view-as="grid"
            class="manga-wrap col-xs-12 col-sm-6 col-md-12">
          </m-card-detail>
        </div>
      </div>

      <div class="slider-section col-xs-12 col-md-4">
        <div style="display:none">
        <h2>Browse Manga</h2>
        <q-card>
          <q-tabs
            v-model="tab"
            dense
            class="bg-theme text-white"
            active-color="lime-14"
            indicator-color="lime-14"
            align="justify"
            narrow-indicator
            style='border-radius:0;'
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
              <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 4],[1024, 5]]" paginationActiveColor="#aeea00">
                <slide v-for="(manga, i) in newManga" :key="'new'+manga.id+''+i" class="slide">
                  <manga-card :manga="manga" style="height: 250px;"></manga-card>
                </slide>
              </carousel>
            </q-tab-panel>

            <q-tab-panel name="trending">
              <div class="text-h6">TRENDING MANGA</div>
              <div v-show="loading" class="spinner-container row justify-center items-center">
                <q-spinner-cube color="indigo" size="5rem" />
              </div>
              <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 4],[1024, 5]]" paginationActiveColor="#aeea00">
                <slide v-for="manga in trendingManga" :key="'trending'+manga.id" class="slide">
                  <manga-card :manga="manga" style="height: 250px;"></manga-card>
                </slide>
              </carousel>
            </q-tab-panel>

            <q-tab-panel name="popular">
              <div class="text-h6">MOST POPULAR</div>
              <div v-show="loading" class="spinner-container row justify-center items-center">
                <q-spinner-cube color="indigo" size="5rem" />
              </div>
              <carousel class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 4],[1024, 5]]" paginationActiveColor="#aeea00">
                <slide v-for="(manga, i) in popularManga" :key="'popular'+manga.id+''+i" class="slide">
                  <manga-card :manga="manga" style="height: 250px;"></manga-card>
                </slide>
              </carousel>
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MangaCard from '../common/manga-card';
import MCardDetail from '../common/m-card-detail';

import { Carousel, Slide } from 'vue-carousel';
import Fetcher from '../../mixins/fetcher.js';
export default {
  mixins:[Fetcher],
  components: {
    Carousel,
    Slide,
    'manga-card':MangaCard,
    'm-card-detail': MCardDetail,
  },
  data() {
    return {
      mangaByLatestChapter: [],
      randomManga: [],
      popularManga: [],
      newManga:[],
      trendingManga:[],
      tab: 'new',
      loading:false,
    }
  },
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
      let self = this;
      let randomNum = Math.floor((Math.random() * 100) + 1);
      if(randomNum < 0) {
        randomNum = 0;
      }
      this.pushToArray(this.randomManga, manga.slice(randomNum, randomNum + 10));
      setTimeout(() => {
        self.pushToArray(self.mangaByLatestChapter, manga.sort((a, b) => { return b.last_chapter_date - a.last_chapter_date}).slice(0, 10));
      }, 500);
      this.pushToArray(this.popularManga, manga.sort((a, b) => {return b.hits - a.hits;}).slice(0, 9));
      this.pushToArray(this.newManga, manga.sort((a, b) => {return b.released - a.released;}).slice(0, 9));
      let trending = manga.sort((a, b) => { return b.hits - a.hits});
      this.pushToArray(this.trendingManga, trending.filter((a) => { return a.released >= 2018;}).slice(0, 9));
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
    },
  }
}
</script>

