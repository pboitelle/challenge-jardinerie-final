<script>
import {ref} from 'vue'
import Popup from '@/components/Popup.vue'
import { createUser } from '@/services/users.js'

export default {
  name: 'RegisterView',
  components: {
    Popup
  },
  setup() {
    const popupVisible = ref(false)
    const popupTitle = ref('Inscription réussie, un email de confirmation vous a été envoyé.')
    const popupType = ref('success')

    const email = ref('')
    const password = ref('')
    const confirm_password = ref('')
    const lastname = ref('')
    const firstname = ref('')

    const register = async () => {

      if (email.value === '' || password.value === '' || confirm_password.value === '' || lastname.value === '' || firstname.value === '') {
        popupTitle.value = 'Veuillez remplir tous les champs.'
        popupType.value = 'danger'
        popupVisible.value = true
        return
      }

      if (password.value !== confirm_password.value) {
        popupTitle.value = 'Les mots de passe ne correspondent pas.'
        popupType.value = 'danger'
        popupVisible.value = true
        return
      }

      try {
        const response = await createUser({
          email: email.value,
          password: password.value,
          lastname: lastname.value,
          firstname: fistname.value
        })

        if (response.status === 201) {
          popupTitle.value = response.message
          popupVisible.value = true
        }
        else {
          popupTitle.value = 'Une erreur est survenue.'
          popupType.value = 'danger'
          popupVisible.value = true
        }
      }
      catch (error) {
        console.log(error)
      }
    }

    const closePopup = () => {
      popupVisible.value = false
    }

    return {
      popupVisible,
      popupTitle,
      popupType,
      closePopup,
      email,
      password,
      confirm_password,
      lastname,
      firstname,
      register
    }
  }
}


</script>

<template>

  <div>
      <popup :title="popupTitle" v-if="popupVisible" @close="closePopup" :autoClose="3000" :type="popupType" />
  </div>

  <div class="main">
    <form class="form row" @submit.prevent="register">
        <div class="form__group col-md-6">
            <label for="fistname" class="form__label">Firstname</label>
            <input v-model="firstname" type="text" id="fistname" class="form__input" />
        </div>
        <div class="form__group col-md-6">
            <label for="lastname" class="form__label">Lastname</label>
            <input v-model="lastname" type="text" id="lastname" class="form__input" />
        </div>
        <div class="form__group col-md-12">
            <label for="email" class="form__label">Email</label>
            <input v-model="email" type="email" id="email" class="form__input" />
        </div>
        <div class="form__group col-md-6">
            <label for="password" class="form__label">Password</label>
            <input v-model="password"  type="password" id="password" class="form__input" />
        </div>
        <div class="form__group col-md-6">
            <label for="password" class="form__label">Confirmation password</label>
            <input v-model="confirm_password"  type="password" id="confirm_password" class="form__input" />
        </div>
        <button class="btn btn-success">Register</button>
        <div>
            <p>Déjà un compte ? <router-link to="/">Connectez-vous</router-link></p>
        </div>
    </form>
  </div>
</template>

<style scoped>
.form {
  width: 50%;
  margin: auto;
  padding: 3rem;
  border-radius: 1rem;
  color: #000;
  font-size: large;
  box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.8);
}

.form__group {
  margin-bottom: 2rem;
}

.form__label {
  display: block;
  margin-bottom: 0.5rem;
}

.form__input {
  display: block;
  width: 100%;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 0.25rem;
}

.form__input:focus {
  outline: none;
  border-color: #333;
}

.btn {
  display: block;
  width: 100%;
  padding: 1rem;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
}

/* Add styles here for small screens */
@media screen and (max-width: 768px)
{
  .form{
    width: 100%;
  }
}
</style>