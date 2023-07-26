<script>
export default {
  name: "SponsorshipCard",

  // props: {
  //   apartment: Object,
  // }
}
</script>

<template>
  <div class="col px-0 px-md-5">
    <div class="sponsorship-card mb-5 p-4">

      <div class="card-header">
        <h5 class="fw-semibold text-center mt-2 mb-3 name">Bronze</h5>
        <div class="price-container text-center pb-3">
          <span class="euro">&euro; </span>
          <span class="price fw-semibold"> 2.99</span>
        </div>
      </div>

      <div class="card-body px-4">
        <ul>
          <li class="d-flex align-items-center mt-5 mb-4">
            <div>
              <div class="check me-3"><i class="fa-solid fa-check"></i></div>
            </div>
            <p>Durata sponsorizzazione di 24h</p>
          </li>
          <li class="d-flex align-items-center mb-4">
            <div>
              <div class="check me-3"><i class="fa-solid fa-check"></i></div>
            </div>
            <p>Mostra appartamento in evidenza</p>
          </li>
          <li class="d-flex align-items-center mb-5">
            <div>
              <div class="check me-3"><i class="fa-solid fa-check"></i></div>
            </div>
            <p>Mostra appartamento in alto tra i risultati</p>
          </li>
        </ul>

        <div class="d-flex justify-content-center mb-3">
          <button class="btn btn-login t4-btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#apartments-modal">
            <i class="fa-solid fa-circle-dollar-to-slot me-2 fs-6"></i>
            <span class="me-1">Sponsorizza</span>
          </button>
        </div>

      </div>

    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../../scss/partials/variables" as *;

.sponsorship-card {
  background-color: $dark-gray;
  color: $dark-white;
  border-radius: 12px;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  transition: all 0.2s;

  &:hover {
    transform: scale(1.05)
  }

  &:hover .name {
    color: $light-blue;
  }

  .price-container {
    border-bottom: 2px solid $dark-white;

    .euro {
      font-size: 1.5rem;
    }
    .price {
      font-size: 3rem;
    }
  }

  .check {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 25px;
    height: 25px;
    font-size: 0.9rem;
    border-radius: 50%;
    background-color: $light-blue;
  }
}

</style>
