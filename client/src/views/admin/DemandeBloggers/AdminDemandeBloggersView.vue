<script>
import { ref, watchEffect } from 'vue'
import { getDemandeBloggers, deleteDemandeBloggers } from '@/services/demande_bloggers'
import { updateRole } from '@/services/users'
import moment from 'moment'

export default {
  name: 'DemandeBloggersView',
  setup() {
    const demandes = ref([])

    moment.locale('fr')

    watchEffect(async () => {
      demandes.value = await getDemandeBloggers()
    })

    const handleDelete = async (id) => {

      try {
        const response = await deleteDemandeBloggers(id)

        if (response.status === 204) {
          window.location.reload()
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }


    const handleAccept = async (id_demande, user_id) => {

      try {
        const response = await updateRole(user_id, {
          roles: ['ROLE_BLOGER']
        })

        console.log(response)

        if (response.status === 200) {
          handleDelete(id_demande)
          window.location.reload()
        }else{
          alert('Une erreur est survenue')
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }
    
    return {
      demandes,
      moment,
      handleDelete,
      handleAccept
    }
  }
}
</script>

<template>
  <div class="users">

    <h1>Liste des demandes pour devenir Blogger</h1>

    <table class="table table-success table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">User</th>
          <th scope="col">Motif</th>
          <th scope="col">Date demande</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr v-for="demande in demandes" :key="demande.id">
          <td>{{ demande.id }}</td>
          <td>{{ demande.user_id.email }}</td>
          <td>{{ demande.motif }}</td>
          <td>{{ moment(demande.created_at).format('DD/MM/YYYY HH:mm') }}</td>
          <td>
            <button class="btn btn-success" @click="handleAccept(demande.id, demande.user_id.id)">
              <i class="fa-sharp fa-regular fa-square-check"></i> Accepter
            </button>
            <button class="btn btn-danger" @click="handleDelete(demande.id)">
              <i class="fa-sharp fa-regular fa-square-xmark"></i> Refuser
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.users {
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