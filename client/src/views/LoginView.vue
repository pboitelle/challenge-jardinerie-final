<script>
import {ref} from 'vue'
import {createRequest} from '@/middleware/api.js'

export default {
  name: 'LoginView',
  setup() {
    const email = ref('')
    const password = ref('')
    const request = createRequest();

    const login = async () => {

      try {
        const response = await request.post('/authentication_token', JSON.stringify({
          email: email.value,
          password: password.value
        }), {
          headers: {
            'Content-Type': 'application/json'
          }
        })

        localStorage.setItem('token_jwt', response.data.token)
        window.location.href = '/garden'
      }
      catch (error) {
        if (error.response.status === 401) {
          alert('Invalid email or password')

        }else if (error.response.status === 500) {
          alert('Votre compte n\'a pas encore été confirmé, veuillez vérifier vos emails.')
        } else {
          alert('An error occurred, please try again later')
        }
      }
    }

    return {
      email,
      password,
      login
    }
  }
}


</script>

<template>
  <div class="main">
    <form class="form" @submit.prevent="login">
        <div class="form__group">
            <label for="email" class="form__label">Email</label>
            <input v-model="email" type="email" id="email" class="form__input" />
        </div>
        <div class="form__group">
            <label for="password" class="form__label">Password</label>
            <input v-model="password"  type="password" id="password" class="form__input" />
        </div>
        <button class="btn btn-success">Login</button>
        <div>
            <p>Don't have an account? <router-link to="/register">Register</router-link></p>
        </div>
        <div>
            <p>Forgot your password? <router-link to="/send-email-password">Reset password</router-link></p>
        </div>
    </form>
  </div>
</template>

<style scoped>
.form {
  width: 40%;
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
@media screen and (max-width: 768px) {
  .form {
    width: 100%;
    padding: 2rem;
  }
}
</style>
