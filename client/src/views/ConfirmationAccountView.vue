<script>
import {onMounted, ref} from 'vue'
import { useRoute } from 'vue-router'
import { confirmUser } from '@/services/users.js'

export default {
  name: 'ConfirmationAccountView',
  setup () {
    const route = useRoute()
    const token = ref(route.params.token)
    const load = ref(false)

    onMounted(() => {
        confirmAccount()
    })

    const confirmAccount = async () => {
      try {
        const response = await confirmUser({
            token_account: token.value
        })

        if (response.status === 200) {
            load.value = true
        }else {
            load.value = false
        }

      } catch (error) {
        load.value = false
      }
    }

    return {
        load
    }
  }
}
</script>

<template>

    <div class="main" v-if="load">

        <h1 class="alert alert-success">
            Votre compte a bien été confirmé !
        </h1>

        <h2 class="alert alert-success">
            Vous pouvez vous connecter en cliquant sur le bouton ci-dessous : <br/>
            <RouterLink to="/" class="btn btn-link">Se connecter</RouterLink>
        </h2>

    </div>

    <div class="main" v-else>

        <h1 class="alert alert-danger">
            Une erreur est survenue lors de la confirmation de votre compte.
        </h1>

    </div>
 
</template>

<style scoped>
    .main{
        display: flex;
        flex-direction: column;
    }
    h1{
        font-size: 32px;
        text-align: center;
        margin-top: 50px;
    }
    h2{
        font-size: 24px;
        text-align: center;
        margin-top: 50px;
    }

</style>
