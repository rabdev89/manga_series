<style scoped>

  .m-card-detail-contain {
    color:white;
    font-family: 'Dosis', sans-serif;
  }

  .col img {
    display: block;
    height: 193px!important;
    width: 134px!important;
  }


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


  .grid  .img-contain img {
      width: 100%;
      display: block;
      height: 185px!important;
      width: 125px!important;
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
  <transition appear appear-active-class="fade-enter-active">
    <div class="m-card-detail-contain " :class="[viewAs]" v-observe-visibility="visibilityChanged">

      <div v-if="viewAs == 'grid'" class="row">
        <div :class="['img-contain col-2']">
          <img v-if="isVisible && manga" :src="'https://cdn.mangaeden.com/mangasimg/'+manga.image" />
          <div v-else-if="+manga && !isVisible" class="row justify-center items-center">
            <q-spinner-cube color="indigo" size="2rem" />
          </div>
          <div v-else class="paddout image"></div>
        </div>

        <div :class="['m-content grid col-10']">
          <span v-if="manga">
            <p class="m-title"><a :href="'/manga/'+toSlug(manga.title)">{{manga.title}}</a></p>
            <p class="m-hits"><q-icon color="lime-14" size="17px" name="remove_red_eye"/> {{formatNum(manga.hits)}}</p>
            <p class="m-chapters">
              <q-icon color="lime-14" size="17px" name="book"/> {{manga.chapters_len}}
            </p>
            <p class="m-chapters">
              <q-icon color="lime-14" size="17px" name="fiber_new"/> {{manga.chapters.length > 0 ? formatDate(manga.last_chapter_date) : 'N/A'}}
            </p>
            <p class="m-status">
              <q-icon color="lime-14" size="17px" name="graphic_eq"></q-icon>
              {{convertStatus(manga.status)}}
            </p>
            <p class="m-released">
              <q-icon color="lime-14" size="17px" name="calendar_today"></q-icon>
              {{manga.released ? manga.released : '?'}}
            </p>
            <span class="m-desc row col-xs-12" v-html="manga.description.length > 150 ? manga.description.substr(0, 150) +'...' : manga.description"></span>
          </span>
          <div v-else class="paddout content"></div>
        </div>
      </div>

      <div v-if="viewAs == 'list'" class=" col-xs-12 col-md-12">
        <p v-if="manga" class="m-title list col-12"><a :href="'/manga/'+toString(manga.title)">{{manga.title}}</a></p>

        <div :class="['m-content row col-12']">
          <span v-if="manga">

            <p class="m-chapters">
              <q-icon color="lime-14" size="17px" name="fiber_new"/> {{manga.chapters.length > 0 ? formatDate(manga.last_chapter_date) : 'N/A'}}
            </p>
            <p class="m-status">
              <q-icon color="lime-14" size="17px" name="graphic_eq"></q-icon>
              {{convertStatus(manga.status)}}
            </p>


          </span>
          <div v-else class="paddout content"></div>
        </div>

      </div>



    </div>
  </transition>
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
