<style scoped>
  .spinner-container {
    min-height:400px;
  }
  p {
    font-weight: bold;
    font-size:18px;
  }
  img {
    display: block;
    margin:0 auto;
  }
  img:hover {
    cursor: pointer;
  }
  /*Small devices*/
  @media (min-width: 600px) {
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div class="page-container">
    <div class="resizer">
      <q-badge color="red-14">
        Resize Page(s): {{ pageWidth+'%' }}
      </q-badge>

      <q-slider v-model="pageWidth" :min="25" :max="100"/>
    </div>
    <p class="text-center">
      <span v-if="!showAll">{{(index + 1)}}/{{pages.length}} Pages</span>
      <span v-else>{{pages.length}}/{{pages.length}}</span>
    </p>
    <div v-show="loading" class="spinner-container row justify-center items-center">
      <q-spinner-cube color="indigo" size="5rem" />
    </div>
    <span v-if="!showAll">
      <img 
        v-show="!loading"
        @click="emitNextPage()" 
        @load="loading = false"
        :src="'https://cdn.mangaeden.com/mangasimg/'+pages[index].url" 
        :width="pageWidth+'%'"
      />
      <p class="text-center">{{(index + 1)}}/{{pages.length}} Pages</p>
    </span>
    <img
      v-else
      v-show="!loading"
      v-for="page in pages" :key="page.url"
      :src="'https://cdn.mangaeden.com/mangasimg/'+page.url" 
      :width="pageWidth+'%'"
      @load="pagesLoaded++"/>
  </div>
</template>

<script>
export default {
  props: {
    pages: {},
    showAll: {}
  },
  data() {
    return {
      showingAll: this.showAll,
      index: 0,
      loading: false,
      pagesLoaded:0,
      pageWidth:100,
    }
  },
  watch: {
    showAll:function(newVal, old) {
      this.loading = true;
      this.showingAll = newVal;
    },
    pagesLoaded: function(newVal, old) {
      if(newVal == this.pages.length && newVal !== 0) {
        this.loading = false;
        this.pagesLoaded = 0;
      }
    },
    pageWidth: function(newVal, old) {
      //save pageWidth
      localStorage.setItem('manga_series_chapter_page_width', newVal);
    }
  },
  mounted() {
    //fetch saved pageWidth
    if(localStorage.getItem('manga_series_chapter_page_width')) {
      this.pageWidth = parseInt(localStorage.getItem('manga_series_chapter_page_width'));
    }
  },
  methods: {
    //emit nextPage to parent, so parent can track page number etc
    emitNextPage() {
      if(!this.showingAll)
        this.$parent.$emit('nextPage');
    },
    nextPage() {
      if((this.index + 1) != this.pages.length) {
        this.loading = true;
        this.index++;
      }
      return (this.index + 1) !== this.pages.length;
    },
    prevPage() {
      if(this.index !== 0) {
        this.loading = true;
        this.index--;
      }
      return this.index !== 0;
    }
  }
}
</script>
