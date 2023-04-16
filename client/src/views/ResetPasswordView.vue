<script>
import {ref} from 'vue'
import axios from 'axios';
import { useRoute } from 'vue-router'

export default {
    setup () {
        const password = ref('')
        const confirm_password = ref('')
        const route = useRoute()

        const submitForm = async () => {

            if (password.value !== confirm_password.value) {
                alert('Les mots de passe ne correspondent pas');
                return;
            }

            try {

                const response = await axios.post(`https://localhost/users/change-password/${route.params.token}`, JSON.stringify({
                    password: password.value
                }), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                console.log(response)

            } catch (error) {
                console.error(error);
            }
        }

        return {
            submitForm,
            password,
            confirm_password
        }
    }
}
</script>

<template>
    
    <div class="main">

        <form class="form" @submit.prevent="submitForm">
            <div class="form__group">
                <label for="password" class="form__label">Password</label>
                <input v-model="password" type="password" id="password" class="form__input" />
            </div>

            <div class="form__group">
                <label for="confirm-password" class="form__label">Confirm Password</label>
                <input v-model="confirm_password" type="password" id="confirm-password" class="form__input" />
            </div>
            
            <button class="btn btn-primary">Réinitialiser mon mot de passe</button>
            
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
