import { reactive } from "vue";
import { ref } from 'vue';
import axios from 'axios';


export const store = reactive ({

  user : null,
  errors: null,

  form : ref({
    full_name: "",
    email: "",
    password: ""
  }),

  formLogin : ref({
    loginEmail: "",
    loginPassword: ""
  }),


  handleRegistration(){
    axios.post('/register', {
      name: this.form.full_name,
      email: this.form.email,
      password: this.form.password,
    })
    this.$router.push({
      name:'home'
    });
  },

  handleLogin(){

    if(this.formLogin.loginPassword > 7){

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
          }),

          this.router.push('/my-apartments');
        })
      })
    }else {
      this.errors = "La password deve avere almeno 8 caratteri"
    }

  },

  handleLogout(){
    axios.post('/logout').then(response => {
      this.user = null;

      this.$router.push('/');
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
});
