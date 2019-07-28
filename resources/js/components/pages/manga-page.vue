<style scoped>
  .manga-page {
    font-family: 'Dosis', sans-serif;
    color: #ffffff;
  }
  h2 {
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
    line-height: 3rem;
  }
  h5 {
    padding: 15px;
    margin: 30px 0;
    font-size: 30px;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 1px solid;
  }
  
  .details-contain {
    margin-bottom: 30px;
  }

  .content-row {
    padding: 10px 0;
    border-top:1px solid white;
    border-top:1px solid #ffffff59;
  }
  .content-row div:first-child {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 17px;
  }
  .content-row div:first-child div {
    margin-left:5px;
  }

  .category span {
    padding: 5px;
    background: rgb(35, 58, 80);
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

  .chapters-contain {
    background-color: #0b1a2a;
    border: 3px solid #0f2133;
  }
  .chapters-contain a {
    font-size:17px;
    color:#4280bf;
  }
  .chapter-item {
    border-top:1px solid white;
    border-top:1px solid #ffffff59;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    h2 {
      font-size: 24px;
    }
    .details-contain {
      padding-left: 25px;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .manga-page {
      margin:0 auto;
      width: 1170px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div v-if="manga" class="manga-page">
    <div class="container row items-center">
      <div class="col-xs-12 col-sm-4">
        <h2><q-icon size="30px" color="red-13" name="label_important"></q-icon> {{manga.title}}</h2>
        <img :src="manga.imageURL ? manga.imageURL : 'https://cdn.mangaeden.com/mangasimg/'+manga.image" width="100%"/>
      </div>
      <!-- Details -->
      <div class="details-contain col-xs-12 col-sm-8">
        <div class="row items-center lt-sm">
          <q-icon size="30px" color="red-13" name="label_important"></q-icon>
          <h5>Details</h5>
        </div>
        <div class="content-row row justify-between" style="border-top:none">
          <div class="row items-center">
            <q-icon color="lime-14" name="book"></q-icon>
            <div>Other Name(s):</div>
          </div>
          <div>
            <span v-for="(aka, i) in manga.aka" :key="aka">
              <span v-html="aka"></span>
              <span>{{i !== (manga.aka.length - 1) ? ', ' : ''}}</span>
            </span>
          </div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="event"></q-icon>
            <div>Released:</div>
          </div>
          <div>{{manga.released}}</div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="person"></q-icon>
            <div>Author:</div>
          </div>
          <div>{{manga.author}}</div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="brush"></q-icon>
            <div>Artist:</div>
          </div>
          <div>{{manga.artist}}</div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="category"></q-icon>
            <div>Categories:</div>
          </div>
          <div class="category">
            <span v-for="(c, i) in manga.categories" :key="c+''+i" :class="c.replace(/ /g,'-').toLowerCase()">{{c}}</span>
          </div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="graphic_eq"></q-icon>
            <div>Status:</div>
          </div>
          <div>{{convertStatus(manga.status)}}</div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="remove_red_eye"></q-icon>
            <div>Views:</div>
          </div>
          <div>{{formatNum(manga.hits)}}</div>
        </div>
        <div class="content-row row justify-between">
          <div class="row items-center">
            <q-icon color="lime-14" name="info"></q-icon>
            <div>Description:</div>
          </div>
          <div style="padding: 10px;" v-html="manga.description"></div>
        </div>
      </div>
      <!-- Chapters -->
      <div class="chapters-contain col-xs-12">
        <div class="row items-center">
          <q-icon size="30px" color="red-13" name="label_important"></q-icon>
          <h5>Chapters</h5>
        </div>
        <q-list bordered>
          <q-item v-for="(chapter, i) in manga.chapters" :key="'chapter'+chapter[3]" class="chapter-item" :style="i == 0 ? 'border-top:none' : ''">
            <q-item-section>
              <a :href="'/manga/'+toSlug(manga.title)+'/chapter/'+chapter[0]">
                <q-item-label v-if="chapter[0] != chapter[2]">
                  <q-icon color="primary" name="book"></q-icon>
                  #{{chapter[0]}} {{chapter[2]}}
                </q-item-label>
                <q-item-label v-else>
                  <q-icon color="primary" name="book"></q-icon>
                  Chapter #{{chapter[0]}}
                </q-item-label>
              </a>
            </q-item-section>
            <q-item-section side middle>
              <q-item-label style="color:white" caption><q-icon color="white" name="calendar_today"></q-icon> {{formatDate(chapter[1])}}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </div>
    </div>
    
  </div>
</template>

<script>
import Fetcher from '../../mixins/fetcher.js';
import Strings from '../../mixins/strings.js';

export default {
  mixins:[Fetcher, Strings],
  props: {
    slug: {},
  },
  data() {
    return {
      manga:null,
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
      }
    });
  },
}
</script>
