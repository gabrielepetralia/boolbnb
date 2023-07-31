import { reactive } from "vue";
import { ref } from 'vue';
import axios from 'axios';


export const store = reactive ({

advancedLoading : false,

mapMarker: '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 300 300" style="enable-background:new 0 0 300 300; filter: drop-shadow(0 0 15px rgba(0, 0, 0, 0.5));" xml:space="preserve"><style type="text/css">.st0{fill:#F0F0F0;}.st1{fill:#8AC6DD;}.st2{fill:#797978;}</style><g id="Layer_1"><g id="XMLID_00000093897840131001323190000011936723167068966559_"><path class="st0" d="M230.5,151.9L230.5,151.9l-82.4,142.8L65.7,151.9l0.1,0c-8-13.8-12.6-29.9-12.6-47c0-22.8,8.1-43.7,21.7-60.1c17.4-21,43.8-34.4,73.3-34.4s55.9,13.4,73.3,34.4c13.5,16.3,21.7,37.2,21.7,60.1C243.1,122,238.5,138,230.5,151.9z"/></g></g><g id="Layer_2"><g id="XMLID_00000150809438600640936840000007739809172138332046_"><g><path class="st1" d="M199.8,115.9c0-9.8-6.9-18-16.6-21.1c-2.6-0.8-5.4-1.3-8.3-1.3H150v58.1h-49.8v16.6h74.7c2.9,0,5.7-0.5,8.3-1.3c9.7-3.1,16.6-11.4,16.6-21.1c0-5.7-2.4-11-6.3-14.9C197.4,126.9,199.8,121.7,199.8,115.9z M174.9,153.3h-8.3v-14.9h8.3c4.6,0,8.3,3.3,8.3,7.5S179.5,153.3,174.9,153.3z M174.9,123.4h-8.3v-14.9h8.3c4.6,0,8.3,3.3,8.3,7.5C183.2,120.1,179.5,123.4,174.9,123.4z"/><polygon class="st2" points="216.4,85.3 183.2,85.3 150,64.5 116.8,85.3 116.8,143.3 100.2,143.3 100.2,85.3 83.6,85.3 112.7,67.1 112.7,43.8 129.3,43.8 129.3,56.7 133.4,54.1 150,43.8 166.6,54.1"/></g></g></g></svg>',


// sponsorship
apartmentId: null,
sponsorshipId: null,

// Filters
currentFilters : {},

// Arrays
  searchedApartments : null,
  availableServices: null,
  sponsorizedApartments: [],
  sponsorizedIds: [],


  // TomTom Api Datas
  apiUrl: 'http://127.0.0.1:8000/api/',
  apiKey: 'BJn2pmnX1Y20KpKZAZYCLf4m1Gzqu2bG',
  adminUrl: 'http://127.0.0.1:8000/admin/',

// user logged in and form errors
  user : null,
  errors: {},
  errorslogin: {},
  credentialError: null,

// Autocomplete fields
  suggestions: null,
  showSuggestions: false,
  search: '',

// Login and register forms fields
  form : ref({
    name: "",
    email: "",
    password: ""
  }),

  formLogin : ref({
    loginEmail: "",
    loginPassword: ""
  }),

// Handling authorizations
  handleRegistration(){
    this.errors = {}

    if (this.form.name.length < 3) {
      this.errors.name = "Inserisci un nome valido";
    }

    if (!this.form.email.includes(".")) {
      this.errors.email = "Inserisci un indirizzo email valido";
    }

    if (this.form.password.length > 7) {
    axios.post('/register', {
      name: this.form.name,
      email: this.form.email,
      password: this.form.password,
    })
    .catch(error => {
      this.errors = error.response.data.errors;
    })
    .then(response => {

      axios.post('/login', {
        email: this.form.email,
        password: this.form.password
      })
      const modalRegister =bootstrap.Modal.getOrCreateInstance('#register-modal');
      modalRegister.hide()

    }).then(response => {
      this.getUser()
    })
  }else{
    this.errors.password = "La password deve essere di almeno 8 caratteri"
  }


  },

  handleLogin(){
    this.errorslogin = {}
    this.credentialError = null

    if (!this.formLogin.loginEmail.includes("@")) {
      this.errorslogin.email = "Inserisci un indirizzo email valido";
    }
    //  if (this.formLogin.loginPassword.length > 7) {
    //   this.errorslogin.push("La password deve essere di almeno 8 caratteri")


    if(this.formLogin.loginPassword.length > 7){
      axios.get('sanctum/csrf-cookie')
      .then(result =>{
        axios.post('/login', {
          email: this.formLogin.loginEmail,
          password: this.formLogin.loginPassword
        })
        .then(response => {
          this.getUser()

          this.formLogin = ref({
            loginEmail: "",
            loginPassword: ""
          })

          const modalLogin =bootstrap.Modal.getOrCreateInstance('#login-modal');
          modalLogin.hide()
        })

        .catch(error => {
          if(error.response.data.message == 'Le credenziali non sono corrette.'){
            this.credentialError = error.response.data.message
          }
        });
      })

      }else{
        this.errorslogin.password = "La password deve essere di almeno 8 caratteri"
      }
    },

  handleLogout(){
    axios.post('/logout').then(response => {
      this.user = null;
    })
  },

  getUser() {
    axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.get('admin/user-auth')
                      .then(response => {
                        this.user = response.data
                      })
        })
  },

// Getting suggestions for adressed autocomplete w/ TomTom Api
  getSuggestions(address){
    this.search = address
    if(this.search.length >= 3){

      axios
      .get('https://api.tomtom.com/search/2/search/' + this.search + '.json', {
        params: {
          key: this.apiKey,
          language: 'it-IT',
          limit: 5,
        }})
        .then((response) => {
          this.suggestions = response.data.results;
          this.showSuggestions = true;
        })
        .catch(error => {
          this.errors = error
        });

      }else {
        this.showSuggestions = false;
      }
  },

  selectAddress(formField, suggest) {
    formField.address = suggest.address.freeformAddress;
    this.showSuggestions = false;
  },

  getSearchedApartments(address) {
    this.advancedLoading = true;
    this.currentFilters = {};
    axios.get(store.apiUrl + "apartments/" + address + "/" + "0.2")
      .then(res => {
        this.searchedApartments = res.data.apartments;
        this.apartmentCoordinates = [];
        console.log(this.searchedApartments);
        this.apartmentCoordinates = this.searchedApartments.map(apartment => ({
          lat: apartment.lat,
          lon: apartment.lng,
          id: apartment.slug,
          title: apartment.title,
          path: apartment.img_path
        }));
        this.advancedLoading = false;
        console.log(this.searchedApartments);
      })
  },

  // Get All services
  getServices(){
    axios.get(store.apiUrl + "apartments/services ")
          .then(response => {
            this.availableServices = response.data.services
          })
  },

  sponsorizeApartment(apartment_id){
    store.apartmentId = apartment_id;
    axios.post("http://127.0.0.1:8000/admin/sponsorize/" + store.apartmentId + "/" + store.sponsorshipId)
      .then(res => {

      });
  },



});


