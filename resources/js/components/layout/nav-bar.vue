<style scoped>
  .navbar-contain {
    background-color:#0f2133;
  }
  a {
    color: grey;
    text-decoration: none;
  }
  .menu-items a {
    padding:0 15px;
  }
  /*Small devices*/
  @media (min-width: 600px) {
    .navbar-contain {
      background-color:transparent;
      padding: 15px;
    }
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
  <div class="navbar-contain">
    <q-toolbar class="text-white justify-between">
      <div>
        <q-avatar>
          <img src="/img/logo.png">
        </q-avatar>
      </div>
      <q-toolbar-title>Manga Series</q-toolbar-title>
      <div class="menu-items">
        <a href="/">MANGA LIST</a>
        <a href="/">HOT MANGA</a>
        <a href="/">LATEST RELEASES</a>
        <a href="/">ADVANCED SEARCH</a>
      </div>
      <!-- Hamburger Dropdown -->
      <q-btn-dropdown class="lt-md" flat icon="menu" menu-self="top right" icon-right :content-style="{width:'100vw'}">
        <q-list>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/">MANGA LIST</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/">HOT MANGA</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/">LATEST RELEASES</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/">ADVANCED SEARCH</a></q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-toolbar>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {

    }
  },
  computed: {},
  created() {},
  mounted() {},
  methods: {}
}
</script>
