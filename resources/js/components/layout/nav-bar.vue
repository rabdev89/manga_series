<style scoped>
  .navbar-contain {
    background-color:#0f2133;
  }
  a {
    color: grey;
    font-weight: bold;
    text-decoration: none;
  }
  .menu-items a {
    padding:0 15px;
    color:#dadada;
  }
  a:hover {
    color:#aeea00;
  }
  .homelink {
    color:white;
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
        <a href="/" class="homelink">
          <q-avatar>
            <img src="/img/logo.png">
          </q-avatar>
        </a>
      </div>
     <q-toolbar-title><a href="/" class="homelink">Manga Series</a></q-toolbar-title>
      <div class="menu-items gt-sm">
        <a href="/manga/categories/all">MANGA LIST</a>
        <a href="/manga/categories/hot">HOT MANGA</a>
        <a href="/manga/categories/latest">LATEST RELEASES</a>
        <a href="/advanced-search">ADVANCED SEARCH</a>
      </div>
      <!-- Hamburger Dropdown -->
      <q-btn-dropdown class="lt-md" flat icon="menu" menu-self="top right" icon-right :content-style="{width:'100vw'}">
        <q-list>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/all">MANGA LIST</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/hot">HOT MANGA</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/manga/categories/latest">LATEST RELEASES</a></q-item-label>
            </q-item-section>
          </q-item>
          <q-item>
            <q-item-section>
              <q-item-label><a href="/advanced-search">ADVANCED SEARCH</a></q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-toolbar>
  </div>
</template>

<script>
export default {}
</script>
