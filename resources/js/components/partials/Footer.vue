  <script>
  import footer_menu from '../../data/footer-db';
  export default {
    name: 'Footer',
    data(){
      return {
        footer_menu
      }
    }
  }
  </script>
<template>
  <footer>
    <div class="t4-container">

      <div class="footer-top pt-5 pb-4">
        <div class="row d-flex justify-content-between">
          <div v-for="(menu, index) in footer_menu" :key="index" class="col">

            <h5 class="fw-semibold mb-3">{{ menu.title }}</h5>

            <ul>

              <li v-for="(link, index) in menu.links" :key="index" class="mb-2">
                <a class="fw-normal" :href="link.href">{{ link.name }}</a>
              </li>

            </ul>
          </div>
        </div>
      </div>


    </div>
    <hr class="m-0">
    <div class="footer-btm py-3">
      <div class="t4-container d-flex justify-content-between">
        <div class="left">
          <ul class="d-flex">
            <li>
              <span>&copy; BoolBnB, Inc.</span>
            </li>
            <li>
              <a href="">Privacy</a>
            </li>
            <li>
              <a href="">Termini</a>
            </li>
            <li>
              <a href="">Mappa del sito</a>
            </li>
            <li>
              <a href="">Dettagli dell'azienda</a>
            </li>
          </ul>
        </div>
        <div class="right">
          <ul class="d-flex align-items-center">
            <li class="lang">
              <i class="fa-solid fa-globe icon globe"></i>
              <a class="d-flex align-items-center" href="#">
                <span class="language">Italiano</span>
              </a>
            </li>
            <li>
              <span>&euro; </span>
              <a href="#">
                <span> EUR</span>
              </a>
            </li>
            <li class="d-flex align-items-center">
              <a class="d-flex align-items-center" href="#"><i class="fa-brands fa-instagram icon"></i></a>
            </li>
            <li>
              <a class="d-flex align-items-center" href="#"><i class="fa-brands fa-square-facebook icon"></i></a>
            </li>
            <li>
              <a class="d-flex align-items-center" href="#"><i class="fa-brands fa-square-twitter icon"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>


<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
footer {
  background: $dark-gray;
  color: $dark-white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

  a {
    color: $dark-white;
    font-size: 0.8rem;

    &:hover {
      color: $light-blue;
      text-decoration: underline;
    }
  }
  .footer-btm {
    .language {
      margin-left: .5rem;
    }
    span {
      font-size: .8rem;
    }

    .left {

      li:not(:last-child) {

        &:after {
          content: '-';
          margin: 10px;
        }

      }

    }

    .right {
      .lang {
        line-height: 20px;
      }
      span {
        font-size:1rem ;
      }
      .icon {
        font-size: 1.2rem;
      }
      .globe {
        float: left;
      }
      li:not(:last-child) {
        margin-right: 15px;
      }
    }
  }

}
</style>

<!-- <i class="fa-brands fa-instagram"></i> instagram-->
<!-- <i class="fa-brands fa-square-facebook"></i> facebook -->
<!-- <i class="fa-brands fa-square-twitter"></i> twitter -->
<!-- <i class="fa-solid fa-globe"></i> globe -->
