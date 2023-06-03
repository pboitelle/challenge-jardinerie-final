<script>
import {ref, computed, watchEffect} from 'vue';

import NavBar from '@/components/NavBar.vue'
import Popup from '@/components/Popup.vue'

import { getVentesUser, getAchatsUser, updateCoins } from '@/services/users.js'
import { deleteVente } from '@/services/ventes.js'
import { updateUserItem } from '@/services/items.js'
import { getMarkets } from '@/services/markets.js'
import { userConnected } from '@/middleware/userAuth.js'

export default {
  components: { NavBar, Popup },
  name: 'MesVentesView',

  setup() {
    const popupVisible = ref(false)
    const popupTitle = ref(null) 
    const popupType = ref('success')

    const user = ref(null)
    const ventes = ref([])
    const achats = ref([])
    const markets = ref([])

    watchEffect(async () => {
        user.value = await userConnected()
        ventes.value = await getVentesUser(user.value.id)
        achats.value = await getAchatsUser(user.value.id)
        markets.value = await getMarkets()
    })

    const closePopup = () => {
      popupVisible.value = false
    }

    const handleAcceptVente = async (vente) => {

        try {
            const response = await updateUserItem(vente, user.value.id)

            if (response.status === 200){
                popupTitle.value = 'L\'item a bien été vendu. Vous avez reçu '+ vente.prix +' coins !'
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
        }
        catch (error) {
            alert('Une erreur est survenue')
        }
    }

    const handleRefuseVente = async (vente) => {

        try {
            const response = await deleteVente(vente.id)

            console.log(response)

            if (response.status === 204){
                //debiter l'acheteur
                const responseUpdateCoins = await updateCoins(vente.acheteur.id, {nbCoins: vente.prix}, 'debit')
            
                if (responseUpdateCoins.status === 200){
                    popupTitle.value = 'La vente a bien été annulée !'
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
            console.log(error)
        }
    }

    return {
        user,
        ventes,
        achats,
        markets,
        popupTitle,
        popupType,
        popupVisible,
        closePopup,
        handleAcceptVente,
        handleRefuseVente
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

        <div class="container bg-vente bg-dark">

            <div id="menu" class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                <router-link to="/market" class="btn btn-outline-light" for="btnradio1">Market ({{ markets.length }})</router-link>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <router-link to="/market/achats" class="btn btn-outline-light" for="btnradio2">Mes achats en attente ({{ achats.length }})</router-link>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" checked>
                <router-link to="/market/ventes" class="btn btn-outline-light" for="btnradio3">Mes ventes en attente ({{ ventes.length }})</router-link>
            </div>


            <div class="vente-container row">
                <div class="vente-item col-md-12 col-xs-12" v-for="vente in ventes" :key="vente.id">
                    <a class="img-planted" :style="{ 'border-color': vente ? vente.item.niveau.color : 'grey' }">
                        <img :src="vente.item.plante.image_url" alt="plante Image" />
                    </a>
                    <div class="info-item">
                        <div class="header-item">
                            <span class="espece">
                                {{ vente.item.plante.espece }}
                            </span>
                            <hr/>
                            <span class="infos">
                                <span class="vendeur">
                                    <strong>Acheteur : </strong> 
                                    {{ vente.acheteur.lastname +' '+ vente.acheteur.firstname }}
                                </span>
                                <span class="prix">
                                    <img src="@/assets/img/coin.png" alt="coin" />{{ vente.prix }}
                                </span>
                            </span>
                            <hr/>
                        </div>
                        <div class="footer-item">
                            <span class="badge" :style="{ 'background-color': vente ? vente.item.niveau.color : 'grey' }">
                                {{ vente.item.niveau.niveau }}
                            </span>
                            <div class="btn-group">
                                <button class="btn btn-primary" @click="handleAcceptVente(vente)">
                                    Accepter la vente
                                </button>
                                <button class="btn btn-danger" @click="handleRefuseVente(vente)">
                                    Refuser la vente
                                </button>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>
  
</template>

<style scoped>
.bg-vente {
    width: 100%;
    min-height: 100vh;
}
.bg-vente #menu{
    margin-bottom: 20px;
    width: 100%;
    margin-top: 60px;
}

.vente-container {
    width: 100%;
    height: 100%;
    color: black;
}
.vente-item {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.vente-item .img-planted{
    width: 200px;
    border: 5px solid;
}
.vente-item .img-planted img {
    width: 190px;
    height: 190px;
    object-fit: cover;
}
.vente-item .img-planted img:hover{
  cursor: pointer;
  opacity: 0.9;
}
.vente-item p{
    margin-bottom: 0;
}
.vente-item .espece {
    font-size: 24px;
    font-weight: bold;
}
.vente-item .infos {
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
.vente-item .infos .prix{
    font-size: 28px;
    font-weight: bold;
    display: flex;
    margin-right: 10px;
}
.vente-item .infos .prix img{
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


/* Add styles here for small screens */
@media screen and (max-width: 768px)
{
    .vente-item{
        width: 100%;
    }
    .vente-item .img-planted{
        width: 120px;
        border: 5px solid;
    }
    .vente-item .img-planted img {
        width: 110px;
        height: 110px;
        object-fit: cover;
    }

    .vente-item .espece {
        font-size: 18px;
    }
    .vente-item .infos {
        font-size: 12px;
    }

    hr {
        margin: 4px 0;
        border: 0;
        border-top: none;
    }

    .info-item{
        height: 120px;
        width: 100%;
    }
    .info-item .header-item{
        height: 20%;
    }
    .info-item .footer-item .prix{
        font-size: 16px;
    }
    .info-item .footer-item .prix img{
        width: 30px;
    }

    .info-item .footer-item .badge{
        display: none;
    }

    .info-item .footer-item .btn{
        width: 100%;
        font-size: 8px;
        height: auto;
    }
}
</style>