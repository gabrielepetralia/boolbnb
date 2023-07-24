<script>
export default {
  name: "ApartmentCard",

  props: {
    apartment: Object,
    link_name: String
  }
}
</script>

<template>
  <div class="col">
    <router-link :to="{ name: link_name, params: { slug: apartment.slug } }">
      <div class="apartment-card mb-4">

        <div class="apartment-img mb-2">
          <img :src="apartment.img_path ? apartment.img_path : '/img/house-placeholder.png'" alt="">
        </div>
        <div class="apartment-text">
          <h6 class="mb-1 fw-semibold">{{ apartment.title }}</h6>
          <p class="address">{{ apartment.address }}</p>
          <p><span class="fw-semibold fs-6">{{ apartment.price }} &euro;</span> a notte</p>
        </div>

      </div>
    </router-link>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../../scss/partials/variables" as *;

.apartment-card {
  color: $dark_gray;
  border-radius: 12px;
  transition: all 0.2s;

  &:hover {
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  }

  .apartment-img {
    display: flex;
    justify-content: center;
    align-items: center;
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
    padding: 10px 15px;
    padding-top: 0;

    p {
      font-size: 0.9rem;
    }

    .address, h6 {
      display: block;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }

}
</style>
