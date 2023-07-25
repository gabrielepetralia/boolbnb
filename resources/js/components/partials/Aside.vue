<script>
export default {
  name: "Aside"
}
</script>

<template>
  <aside>
    <ul class="list-unstyled">
      <li>
        <router-link :to="{ name: 'apartments' }" class="fw-semibold">
          <i class="fa-solid fa-house me-2"></i>
          <span class="aside-link-text">Appartamenti</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'messages' }" class="fw-semibold">
          <i class="fa-solid fa-envelope me-2"></i>
          <span class="aside-link-text">Messaggi</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'stats' }" class="fw-semibold">
          <i class="fa-solid fa-chart-line me-2"></i>
          <span class="aside-link-text">Statistiche</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'sponsorships' }" class="fw-semibold">
          <i class="fa-solid fa-circle-dollar-to-slot me-2"></i>
          <span class="aside-link-text">Sponsorizzazioni</span>
        </router-link>
      </li>
    </ul>
  </aside>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

aside {
  height: 100%;
  min-width: 280px;
  background-color: $dark_gray;

  li {
    a {
      display: inline-block;
      height: 100%;
      width: 100%;
      color: white;
      font-size: 1rem;
      border-left: 5px solid transparent;
      padding: 15px;
      transition: all 0.3s;

      &:hover,
      &.active {
        border-left: 5px solid $light_blue;
        background-color: $gray;
      }
    }
  }
}

// media-query
@media screen and (max-width: 1200px) {
  aside{
    min-width: 55px;
    .aside-link-text {
      display: none;
    }

  }
}
</style>
