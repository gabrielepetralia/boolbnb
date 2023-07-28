
<script>
import axios from 'axios';
import { store } from '../../store/store';
export default {
  name: 'AddGallery',

  data(){
    return{
      store,
      image: [],
      apartmentMine: {}
    }


  },


  props: {
    apartment: Object,

  },

  methods:{
    addGallery(){

      axios.get('sanctum/csrf-cookie')
      .then(() => {

        axios.post("http://127.0.0.1:8000/admin/image", {
          images: this.image,
          apartment_id: this.apartmentMine.id
        }, {
          headers:{
            'Content-Type': 'multipart/form-data',
          }
        } )
        .then(result=>{

        })

      })
    },


  onChangeMultiple(event){
      this.image= event.target.files[0]
    }
  },

    mounted(){
      this.apartmentMine = this.apartment
  }
}
</script>
<template>

  <label class="mb-2 d-block fw-semibold fs-5" for="img_path_gallery">Aggiungi un'immagine alla galleria :</label>
  <div class=" d-flex align-items-center input-box pb-2">
    <input
    @change="onChangeMultiple"
    type="file"
    title="Galleria"
    id="img_path_gallery"
    name="img_path_gallery"
    class="form-control"
    placeholder="Immagine">
    <div>
      <button class="btn t4-btn ms-2" @click="addGallery"><i class="fa-solid fa-plus"></i></button>
    </div>
  </div>


</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

#img_path_gallery{
  width: 50%;
}
</style>
