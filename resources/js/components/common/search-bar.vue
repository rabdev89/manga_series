<style scoped>
  .search-container {
    padding-left: 15px;
    padding-right: 15px;
    margin: 15px 0;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .search-container {
      width: 90%;
      margin: 0 auto;
    }
  }
  /*Medium devices*/
  @media (min-width: 1439px) {
    .search-container {
      width: 1170px;
    }
  }
</style>
<template>
  <div class="search-container">
    <q-input input-style="background-color:#233a50;color:white;" color="white" bottom-slots v-model="searchText" label="Search" counter maxlength="100">
      <template v-slot:append>
        <q-icon name="search" color="white"/>
      </template>
    </q-input>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      searchText:'',
    }
  },
  computed: {},
  created() {},
  mounted() {},
  methods: {}
}
</script>
