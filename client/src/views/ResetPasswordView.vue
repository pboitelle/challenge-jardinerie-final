<script>
import {ref} from 'vue'
import {createRequest} from '@/middleware/api.js'
import { useRoute } from 'vue-router'

import Popup from '@/components/Popup.vue';

export default {
    name: 'ResetPasswordView',
    components: {
        Popup
    },
    setup () {
        const popupType = ref('success')
        const password = ref('')
        const confirm_password = ref('')
        const route = useRoute()
        const popupVisible = ref(false)
        const popupTitle = ref('Votre mot de passe a bien été modifié, vous allez être redirigé vers la page de connexion !')
        const request = createRequest();

        const submitForm = async () => {

            if (password.value !== confirm_password.value) {
                alert('Les mots de passe ne correspondent pas');
                return;
            }

            try {

                const response = await request.post(`/users/change-password`, JSON.stringify({
                    password: password.value,
                    token: route.params.token
                }), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                if (response.status === 200) {
                    popupVisible.value = true
                    setTimeout(() => {
                        window.location.href = '/'
                    }, 5000)
                }

            } catch (error) {
                if(error.response.status === 400) {
                    popupTitle.value = error.response.data;
                    popupType.value = 'danger'
                    popupVisible.value = true
                }
            }
        }

        const closePopup = () => {
            popupVisible.value = false
        }

        return {
            submitForm,
            password,
            confirm_password,
            closePopup,
            popupVisible,
            popupTitle,
            popupType
        }
    }
}
</script>

<template>
    
    <div class="main">

        <div>
            <popup :type="popupType" :title="popupTitle" v-if="popupVisible" @close="closePopup" />
        </div>

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

            <div>
                <p>Go back to <router-link to="/">Login</router-link></p>
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
