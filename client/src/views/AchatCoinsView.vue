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
        const response = await axios.patch('https://localhost/users/achat-coins/' + user.id, {
          'headers': {
            'Content-Type': 'application/merge-patch+json',
          }
        }, JSON.stringify({
          'coins': item.nb_coins
        }));
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    }

    return {
      handleAchatCoins
    }
  },
  data () {
    return {
      title: 'Achat de coins',
      items: [
        { id: 1, text: "Achat de 10 coins", img: "/src/assets/img/coin.png", nb_coins: 10 },
        { id: 2, text: "Achat de 50 coins", img: "/src/assets/img/coin.png", nb_coins: 50 },
        { id: 3, text: "Achat de 100 coins", img: "/src/assets/img/coin.png", nb_coins: 100 }
      ],
    }
  }
}
</script>

<template>
  
  <NavBar />
 
  <div class="container">
    <h1>{{ title }}</h1>
    <ListCards :items="items" @click="handleAchatCoins" />
  </div>


</template>

<style scoped>
</style>
