<script>
import {ref, computed, watchEffect} from 'vue';

import NavBar from '@/components/NavBar.vue'
import Popup from '@/components/Popup.vue'

import { getAchatsUser, getVentesUser, updateCoins } from '@/services/users.js'
import { deleteVente } from '@/services/ventes.js'
import { getMarkets } from '@/services/markets.js'
import { userConnected } from '@/middleware/userAuth.js'

export default {
  components: { NavBar, Popup },
  name: 'MesAchatsView',

  setup() {
    const popupVisible = ref(false)
    const popupTitle = ref(null) 
    const popupType = ref('success')

    const user = ref(null)
    const achats = ref([])
    const ventes = ref([])
    const markets = ref([])

    watchEffect(async () => {
        user.value = await userConnected()
        achats.value = await getAchatsUser(user.value.id)
        ventes.value = await getVentesUser(user.value.id)
        markets.value = await getMarkets()
    })

    const closePopup = () => {
        popupVisible.value = false
    }


    const handleAnnulerAchat = async (achat) => {

        try {
            const response = await deleteVente(achat.id)

            if (response.status === 204){

                //debiter l'acheteur
                const responseUpdateCoins = await updateCoins(achat.acheteur.id, {nbCoins: achat.prix}, 'debit')
            
                if (responseUpdateCoins.status === 200){
                    popupTitle.value = 'L\'achat a bien été annulée. Vous avez été remboursé de '+ achat.prix +' coins !'
                    popupType.value = 'success'
                    popupVisible.value = true
                    setTimeout(() => {
                        window.location.reload()
                    }, 3000);
                }else{
                    popupTitle.value = 'Une erreur est survenue !'
                    popupType.value = 'danger'
                    popupVisible.value = true
                }
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

    return {
        user,
        achats,
        ventes,
        markets,
        popupTitle,
        popupType,
        popupVisible,
        closePopup,
        handleAnnulerAchat
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

        <div class="container bg-achat bg-dark">

            <div id="menu" class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                <router-link to="/market" class="btn btn-outline-light" for="btnradio1">Market ({{ markets.length }})</router-link>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked>
                <router-link to="/market/achats" class="btn btn-outline-light" for="btnradio2">Mes achats en attente ({{ achats.length }})</router-link>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <router-link to="/market/ventes" class="btn btn-outline-light" for="btnradio3">Mes ventes en attente ({{ ventes.length }})</router-link>
            </div>


            <div class="achat-container row">
                <div class="achat-item col-md-12 col-xs-12" v-for="achat in achats" :key="achat.id">
                    <a class="img-planted" :style="{ 'border-color': achat ? achat.item.niveau.color : 'grey' }">
                        <img :src="achat.item.plante.image_url" alt="plante Image" />
                    </a>
                    <div class="info-item">
                        <div class="header-item">
                            <span class="espece">
                                {{ achat.item.plante.espece }}
                            </span>
                            <hr/>
                            <span class="infos">
                                <span class="vendeur">
                                    <strong>Vendeur : </strong> 
                                    {{ achat.vendeur.lastname +' '+ achat.vendeur.firstname }}
                                </span>
                                <span class="prix">
                                    <img src="@/assets/img/coin.png" alt="coin" />{{ achat.prix }}
                                </span>
                            </span>
                            <hr/>
                        </div>
                        <div class="footer-item">
                            <span class="badge" :style="{ 'background-color': achat ? achat.item.niveau.color : 'grey' }">
                                {{ achat.item.niveau.niveau }}
                            </span>
                            <button class="btn btn-danger" @click="handleAnnulerAchat(achat)">
                                Annuler l'achat
                            </button>                           
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>
  
</template>

<style>
.bg-achat {
    width: 100%;
    min-height: 100vh;
}
.bg-achat #menu{
    margin-bottom: 20px;
    width: 100%;
    margin-top: 60px;
}

.achat-container {
    width: 100%;
    height: 100%;
    color: black;
}
.achat-item {
    width: 80%;
    height: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.achat-item .img-planted{
    width: 200px;
    border: 5px solid;
}
.achat-item .img-planted img {
    width: 190px;
    height: 190px;
    object-fit: cover;
}
.achat-item .img-planted img:hover{
  cursor: pointer;
  opacity: 0.9;
}
.achat-item p{
    margin-bottom: 0;
}
.achat-item .espece {
    font-size: 24px;
    font-weight: bold;
}
.achat-item .infos {
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
.achat-item .infos .prix{
    font-size: 28px;
    font-weight: bold;
    display: flex;
    margin-right: 10px;
}
.achat-item .infos .prix img{
    width: 50px;
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
</style>