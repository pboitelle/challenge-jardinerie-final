<script>
import { ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'

import { getPlante, editPlante, deletePlante } from '@/services/plantes'

export default {
  name: 'PlantesEditView',
  setup() {
    
    const route = useRoute()
    const plante = ref(null)
    const espece = ref('')
    const genre = ref('')

    watchEffect(async () => {
      plante.value = await getPlante(route.params.id)
      espece.value = plante.value.espece
      genre.value = plante.value.genre
    })

    const handleEdit = async () => {

      try {
        const response = await editPlante(route.params.id, {
          espece: espece.value,
          genre: genre.value
        })
        if (response)
          alert('Plante modifiée avec succès')
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }

    const handleDelete = async () => {

      try {
        const response = await deletePlante(route.params.id)

        if (response.status === 204) {
          window.location.href = '/admin/plantes'
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }
    
    return {
      plante,
      espece,
      genre,
      handleEdit,
      handleDelete
    }
  }
}
</script>

<template>
  <div class="plantes">

    <a id="delete" @click="handleDelete" class="btn btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></a>

    <h1>Plante n° {{ plante ? plante.id : '??' }}</h1> 

    <div class="card">
      <div class="card-body">

        <form class="form" @submit.prevent="handleEdit">

          <div class="form__group">
              <label for="espece" class="form__label">Espèce</label>
              <input v-model="espece" type="text" id="espece" class="form__input" />
          </div>
          <div class="form__group">
              <label for="genre" class="form__label">Genre</label>
              <input v-model="genre" type="text" id="genre" class="form__input" />
          </div>

          <div class="buttons">
            <RouterLink to="/admin/plantes" class="btn btn-primary">Retour</RouterLink>
            <button class="btn btn-warning"><i class="fas fa-edit"></i> Éditer</button>
          </div>

        </form>
        
      </div>
    </div>

  </div>
</template>

<style scoped>
.plantes {
  margin-top: 50px;
  background-color: rgb(86, 145, 81);
  padding: 20px;
  border-radius: 10px;
}

#delete{
  float: right;
  color: white;
  font-size: 20px;
  margin-top: 0;
  margin-right: 0;
  width: auto;
}

h1 {
  text-align: center;
  color: white;
}

.card {
  margin-top: 50px;
}

.form__group {
  margin-bottom: 20px;
} 

.form__label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form__input {
  display: block;
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid rgb(86, 145, 81);
}

.buttons{
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}
</style>