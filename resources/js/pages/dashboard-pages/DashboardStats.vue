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
      this.loading = true;
      axios.get("sanctum/csrf-cookie").then(() => {
        axios.get(`/admin/${store.user.id}`).then((result) => {
          this.apartments = result.data.apartments;
          this.loading = false;
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
                  datasets: [ { data: this.datas , label: 'VIews', backgroundColor: '#8AC6DD', }  ]
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
  <h2 class="p-5 fw-semibold">Statistiche</h2>
  <div class="d-flex justify-content-center" v-if="loading">
    <Loader/>
  </div>
  <div v-else class="t4-container">
  <div class=" mb-4">
    <div class="row">
      <div class="col-3">
        <h5 class="fw-bold ms-5 total-views">Visualizzazioni totali = {{ this.totalViews }}</h5>
      </div>
      <div class="col-3">
        <h5 class="fw-bold ms-5 total-views">Utenti singoli = {{ this.newViews }}</h5>
      </div>

      </div>
    </div>
    <div  class=" d-lg-flex justify-content-center chart-shadow d-block">
     <!-- side -->
     <div class="side">
        <ul class="d-flex d-lg-block">
          <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">
            <div @click="getApartmentViews(apartment.id)" :class="{'active-apartment' : this.counter == index}">
              {{apartment.title}}
            </div>
          </li>
        </ul>
      </div>

      <div class="chart-container main d-flex justify-content-center">
        <Line

        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
        />
      </div>
    </div>

  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

.chart-container{
  height: 100%;
}

.total-views{
  padding: 10px 15px;
  box-shadow: inset 0 0 10px grey;
  border-radius: 10px;
  width: fit-content;
}


.chart-shadow {
  padding: 10px 15px;
  box-shadow: inset 0 0 10px grey;
  border-radius: 10px;
}
.main {
  width: 82%;
  padding: 15px;
  height: 100%;
  background: $dark-white;
  overflow: auto;
}

.side {
  width: 300px;
  height: 650px;
  overflow: auto;
  background: $dark-gray;
  color: white;
  transform: translate(y, 50px);
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


@media screen and (max-width: 992px) {

  .side{
    width: 100%;
    height: 100px;
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
        &.active-apartment {
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
</style>
