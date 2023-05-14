<script>
import { ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'

import { getUser, editUser, deleteUser } from '@/services/users'

export default {
  name: 'UsersEditView',
  setup() {
    
    const route = useRoute()
    const user = ref(null)
    const firstname = ref('')
    const lastname = ref('')
    const email = ref('')
    const role_user = ref([])
    const roles = ref([
      'ROLE_USER',
      'ROLE_BLOGER',
      'ROLE_ADMIN'
    ])

    watchEffect(async () => {
      user.value = await getUser(route.params.id)
      firstname.value = user.value.firstname
      lastname.value = user.value.lastname
      email.value = user.value.email
      role_user.value = user.value.roles[0]
    })

    const handleEdit = async () => {
      try {
        const response = await editUser(route.params.id, {
          firstname: firstname.value,
          lastname: lastname.value,
          email: email.value,
          roles: [role_user.value]
        })
        if (response)
          alert('User modifié avec succès')
      }
      catch (error) {
        console.log(error)
      }
    }

    const handleDelete = async () => {

      try {
        const response = await deleteUser(route.params.id)

        if (response.status === 204) {
          window.location.href = '/admin/users'
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }

    const handleRoleChange = (event) => {
      role_user.value = event.target.value
    }
    
    return {
      user,
      firstname,
      lastname,
      email,
      role_user,
      roles,
      handleEdit,
      handleDelete,
      handleRoleChange
    }
  }
}
</script>

<template>
  <div class="users">

    <a id="delete" @click="handleDelete" class="btn btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></a>

    <h1>User n° {{ user ? user.id : '??' }}</h1> 

    <div class="card">
      <div class="card-body">

        <form class="form" @submit.prevent="handleEdit">

          <div class="row">
              <div class="col-md-6 form__group">
                <label for="lastname" class="form__label">Lastname</label>
                <input v-model="lastname" type="text" id="lastname" class="form__input" />
              </div>
              <div class="col-md-6 form__group">
                <label for="firstname" class="form__label">Firstname</label>
                <input v-model="firstname" type="text" id="firstname" class="form__input" />
              </div>
          </div>

          <div class="col-md-12 form__group">
              <label for="email" class="form__label">Email</label>
              <input v-model="email" type="email" id="email" class="form__input" />
          </div>
          
          
          <div class="col-md-12 form__group">
              <label for="roles" class="form__label">Roles</label>
              <div v-for="role in roles" :key="role">
                  <input @change="handleRoleChange($event)" v-model="role_user" type="radio" :id="role" :name="roles" :value="role" :checked="user && role === user.roles[0]"/>
                  <label :for="role">{{ role }}</label>
              </div>
          </div>

          <div class="buttons">
            <RouterLink to="/admin/users" class="btn btn-primary">Retour</RouterLink>
            <button class="btn btn-warning"><i class="fas fa-edit"></i> Éditer</button>
          </div>

        </form>
        
      </div>
    </div>

  </div>
</template>

<style scoped>
.users {
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

input[type="radio"] {
  margin-right: 5px;
  margin-left: 5px;
  cursor: pointer;
}

.buttons{
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}
</style>