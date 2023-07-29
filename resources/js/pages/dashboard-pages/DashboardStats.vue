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
      <div class="col">
        <h5 class="fw-bold ms-5 total-views">Total views = {{ this.totalViews }}</h5>
      </div>

      </div>
    </div>
    <div  class=" d-flex justify-content-center chart-shadow ">
     <!-- side -->
     <div class="side">
        <ul class="d-flex d-lg-block">
          <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">
            <div @click="getApartmentViews(apartment.id)" :class="{'active-msg' : this.counter == index}">
              {{apartment.title}}
            </div>
          </li>
        </ul>
      </div>

      <div class="chart-container main">
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
      &.active-msg {
        border-left: 5px solid $light_blue;
        background-color: $gray;
      }
    }
  }
}

</style>
