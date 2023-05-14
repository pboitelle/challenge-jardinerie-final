<script>
import {ref, watchEffect} from 'vue'
import axios from 'axios'
import NavBar from '@/components/NavBar.vue'

import { userConnected } from '@/middleware/userAuth.js'

import Popup from '@/components/Popup.vue';

export default {
    name: 'DevenirBloggerView',
    components: { NavBar, Popup },
    setup() {
        const user = ref(null)

        watchEffect(async () => {
            user.value = await userConnected()
        })

        const motif = ref('')
        const popupType = ref('success')
        const popupVisible = ref(false)
        const popupTitle = ref('Votre demande pour devenir Blogger a bien été prise en compte !')
        const token = localStorage.getItem('token_jwt')

        const handleForm = async () => {

            try {
                const response = await axios.post('https://localhost/demande-bloggers', JSON.stringify({
                    motif: motif.value
                }), {
                headers: {
                    Authorization: `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
                })
                console.log(response)
                if (response.status === 201) {
                    popupVisible.value = true
                    window.location.reload()
                }
                else {
                    alert('Une erreur est survenue lors de l\'envoi de votre demande.')
                }

            }
            catch (error) {
                console.log(error.response)
                if(error.response.status === 401) {
                    popupTitle.value = 'Vous devez être connecté pour effectuer cette action.';
                    popupType.value = 'danger'
                    popupVisible.value = true
                }else if (error.response.status === 400) {
                    popupTitle.value = error.response.data.message;
                    popupType.value = 'danger'
                    popupVisible.value = true
                }
            }
        }

        const closePopup = () => {
            popupVisible.value = false
        }

        return {
            user,
            motif,
            handleForm,
            popupVisible,
            popupTitle,
            popupType,
            closePopup
        }
    }
}


</script>

<template>

    <NavBar />

    <div v-if="user && (user.roles.includes('ROLE_BLOGER') || user.roles.includes('ROLE_ADMIN'))" class="main">

        <div id="informations">
            <h1 class="form__title">Vous êtes déja Blogger !</h1>
            <p>
                Vous êtes déja Blogger, vous pouvez donc créer des articles et les publier sur le site.
                <RouterLink id="devenir-bloger" to="/plantes" class="btn btn-info">
                    <i class="fa-sharp fa-solid fa-file-plus"></i> Créer un article
                </RouterLink>
            </p>
        </div>

    </div>

    <div v-else class="main">

        <div>
            <popup :type="popupType" :title="popupTitle" v-if="popupVisible" @close="closePopup" />
        </div>

        <div id="informations">
            <h1 class="form__title">Vous voulez devenir Blogger ?</h1>
            <p>
                Veuillez remplir le formulaire ci-dessous pour devenir Blogger.<br/>
                Vous pourrez ensuite créer des articles et les publier sur le site lorsqu'un administrateur aura validé votre demande.
            </p>
        </div>

        <form class="form" @submit.prevent="handleForm">

            <div class="form__group">
                <label for="motif" class="form__label">Motif</label>
                <textarea v-model="motif" id="motif" class="form__input" rows="5"></textarea>
            </div>

            <button class="btn btn-success">Valider</button>

        </form>
    </div>
</template>

<style scoped>

#informations{
    text-align: center;
    margin-bottom: 2rem;
}

@media screen and (max-width: 768px) {
    #informations{
        margin-left: 0;
    }
}
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