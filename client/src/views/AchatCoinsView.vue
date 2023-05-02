<script>
import NavBar from '@/components/NavBar.vue'
import ListCards from '@/components/ListCards.vue'
import axios from 'axios';
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

    watchEffect(async () => {
      user.value = await userConnected()
    })

    const handleAchatCoins = async (item) => {
      try {
        const response = await axios.patch('https://localhost/users/achat-coins/' + user.value.id + '/' + item.nb_coins, JSON.stringify({
            
        }),
        {
          headers: {
            'Content-Type': 'application/merge-patch+json',
            'accept': 'application/ld+json'
          }
        });
        console.log(response);
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
        { id: 1, text: "Achat de 10 coins", img: "/src/assets/img/coin.png", nb_coins: 10 },
        { id: 2, text: "Achat de 20 coins", img: "/src/assets/img/coin.png", nb_coins: 20 },
        { id: 3, text: "Achat de 30 coins", img: "/src/assets/img/coin.png", nb_coins: 30 }
      ],
    }
  }
}
</script>

<template>
  
  <NavBar />
 
  <div class="container">
    <h1>{{ title }}</h1>
    <ListCards :items="items" @itemSelected="handleAchatCoins"/>
  </div>


</template>

<style scoped>

h1{
    text-align: center;
    margin-top: 100px;
    margin-bottom: 30px;
}
</style>
