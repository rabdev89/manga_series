<style scoped>
  .m-content {
    padding:0px 10px;
  }
  p {
    margin-bottom:5px;
    display:inline-block;
  }
  .m-content.list .m-title {
    display:none;
  }
  .m-title.list {
    padding-left: 5px;
    padding-top: 5px;
  }
  .m-title {
    display: block;
    font-weight:bold;
    border-bottom:1px solid white;
  }
  .m-title:hover {
    color:#dcf836;
    cursor:pointer;
  }
  .m-title a {
    color: inherit;
    text-decoration: inherit;
  }
  .paddout {
    height:270px;
    background:#1a2b3c;
  }
  .paddout.image {
    margin: 5px;
  }
  /*Small devices*/
  @media (min-width: 600px) {
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .m-content {
      padding:10px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div v-observe-visibility="visibilityChanged">
    <div :class="['img-contain', viewAs == 'list' ? 'hidden' : 'col']">
      <img v-if="isVisible && manga" :src="'https://cdn.mangaeden.com/mangasimg/'+manga.image" width="100%"/>
      <div v-else-if="+manga && !isVisible" class="row justify-center items-center">
        <q-spinner-cube color="indigo" size="2rem" />
      </div>
      <div v-else class="paddout image"></div>
    </div>
    <p v-if="manga" v-show="viewAs == 'list'" class="m-title list col-12"><a :href="'/manga/'+toString(manga.title)">{{manga.title}}</a></p>
    <div :class="['m-content', viewAs, viewAs == 'list' ? 'row col-12' : 'col']">
      <span v-if="manga">
        <p class="m-title"><a :href="'/manga/'+toSlug(manga.title)">{{manga.title}}</a></p>
        <p class="m-hits"><q-icon color="lime-14" name="remove_red_eye"/> {{formatNum(manga.hits)}}</p>
        <p class="m-chapters">
          <q-icon color="lime-14" name="book"/> {{manga.chapters_len}}
        </p>
        <p class="m-status">
          <q-icon color="lime-14" name="graphic_eq"></q-icon>
          {{convertStatus(manga.status)}}
        </p>
        <p class="m-released">
          <q-icon color="lime-14" name="calendar_today"></q-icon>
          {{manga.released ? manga.released : '?'}}
        </p>
        <span class="m-desc row col-xs-12" v-html="manga.description.length > 150 ? manga.description.substr(0, 150) +'...' : manga.description"></span>
      </span>
      <div v-else class="paddout content"></div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueObserveVisibility from 'vue-observe-visibility';
import Strings from '../../mixins/strings.js';

Vue.use(VueObserveVisibility);

export default {
  mixins: [Strings],
  props: {
    manga: {},
    viewAs: {},
  },
  data() {
    return {
      isVisible: false,
      observer: null,
    }
  },
  computed: {},
  created() {},
  methods: {
    visibilityChanged(isVisible, entry) {
      //lazy load images
      if(isVisible) {
        this.isVisible = true;
      }
    },
  }
}
</script>
