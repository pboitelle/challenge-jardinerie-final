<script>
import {ref, computed, watchEffect} from 'vue';

import NavBar from '@/components/NavBar.vue'
import Popup from '@/components/Popup.vue'

import { getMarkets } from '@/services/markets.js'
import { createVente } from '@/services/ventes.js'
import { userConnected } from '@/middleware/userAuth.js'

export default {
  components: { NavBar, Popup },
  name: 'MarketView',

  setup() {
    const searchTerm = ref("");

    const popupVisible = ref(false)
    const popupTitle = ref(null) 
    const popupType = ref('success')

    const user = ref(null)
    const markets = ref([])

    watchEffect(async () => {
        markets.value = await getMarkets()
        user.value = await userConnected()
    })

    const searchResults = computed(() => {
      // Filtrer les résultats selon le searchTerm
      return markets.value.filter(market =>
        market.item_id.plante.espece.toLowerCase().includes(searchTerm.value.toLowerCase())
      );
    });

    const displayedMarkets = computed(() => {
      // Découper les résultats en pages
      const startIndex = (currentPage.value - 1) * marketsPerPage.value;
      const endIndex = startIndex + marketsPerPage.value;
      return searchResults.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => {
      // Calculer le nombre total de pages
      return Math.ceil(searchResults.value.length / marketsPerPage.value);
    });

    const currentPage = ref(1);
    const marketsPerPage = ref(12);

    const searchMarkets = () => {
      // Mettre à jour la page courante pour afficher le premier page de résultats
      currentPage.value = 1;
    }
    const prevPage = () => {
      currentPage.value--;
    }
    const nextPage = () => {
      currentPage.value++;
    }

    const closePopup = () => {
      popupVisible.value = false
    }

    const handleCreateVente = async (market) => {

        if (user.value.nb_coins < market.prix){
            popupTitle.value = 'Vous n\'avez pas assez de coins pour acheter cet item.'
            popupType.value = 'danger'
            popupVisible.value = true
            return
        }

        try {
            const response = await createVente(user.value.id, {
                vendeurId: market.user_id.id,
                prix: market.prix,
                item: market.item_id
            })

            console.log(response)

            if (response.status === 200){
                popupTitle.value = 'L\'item a bien été acheté ! Vous avez été débité de '+ market.prix +' coins en attendant que le vendeur accepte la vente.'
                popupType.value = 'success'
                popupVisible.value = true
                setTimeout(() => {
                    window.location.reload()
                }, 2000);
            }else{
                popupTitle.value = 'Une erreur est survenue !'
                popupType.value = 'danger'
                popupVisible.value = true
            }             
        }
        catch (error) {
            alert('Une erreur est survenue')
        }
    }

    const confirmCreateVente = (market) => {
        if (confirm('Voulez-vous vraiment acheter cet item ? Vous serez débité de '+ market.prix +' coins en attendant que le vendeur accepte la vente.')){
            handleCreateVente(market)
        }
    }


    return {
        user,
        searchTerm,
        markets,
        displayedMarkets,
        currentPage,
        marketsPerPage,
        totalPages,
        popupTitle,
        popupType,
        popupVisible,
        closePopup,
        searchMarkets,
        prevPage,
        nextPage,
        confirmCreateVente
    }
  }
}
</script>

<template>

    <div>
        <popup :title="popupTitle" v-if="popupVisible" @close="closePopup" :autoClose="3000" :type="popupType" />
    </div>

    <NavBar />

    <main class="main-dark">

        <div class="container bg-market bg-dark">

            <div class="search-bar text-center">
                <input type="text" placeholder="Rechercher une plante" v-model="searchTerm" @input="searchMarkets" />
                <button @click="searchMarkets" class="button">Rechercher</button>
            </div>

            <div class="market-container row">
                <div class="market-item col-md-6 col-xs-12" v-for="market in displayedMarkets" :key="market.id">
                    <a class="img-planted" :style="{ 'border-color': market ? market.item_id.niveau.color : 'grey' }">
                        <img :src="market.item_id.plante.image_url" alt="plante Image" />
                    </a>
                    <div class="info-item">
                        <div class="header-item">
                            <span class="espece">
                                {{ market.item_id.plante.espece }}
                            </span>
                            <hr/>
                            <span class="infos">
                                <strong>Vendeur : </strong> 
                                <span class="vendeur">
                                    {{ market.user_id.lastname +' '+ market.user_id.firstname }}
                                </span>
                            </span>
                            <hr/>
                        </div>
                        <div class="footer-item">
                            <span class="badge" :style="{ 'background-color': market ? market.item_id.niveau.color : 'grey' }">
                                {{ market.item_id.niveau.niveau }}
                            </span>
                            <span class="prix">
                                {{ market.prix }}
                                <img src="@/assets/img/coin.png" alt="coin" />
                            </span>
                            <button class="btn btn-dark" @click="confirmCreateVente(market)">
                                <i class="fa-sharp fa-regular fa-handshake"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="pagination">
                <button v-if="currentPage > 1" @click="prevPage">Page précédente</button>
                <button v-if="currentPage < totalPages" @click="nextPage">Page suivante</button>
            </div>
        </div>

    </main>
  
</template>

<style>
.bg-market {
    width: 100%;
    min-height: 100vh;
}
.search-bar {
    margin-top: 20px;
    margin-bottom: 15px;
    width: 100%;
}

.search-bar input {
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    margin-right: 10px;
}

.search-bar button {
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    background-color: #28a745;
    color: white;
    cursor: pointer;
}

.search-bar button:hover {
    background-color: white;
    color: #28a745;
}

.buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination button {
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    background-color: #28a745;
    color: white;
    cursor: pointer;
}
.pagination button:hover {
    background-color: white;
    color: #28a745;
}

.market-container {
    width: 100%;
    height: 100%;
    color: black;
}
.market-item {
    width: 80%;
    height: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.market-item .img-planted{
    width: 200px;
    border: 5px solid;
}
.market-item .img-planted img {
    width: 190px;
    height: 190px;
    object-fit: cover;
}
.market-item .img-planted img:hover{
  cursor: pointer;
  opacity: 0.9;
}
.market-item p{
    margin-bottom: 0;
}
.market-item .espece {
    font-size: 24px;
    font-weight: bold;
}
.market-item .infos {
    font-size: 18px;
    display: flex;
    justify-content: center;
    width: 100%;
}
.info-item{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    width: 100%;
    height: 200px;
}
.info-item .header-item{
    width: 100%;
    text-align: center;
}
.info-item .header-item hr{
    width: 100%;
}
.info-item .header-item .vendeur{
    margin-right: 5px;
    margin-left: 5px;
}
.info-item a{
    text-decoration: none;
}
.info-item .footer-item{
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    margin-bottom: 5px;
}
.info-item .footer-item .prix{
    font-size: 24px;
    font-weight: bold;
}
.info-item .footer-item .prix img{
    width: 50px;
    vertical-align: middle;
}
</style>