<script>
import { ref, watchEffect } from 'vue'
import { getUsers } from '@/services/users'

export default {
  name: 'UsersView',
  setup() {
    
    const users = ref([])

    watchEffect(async () => {
      users.value = await getUsers()
    })
    
    return {
      users
    }
  }
}
</script>

<template>
  <div class="users">

    <h1>Liste des utilisateurs</h1>

    <table class="table table-success table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Mail</th>
          <th scope="col">Roles</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.lastname }}</td>
          <td>{{ user.firstname }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.roles }}</td>
          <td>
            <router-link :to="{ name: 'admin-users-edit', params: { id: user.id } }" class="btn btn-warning">
              <i class="fas fa-edit"></i> Éditer
            </router-link>
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