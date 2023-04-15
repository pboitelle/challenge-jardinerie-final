<script>
import axios from 'axios';
export default {
  data() {
    return {
      // Form data here
        formData: {
            email: '',
            password: '',
        }
    }
  },
  methods: {
    async submitForm() {
      try {
        const response = await axios.get('https://localhost/register', {
          'headers': {
            'Content-Type': 'application/json',
            'accept': 'application/json'
          },
        }, {
          params: {
            email: this.formData.email,
            password: this.formData.password
          }
        });
        this.data = response.data;
        console.log(this.data);
      } catch (error) {
        console.error(error);
      }
    }

  }
}
</script>

<template>
    <div class="main">
        <form class="form">
            <div class="form__group">
                <label for="email" class="form__label">Email</label>
                <input type="email" id="email" class="form__input" />
            </div>
            <div class="form__group">
                <label for="password" class="form__label">Password</label>
                <input type="password" id="password" class="form__input" />
            </div>
            
            <button @click="submitForm">Register</button>
            
            <div>
                <p>Already have an account? <router-link to="/">Login</router-link></p>
            </div>
        </form>
    </div>
</template>

<style scoped>
    .form {
        width: 30rem;
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
</style>
