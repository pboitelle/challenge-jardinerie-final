<script>
import {ref} from 'vue'
import {createRequest} from '@/middleware/api.js'

import Popup from '@/components/Popup.vue';

export default {
    name: 'SendEmailResetPasswordView',
    components: {
        Popup
    },
    setup() {
        const email = ref('')
        const popupVisible = ref(false)
        const popupTitle = 'Un email de réinitialisation vous a été envoyé.'
        const request = createRequest();

        const submitForm = async () => {

            try {

                const response = await request.post('/users/reset-password', JSON.stringify({
                    email: email.value
                }), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                console.log(response)
                if (response.status === 200) {
                    popupVisible.value = true
                }


            } catch (error) {
                console.error(error);
            }
        }

        const closePopup = () => {
            popupVisible.value = false
        }

        return {
            submitForm,
            email,
            popupVisible,
            closePopup,
            popupTitle
        }
    }
}
</script>

<template>
    <div class="main">

        <div>
            <popup :title="popupTitle" v-if="popupVisible" @close="closePopup" :autoClose="3000" />
        </div>

        <div class="reset-password-form">

            <form class="form" @submit.prevent="submitForm">
                <div class="form__group">
                    <label for="password" class="form__label">Saisissez le mail de votre compte</label>
                    <input v-model="email" type="email" id="email" class="form__input" placeholder="john.doe@gmail.com" />
                </div>

                <button class="btn btn-secondary">Rechercher</button>

                <div>
                    <p>Already have an account? <router-link to="/">Login</router-link></p>
                </div>

            </form>

        </div>
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
