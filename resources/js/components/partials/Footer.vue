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
      <!-- footer top -->
      <div class="footer-top pt-5 pb-4">
        <div class="row d-flex justify-content-between">
          <div v-for="(menu, index) in footer_menu" :key="index" class="col-12 col-md-5 col-lg-3 footer-link">

            <h5 class="fw-semibold mb-3">{{ menu.title }}</h5>

            <ul>

              <li v-for="(link, index) in menu.links" :key="index" class="mb-2">
                <a class="fw-normal" :href="link.href">{{ link.name }}</a>
              </li>

            </ul>
          </div>
        </div>
      </div>
      <!-- /footer top -->

    </div>
    <hr class="m-0">
    <!-- footer bottom -->
    <div class="footer-btm py-3">
      <div class="t4-container d-block d-lg-flex justify-content-between">
        <div class="left">
          <ul class="d-flex footer-btm-left">
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
          <ul class="d-flex align-items-center footer-btm-right">
            <li class="lang d-flex align-items-center">
              <i class="fa-solid fa-globe icon"></i>
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
              <a class="d-flex align-items-center icon-link" href="#"><i class="fa-brands fa-instagram icon"></i></a>
            </li>
            <li>
              <a class="d-flex align-items-center icon-link" href="#"><i class="fa-brands fa-square-facebook icon"></i></a>
            </li>
            <li>
              <a class="d-flex align-items-center icon-link" href="#"><i class="fa-brands fa-square-twitter icon"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- /footer bottom -->
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
      margin-left: 0.5rem;
    }
    span {
      font-size: 0.8rem;
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
      span {
        font-size:0.95rem ;
      }

      .icon {
        font-size: 1.2rem;
      }

      .icon-link:hover {
        text-decoration: none;
      }

      li:not(:last-child) {
        margin-right: 15px;
      }
    }
  }

}
//media-query
@media screen and (max-width: 992px) {
.footer-link {
  margin-bottom: 30px;
  border-bottom: 1px solid $dark-white;
  padding-bottom: 10px;
}
.footer-btm-left, .footer-btm-right {
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 15px;
}
}
</style>
