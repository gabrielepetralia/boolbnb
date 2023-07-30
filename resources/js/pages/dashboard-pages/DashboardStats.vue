<script>

import { Line } from 'vue-chartjs'
import Loader from "../../components/partials/Loader.vue";

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import  axios  from 'axios'
import { store } from '../../store/store'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)
export default {
  name: "DashboardStats",

  components: {
    Line,
    Loader
   },

  data() {
    return {
      store,
      new_views : 0,
      counter: 0,
      apartments: [],
      mainLoading : true,
      loading: true,
      datas: [],
      chartData: {},
      chartOptions: {
        responsive: true,

      }
    }
  },

  methods: {
    getMyApartments() {
      this.mainLoading = true;
      axios.get("sanctum/csrf-cookie").then(() => {
        axios.get(`/admin/${store.user.id}`).then((result) => {
          this.apartments = result.data.apartments;
          this.mainLoading = false;
          this.getApartmentViews(this.apartments[0].id)
        });
      });
    },

    getApartmentViews(apartment_id){
      this.loading = true
      this.datas = []
      axios.get('/view/' + apartment_id)
            .then(result => {
                console.log(result.data);
                let monthViews = result.data.visuals;
                for (let index = 0; index < monthViews.length; index++) {
                  this.datas.push(monthViews[index].num_views)

                }
                this.chartData= {
                  labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                  datasets: [ { data: this.datas , label: 'Visualizzazioni', backgroundColor: '#8AC6DD', }  ]
                },
                this.totalViews = result.data.total_views
                this.newViews = result.data.new_views
                this.loading = false
            });

    }
  },

  mounted(){
    this.getMyApartments()

  }
}
</script>

<template>


  <div class="t4-container py-0 px-0 py-md-5 px-md-5">
      <h2 class="fs-3 fw-semibold my-4 title">Statistiche</h2>

      <div v-if="this.mainLoading" class="d-flex justify-content-center py-5 my-5">
        <Loader/>
      </div>

      <div v-else class="container vf-container mt-4">
        <!-- top -->
        <router-link :to="{ name: 'apartment-detail-admin', params: { slug: this.apartments[counter].slug } }" class="top d-flex align-items-center justify-content-between p-4">
          <div class="apartment d-flex align-items-center">
            <div class="img me-3">
              <img :src="this.apartments[counter].img_path ?? '/img/house-placeholder.png'" alt="">
            </div>
            <h4 class="name m-0 fw-semibold">{{ this.apartments[counter].title }}</h4>
          </div>
          <div class="d-flex">
            <span class="badge-views me-2">Visualizzazioni totali = {{ this.totalViews }}</span>
            <span class="badge-views">Singoli utenti = {{ this.newViews }}</span>
          </div>
        </router-link>
        <!-- /top -->

        <!-- bottom -->
        <div class="bottom d-flex">
          <!-- side -->
          <div class="side">
            <ul class="d-flex d-lg-block">
              <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">
                <div @click="getApartmentViews(apartment.id)" :class="{ 'active-apartment': this.counter == index }">
                  {{ apartment.title }}
                </div>
              </li>
            </ul>
          </div>
          <!-- /side -->

          <!-- main -->
          <div class="chart-container main d-flex justify-content-center">
            <div v-if="this.loading" class="d-flex justify-content-center py-5 my-5">
              <Loader/>
            </div>
            <Line v-else
              id="my-chart-id"
              :options="chartOptions"
              :data="chartData"
              />
          </div>
          <!-- /main -->

        </div>
        <!-- /bottom -->
      </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.title {
  color: $dark-gray;
}
.vf-container {
  height: 700px;
  padding: 0;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  border-radius: 15px;
  overflow: hidden;
}
.top {
  width: 100%;
  height: 15%;
  margin-bottom: 10px;
  background: $dark-white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .apartment {
    .img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      overflow: hidden;
    }
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .name {
      color: $dark-gray;
    }
  }

  .badge-views {
    font-size: 0.9rem;
    display: block;
    padding: 5px 10px;
    border-radius: 10px;
    color: white;
    background-color: $dark_gray;
    transition: all 0.3s;
  }
}
.bottom {
  height: 83%;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .side {
  width: 18%;
  height: 100%;
  overflow: auto;
  background: $dark-gray;
  color: white;

  li {
    div {
      display: inline-block;
      height: 100%;
      width: 100%;
      color: white;
      font-size: 1rem;
      border-left: 5px solid transparent;
      padding: 15px;
      transition: all 0.3s;
      cursor: pointer;

      &:hover,
      &.active-apartment {
        border-left: 5px solid $light_blue;
        background-color: $gray;
      }
    }
  }
}
  .main {
    width: 82%;
    padding: 15px;
    height: 100%;
    background: $dark-white;
    overflow: auto;
  }
}
//media-query
@media screen and (max-width: 992px) {
.t4-container {
  padding: 0;
}
.title {
  margin-bottom: 20px;
}
.top {
  .apartment {
    .name {
    font-size: 19px;
  }
  }
}
.bottom {
  flex-direction: column;
  .side {
    width: 100%;
    max-height: 75px;
    ul {
      height: 100%;
    }
    li {
      div {
        border-left: 0;
        border-bottom: 5px solid transparent;
        padding-right: 20px;
        height: 100%;
        &:hover,
        &.active-msg {
          border-left: 0;
          border-bottom: 5px solid $light-blue;
        }
      }
    }
  }
  .chart-container{
    width: 100%;

    #my-chart-id{
     width: 100%;
    }
  }
}
}
</style>
