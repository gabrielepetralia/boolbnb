<script>
export default {
  name: "MainSearchbar"
}
</script>

<template>
  <p></p>
  <div class="d-flex align-items-center">
    <input class="searchbar me-2" type="text" name="searchbar" placeholder="Inserisci una località">
    <button class="btn t4-btn btn-search d-flex justify-content-center align-items-center" name="btn_search"><i class="fa-solid fa-magnifying-glass"></i></button>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.searchbar {
  height: 40px;
  width: 300px;
  padding: 0 20px;
  border-radius: 50px;
  border: 0;
  margin-left: 58px;
}
.btn-search {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  padding: 10px;
}
</style>
