<style scoped>
  .m-content {
    padding:10px;
  }
  .p {
    margin-bottom:5px;
  }
  .m-content.list .m-category,
  .m-content.list .m-title {
    display:none;
  }
  .m-title.list {
    padding-left: 5px;
    padding-top: 5px;
  }
  .m-title {
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
  <div v-observe-visibility="visibilityChanged">
    <div :class="['img-contain', viewAs == 'list' ? 'hidden' : 'col']">
      <img v-show="isVisible" :src="'https://cdn.mangaeden.com/mangasimg/'+manga.im" width="100%"/>
    </div>
    <p v-show="viewAs == 'list'" class="m-title list col-12"><a href="/manga/">{{manga.t}}</a></p>
    <div :class="['m-content', viewAs, viewAs == 'list' ? 'row justify-around col-12' : 'col']">
      <p class="m-title"><a href="/manga/">{{manga.t}}</a></p>
      <p class="m-hits"><q-icon name="remove_red_eye"/> {{formatNum(manga.h)}}</p>
      <p class="m-category" v-if="manga.c.length">
        <q-icon name="category"/>
        <span v-for="(c, i) in manga.c" v-if="i < 2">
          {{c}}{{i < 1 && c.length > 1 ? '/' : ''}}
        </span>
      </p>
      <p class="m-lt"></p>
      <p class="m-status">{{convertStatus(manga.s)}}</p>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueObserveVisibility from 'vue-observe-visibility';

Vue.use(VueObserveVisibility);
export default {
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
  mounted() {},
  methods: {
    visibilityChanged(isVisible, entry) {
      //lazy load images
      if(isVisible) {
        this.isVisible = true;
      }
    },
    convertStatus(status) {
      return 'On Going';
    },
    formatNum(num) {
      num = num.toString();
      if(num.length == 4) {
        return num[0]+','+num.substr(1, 3);
      } else if(num.length == 5) {
        return num.substr(0, 2) +','+num.substr(2, 4);
      } else if(num.length == 6) {
        return num.substr(0, 3) +','+num.substr(3, 5);
      } else if(num.length == 7) {
        return num[0] +','+num.substr(1, 3) +','+num.substr(4, 6);
      }
      return num;
    },
  }
}
</script>
