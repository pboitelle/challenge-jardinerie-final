<script>
import { ref, watchEffect } from 'vue'
import { getPlantes } from '@/services/plantes'

export default {
  name: 'PlantesView',
  setup() {
    
    const plantes = ref([])

    watchEffect(async () => {
      plantes.value = await getPlantes()
    })
    
    return {
      plantes
    }
  }
}
</script>

<template>
  <div class="plantes">

    <h1>Liste des plantes</h1>

    <table class="table table-success table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Espece</th>
          <th scope="col">Genre</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr v-for="plante in plantes" :key="plante.id">
          <td>{{ plante.id }}</td>
          <td>{{ plante.espece }}</td>
          <td>{{ plante.genre }}</td>
          <td>
            <router-link :to="{ name: 'admin-plantes-edit', params: { id: plante.id } }" class="btn btn-warning"><i class="fas fa-edit"></i> Éditer</router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.plantes {
  margin-top: 50px;
  background-color: rgb(86, 145, 81);
  padding: 20px;
  border-radius: 10px;
  color: white;
}

h1 {
  text-align: center;
}
</style>