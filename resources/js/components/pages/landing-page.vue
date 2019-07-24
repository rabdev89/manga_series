<style scoped>
  .landing-container {
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
    font-size: 24px;
    color: #ffffff;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
  }
  .carousel {
    margin-top:30px;
  }
  .spinner-container {
    height:400px;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .landing-container {
      width: 90%;
      margin: 0 auto;
    }
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
  <div class="landing-container">
    <!-- Search -->
    <q-input input-style="background-color:#0f2133;color:white;" color="white" bottom-slots v-model="searchText" label="Search" counter maxlength="100">
      <template v-slot:append>
        <q-icon name="search" color="white"/>
      </template>
    </q-input>
    <!-- Random -->
    <div class="slider-section">
      <h2>Random Manga</h2>
      <div v-show="loading" class="spinner-container row justify-center items-center">
        <q-spinner-cube color="indigo" size="5rem" />
      </div>
      <carousel :autoplay="true" :autoplayTimeout="5000" class="carousel" :scrollPerPage="true" :perPage="1" :perPageCustom="[[768, 3],[1024, 4]]">
        <slide v-for="(manga, i) in randomManga" :key="manga.i" class="slide">
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
        <slide v-for="manga in mangaByLatestChapter" :key="manga.i" class="slide">
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
              <slide v-for="manga in fetchedManga" :key="manga.i" class="slide">
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
              <slide v-for="manga in fetchedManga" :key="manga.i" class="slide">
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
              <slide v-for="manga in fetchedManga" :key="manga.i" class="slide">
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

export default {
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
      fetchedManga: [],
      browsing: 'new',
      tab: 'new',
      searchText: '',
      loading:false,
    }
  },
  computed: {},
  created() {},
  mounted() {
    this.fetchMangaData(null);
  },
  methods: {
    fetchMangaData(param) {
      if(!param) {
        param = 'list/0';
      } else if(param == 'new') {
        //etc
      }
      this.loading = true;
      axios.get('https://www.mangaeden.com/ajax/login/?username=mfinnigan&password=F655C2FgZB4cfqt').then(resp => {
        axios.get('https://www.mangaeden.com/api/'+param)
        .then(resp => {
          // image ("im"), title ("t"), ID ("i"), alias ("a"), status ("s"), category ("c"), last chapter date ("ld"), hits ("h")
          if(param == 'list/0') {
            this.pushToArray(this.randomManga, resp.data.manga.slice(0, 8));
            this.pushToArray(this.mangaByLatestChapter, resp.data.manga.sort((a, b) => { return a.ld - b.ld}).slice(0, 8));
          }
          // 'new' manga, will have to re-init this.fetchMangaData() when param for new manga available
          this.pushToArray(this.fetchedManga, resp.data.manga.slice(10, 18));
          this.loading = false;
        });
      });
    },
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
