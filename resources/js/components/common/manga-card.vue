<style scoped>
  .manga-card {
    text-align: left;
    height:400px;
    background-repeat: no-repeat;
    background-size: cover;
    transition: all 1s;
  }
  .manga-card.hovering {
    transform: scale(1.1);
  }
  .overlay {
    width:100%;
    height:100%;
    background-color:transparent;
    background-color: #00000047;
  }
  .title {
    margin: 10px 0px;
    font-weight: bold;
    text-transform: uppercase;
  }
  .content {
    color: white;
    padding: 15px 0 0 0;
    width: 85%;
    margin: 0 auto;
  }
  .category span {
    padding: 5px;
    background: rgb(35, 58, 80);
    display: inline-block;
    border-radius: 5px;
    font-family: 'Dosis', sans-serif;
    font-size: 8px;
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
  .hovering {
    color:#dcf836;
  }


  /*Small devices*/
  @media (min-width: 600px) {
    .manga-card {
      margin:0 10px;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .manga-card {
      margin:0 20px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
  /*Extra large devices*/
  @media (min-width: 1920px) { }
</style>
<template>
  <div :class="['manga-card', hovering ? 'hovering' : '']" :style="img" @mouseenter="hovering = true" @mouseleave="hovering = false">
    <div class="overlay column justify-end">
      <a :href="'/manga/'+toSlug(manga.title)">
        <div class="content">
          <h7 :class="['title', hovering ? 'hovering' : '']" >{{manga.title}}</h7>
          <p class="category" v-if="manga.categories.length"><span :class="toSlug(manga.categories[0])">{{manga.categories[0]}}</span></p>

        </div>
      </a>
    </div>
  </div>
</template>

<script>
import Strings from '../../mixins/strings.js';
export default {
  mixins:[Strings],
  props: {
    manga: {},
  },
  data() {
    return {
      hovering:false,
      //img: {backgroundImage:'url(https://cdn.mangaeden.com/mangasimg/ee/eeb235371255db3a5ee15e7b26e375bfeebd0457cec8efd041d0a013.jpg)'},
      img:{backgroundImage:'url('+(this.manga.imageURL ? this.manga.imageURL : 'https://cdn.mangaeden.com/mangasimg/'+this.manga.image)+')'}
    }
  },
}
</script>
