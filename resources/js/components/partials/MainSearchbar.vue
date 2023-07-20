<script>
import { store } from '../../store/store';
export default {
  name: "MainSearchbar",

  data(){
    return {
      store,
      search: '',
    }
  },

  methods: {
  selectAddressToSearch(suggest) {
    this.search = suggest.address.freeformAddress;
    store.showSuggestions = false;
  }

  }
}
</script>

<template>
  <p></p>
  <div class="d-flex align-items-center position-relative">
    <input
      v-model="search"
      @input="store.getSuggestions(this.search)"
      class="searchbar me-2"
      type="text"
      name="searchbar"
      placeholder="Inserisci una località">

      <div class="autocomplete-box">
        <ul v-if="store.showSuggestions">
          <li
            v-for="(suggest, index) in store.suggestions"
            :key="index"
            @click="this.selectAddressToSearch(suggest)">
            {{ suggest.address.freeformAddress }}
          </li>
        </ul>
      </div>


    <button class="btn t4-btn btn-search d-flex justify-content-center align-items-center" name="btn_search">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.searchbar {
  color: $dark-gray;
   font-size: 0.95rem;
  height: 40px;
  width: 300px;
  padding: 0 20px;
  border-radius: 50px;
  border: 0;
  margin-left: 58px;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

  &:focus {
    border: none;
    outline: 1px solid $light_blue;
  }
}
.btn-search {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  padding: 10px;
}

.autocomplete-box {
  z-index: -1;
  position: absolute;
  top: 50%;
  left: 14%;
  background-color: white;
  color: $dark-gray;
  width: 72.2%;
  border-radius: 0 0 12px 12px;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  overflow: hidden;

  ul {
    padding-top: 21px;
    li {
      display: block;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 0.9rem;
      padding: 12px 18px;
      border-bottom: 1px solid $dark_white;
      transition: all 0.3s;

      &:hover {
        background-color: $dark_white;
        cursor: pointer;
      }

    }
  }
}
</style>
