<script>
export default {
  name: "ApartmentCard",

  props: {
    apartment: Object
  }
}
</script>

<template>
  <div class="col">
    <a href="#">
      <div class="apartment-card mb-4">

        <div class="apartment-img mb-2">
          <img :src="apartment.img_path" alt="" onerror=" this.src = '/img/placeholder.webp' ">
        </div>

        <div class="apartment-text">
          <h6 class="mb-1">{{ apartment.title }}</h6>
          <p class="address">{{ apartment.address }}</p>
          <p><span class="fw-semibold fs-6">{{ apartment.price }} &euro;</span> a notte</p>
        </div>

      </div>
    </a>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../../scss/partials/variables" as *;

.apartment-card {
  color: $dark_gray;
  .apartment-img {
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1;

    &:hover img {
      transform: scale(1.05);
    }

    img {
      height: 100%;
      object-position: center;
      transition: all 0.3s;
    }
  }

  .apartment-text {

    p {
      font-size: 0.9rem;
    }

    .address {
      display: block;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }

}
</style>
