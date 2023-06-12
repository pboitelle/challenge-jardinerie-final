<script>
import NavBar from '@/components/NavBar.vue'
import ListCards from '@/components/ListCards.vue'
import {createRequest} from '@/middleware/api.js'
import { watchEffect, ref } from 'vue'

import { userConnected } from '@/middleware/userAuth.js'

export default {
  name: 'AchatCoinsView',
  components: {
    NavBar,
    ListCards
  },
  setup () {

    const user = ref(null)
    const request = createRequest();

    watchEffect(async () => {
      user.value = await userConnected()
    })

    const handleAchatCoins = async (item) => {
      try {
        const response = await request.patch('/users/achat-coins/' + user.value.id + '/' + item.nb_coins, JSON.stringify({
            
        }),
        {
          headers: {
            'Content-Type': 'application/merge-patch+json',
            'accept': 'application/ld+json'
          }
        });
        
        if (response.status === 200) {
          window.location.href = '/success-achat'
        }else{
          window.location.href = '/error-achat'
        }
      } catch (error) {
        console.error(error);
      }
    }

    return {
      handleAchatCoins,
      user
    }
  },
  data () {
    return {
      title: 'Achat de coins',
      items: [
        { id: 1, text: "Achat de 10 coins", nb_coins: 10 },
        { id: 2, text: "Achat de 20 coins", nb_coins: 20 },
        { id: 3, text: "Achat de 30 coins", nb_coins: 30 }
      ],
    }
  }
}
</script>

<template>
  
  <NavBar />
  <div class="main">
      <ListCards :items="items" @itemSelected="handleAchatCoins"/>
  </div>

</template>

<style scoped>
.main{
  flex-direction: column;
}

h1{
  text-align: center;
}
</style>
