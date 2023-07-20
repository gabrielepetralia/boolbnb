<script>
import axios from "axios";
import tt from '@tomtom-international/web-sdk-maps';
export default {
name: 'ApartmentDetailAdmin',
data(){
  return {
    apiUrl: 'https://api.tomtom.com/search/2/',
    apiKey: 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ',
    _map: {
      lat: null,
      lon: null
    },
  }
},
methods: {
  getMap(){
    axios.get( this.apiUrl + 'geocode/rome.json?view=Unified&key='+ this.apiKey )
    .then(result => {

      this._map.lat = result.data.results[0].position.lat;
      this._map.lon = result.data.results[0].position.lon;

      tt.setProductInfo("maps", "1");

      var map = tt.map({
        key: "gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ",
        container: "map",
        center: [this._map.lon, this._map.lat],
        zoom: 16

      })
    })
  },
},
mounted(){
  this.getMap()
}
  }
</script>

<template>
<div class="t4-container py-5 px-5 apartment-detail">
  <div class="d-flex justify-content-between my-4">
    <h2 class="fs-3 mb-0 title">Nome Appartamento</h2>
    <div>
      <button title="Modifica Appartamento" class="btn t4-btn btn-add me-2" data-bs-toggle="modal" data-bs-target="#add-apartment-modal"><i class="fa-solid fa-pencil"></i></button>
      <button title="Aggiungi Appartamento" class="btn t4-btn btn-add" data-bs-toggle="modal" data-bs-target="#add-apartment-modal"><i class="fa-solid fa-trash"></i></button>
    </div>
  </div>
  <div class="row row-cols-2">
    <div class="col pe-4">
      <div class="img-wrapper">
        <img class="w-100 mb-3" src="" onerror=" this.src = '/img/house-placeholder.png' " alt="">
        <div class="price">
          <p><span class="fw-semibold fs-4">199.01 &euro;</span> a notte</p>
        </div>
      </div>
    </div>
    <div class="col ps-4">
      <h4>Descrizione :</h4>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident voluptatibus pariatur vero sapiente culpa nesciunt? Ea vel et impedit porro? Beatae corrupti, voluptatibus quibusdam maxime magnam modi minus quia excepturi ipsa explicabo, omnis assumenda similique ducimus id reprehenderit ad repudiandae perspiciatis accusamus inventore totam quisquam? Perferendis quae, neque molestias at saepe possimus vel iure sed? Voluptatem voluptatibus, itaque fugit accusamus, vero rerum dolores laborum omnis quo quae minima odio similique nisi quas ad earum, est maiores? Magni ullam delectus temporibus blanditiis repellendus obcaecati velit voluptas adipisci quis modi unde soluta perferendis molestias inventore quisquam optio illo, ipsum nisi quae accusantium</p>
      <hr>
      <h4>Dettagli :</h4>
      <ul class="d-flex details">
        <li>
          <i class="fa-solid fa-door-open"></i>
          <span>2</span>
        </li>
        <li>
          <i class="fa-solid fa-bed"></i>
          <span>3</span>
        </li>
        <li>
          <i class="fa-solid fa-bath"></i>
          <span>2</span>
        </li>
        <li>
          <i class="fa-solid fa-expand"></i>
          <span>80 mt<sup>2</sup> </span>
        </li>
      </ul>
      <hr>
      <h4>Servizi :</h4>
      <ul class="d-flex">
        <li>servizio</li>
        <li>servizio</li>
        <li>servizio</li>
        <li>servizio</li>
        <li>servizio</li>
      </ul>
    </div>
  </div>
  <hr class="my-4">
  <h4>Mappa :</h4>
  <div class="map my-3">
    <div id="map"></div>
  </div>
  <h5>Via delle vie 94</h5>
</div>
</template>


<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.apartment-detail {
  font-size: 0.95rem;
  color: $dark-gray;

  img {
    border-radius: 15px;
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  }

  li:not(:last-child) {
    &:after {
      content: '-';
      margin: 10px;
    }
  }

  .details {
    i {
      margin-right: 7px;
    }
  }

  #map {
    width: 100%;
    height: 300px;
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
    border-radius: 15px;
    overflow: hidden;
  }
}
</style>
