<style scoped>
  .advanced-search-container {
    margin-top: 15px;
    color:white;
    font-family: 'Dosis', sans-serif;
    background-color: #0b1a2a;
    border: 3px solid #0f2133;
  }

  h1 {
    font-weight: bold;
    text-transform: uppercase;
    font-size:25px;
  }
  .input {
    background-color: rgb(35, 58, 80);
    color:white;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .advanced-search-container {
      padding-left: 15px;
      padding-right: 15px;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .advanced-search-container {
      margin:0 auto;
      width: 1170px;
    }
  }
  /*Large devices*/
  @media (min-width: 1919px) {
  }
</style>
<template>
  <div class="advanced-search-container">
    <h1><q-icon name="label" color="red-13"></q-icon> Advanced Search</h1>
    <div class="form-container">
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
          filled
          input-style=" background:rgb(35, 58, 80);"
          color="white"
          v-model="aka"
          label="Title/Name"
          hint="Attack on Titan/進撃の巨人"
        />
        <q-input
          filled
          input-style=" background:rgb(35, 58, 80);"
          color="white"
          v-model="author"
          label="Author"
          hint=""
        />

        <q-input
          filled
          input-style=" background:rgb(35, 58, 80);"
          color="white"
          v-model="artist"
          label="Artist"
          hint=""
        />

        <q-input
          filled
          input-style=" background:rgb(35, 58, 80);"
          color="white"
          v-model="released"
          label="Release Date"
          hint="2019, 1993"
        />

        <div>
          <q-btn label="Submit" type="submit" color="positive"/>
          <q-btn label="Reset" type="reset" color="red-14" flat class="q-ml-sm" />
        </div>
      </q-form>
    </div>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      aka: '',
      author: '',
      artist: '',
      released: '',
    }
  },
  computed: {},
  created() {},
  mounted() {},
  methods: {
    onSubmit() {
      let params = '';
      if(this.aka.length) {
        params += '/aka/'+this.aka;
      }
      if(this.author.length) {
        params += '/author/'+this.author;
      }
      if(this.artist.length) {
        params += '/artist/'+this.artist;
      }
      if(this.released.length) {
        params += '/released/'+this.released;
      }
      if(!params.length) {
        alert('Please enter something in at least one field.');
      } else {
        window.location.href = '/advanced-search/results'+params;
      }
    },
    onReset() {
      this.aka = '';
      this.author = '';
      this.artist = '';
      this.released = '';
    }
  }
}
</script>
