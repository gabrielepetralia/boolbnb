<script>
export default {
  name: "Aside"
}
</script>

<template>
  <aside>
    <ul class="list-unstyled">
      <li>
        <router-link :to="{ name: 'apartments' }" class="fw-semibold"><i class="fa-solid fa-house me-2"></i> Apartments</router-link>
      </li>
      <li>
        <router-link :to="{ name: 'messages' }" class="fw-semibold"><i class="fa-solid fa-envelope me-2"></i> Messages</router-link>
      </li>
    </ul>
  </aside>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

aside {
  height: 100%;
  min-width: 250px;
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

      &:hover,
      &.active {
        border-left: 5px solid $light_blue;
        background-color: $gray;
      }
    }
  }
}
</style>
