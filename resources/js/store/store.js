import { reactive } from "vue";
import { ref } from 'vue';
import axios from 'axios';


export const store = reactive ({
  searchedApartments : null,
// TomTom Api Datas
  apiUrl: 'http://127.0.0.1:8000/api/',
  apiKey: 'BJn2pmnX1Y20KpKZAZYCLf4m1Gzqu2bG',
  adminUrl: 'http://127.0.0.1:8000/admin/',

// user logged in and form errors
  user : null,
  errors: {},
  errorslogin: {},

// Autocomplete fields
  suggestions: null,
  showSuggestions: false,

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
      console.log(response)

      axios.post('/login', {
        email: this.form.email,
        password: this.form.password
      })

    }).then(response => {
      this.getUser()
    })
  }else{
    this.errors.password = "La password deve essere di almeno 8 caratteri"
  }


  },

  handleLogin(){
    this.errorslogin = {}

    if (!this.formLogin.loginEmail.includes("@")) {
      this.errorslogin.email = "Inserisci un indirizzo email valido";
      console.log(this.errorslogin)
    }
    //  if (this.formLogin.loginPassword.length > 7) {
    //   this.errorslogin.push("La password deve essere di almeno 8 caratteri")
    //   console.log(this.errorslogin)}


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
        })

        .catch(error => {
          this.errorslogin = error.response.data.errors;
          console.log('errore',error.response)
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
    if(address.length >= 3){

      axios
      .get('https://api.tomtom.com/search/2/search/' + address + '.json', {
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
    axios.get(store.apiUrl + "apartments/" + address + "/" + "0.2")
      .then(res => {
        this.searchedApartments = res.data.apartments;
      })
  },
});


