<style scoped>
  .manga-card {
    text-align: left;
    height:400px;
    background-repeat: no-repeat;
    background-size: cover;
  }
  .overlay {
    width:100%;
    height:100%;
    background-color:transparent;
    background-color: #00000087;
  }
  .title {
    margin: 10px 0px;
    font-weight: bold;
    text-transform: uppercase;
  }
  .content {
    color: white;
    padding: 15px;
    width: 85%;
    margin: 0 auto;
  }
  .category span {
    padding: 5px;
    background: blue;
    margin: 5px;
    display: inline-block;
    border-radius: 5px;
    font-family: 'Dosis', sans-serif;
    font-size: 12px;
    color: #ffffff;
    font-weight: 700;
    text-transform: uppercase;
  }
  .category span.action {
    background:#ce0808;
  }
  .category span.fantasy {
    background:green;
  }
  .category span.comedy {
    background:#f5b50a;
  }
  .category span.adventure {
    background:#1692bb;
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
  /*Extra large devices*/
  @media (min-width: 1920px) { }
</style>
<template>
  <div class="manga-card" :style="img">
    <div class="overlay column justify-end">
      <div class="content">
        <h5 class="title">{{manga.t}}</h5>
        <p class="category" v-if="manga.c.length"><span :class="manga.c[0].replace(/ /g,'-').toLowerCase()">{{manga.c[0]}}</span></p>
        <p class="chapterDate">{{manga.ld}}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    manga: {},
  },
  data() {
    return {
      //img: {backgroundImage:'url(https://cdn.mangaeden.com/mangasimg/ee/eeb235371255db3a5ee15e7b26e375bfeebd0457cec8efd041d0a013.jpg)'},
      img:{backgroundImage:'url(https://cdn.mangaeden.com/mangasimg/'+this.manga.im}
    }
  },
  computed: {},
  created() {},
  mounted() {},
  methods: {}
}
</script>
