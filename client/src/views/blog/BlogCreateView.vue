<script>
import NavBar from '@/components/NavBar.vue'
import { ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'

import { createBlog } from '@/services/blogs'
import { getPlante } from '@/services/plantes'

export default {
  components: { NavBar },
  name: 'BlogCreateView',
  setup() {
      
    const route = useRoute()

    const plante = ref(null)

    const title = ref(null)
    const description = ref(null)
    const area = ref(null)


    watchEffect(async () => {
        const response = await getPlante(route.params.id)

        if (response.status === 200) {
          plante.value = response.data
        }
        else if (response.status === 403){
          window.location.href = '/plantes'
        }
    })


    const handleCreate = async () => {

      try {
        const response = await createBlog({
          title: title.value,
          description: description.value,
          area: area.value,
          planteId: plante.value.id
        })

        if (response){
          window.location.href = '/plantes'
        }             
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }

    
    return {
      plante,
      title,
      description,
      area,
      handleCreate
    }
  }
}
</script>

<template>
    <NavBar />

    <main class="main">

        <img :src="plante ? plante.image_url : ''" :alt="plante ? plante.espece : ''" />

        <div class="create">

            <h1>Créer le blog sur la plante <strong>{{ plante ? plante.espece : '??' }}</strong></h1> 

            <div class="card">
                <div class="card-body">

                    <form class="form" @submit.prevent="handleCreate">

                        <div class="form__group">
                            <label for="title" class="form__label">Title</label>
                            <input v-model="title" type="text" id="title" class="form__input" />
                        </div>
                        <div class="form__group">
                            <label for="description" class="form__label">Description</label>
                            <input v-model="description" type="text" id="description" class="form__input" />
                        </div>
                        <div class="form__group">
                            <label for="area" class="form__label">Area</label>
                            <textarea v-model="area" type="text" id="area" class="form__input" rows="10"></textarea>
                        </div>

                        <div class="buttons">
                            <RouterLink to="/plantes" class="btn btn-primary">Retour</RouterLink>
                            <button class="btn btn-primary"><i class="fa-solid fa-file-circle-plus"></i> Soumettre le blog</button>
                        </div>

                    </form>
                    
                </div>
            </div>

        </div>
    </main>
</template>

<style scoped>
img{
  width: 90%;
  height: 80vh;
  object-fit: cover;
  border-radius: 10px;
  margin: 50px;
}
.create {
  width: 100%;
  max-width: 1200px;
  height: auto;
  background-color: rgb(86, 145, 81);
  padding: 20px;
  border-radius: 10px;
  margin: 50px;
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