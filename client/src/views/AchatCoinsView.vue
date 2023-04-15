<script>
import NavBar from '@/components/NavBar.vue'
import ListCards from '@/components/ListCards.vue'
import axios from 'axios';

export default {
  name: 'AchatCoinsView',
  components: {
    NavBar,
    ListCards
  },
  data () {
    return {
      title: 'Achat de coins',
      items: [
        { id: 1, text: "Achat de 10 coins", img: "/src/assets/img/coin.png" },
        { id: 2, text: "Achat de 20 coins", img: "/src/assets/img/coin.png" },
        { id: 3, text: "Achat de 30 coins", img: "/src/assets/img/coin.png" }
      ],
    }
  },
  methods: {
    handleAchatCoins: async function (item) {
      console.log(item.id)
      try {
        const response = await axios.patch('https://localhost/users/achat-coins/' + 1, {
          'headers': {
            'Content-Type': 'application/json',
            'accept': 'application/json'
          }
        }, JSON.stringify({
          'item': item.id
        }));
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
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
