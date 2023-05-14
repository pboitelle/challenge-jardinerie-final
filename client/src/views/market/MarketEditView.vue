<script>
import NavBar from '@/components/NavBar.vue'
import Popup from '@/components/Popup.vue'
import { useRoute } from 'vue-router'
import {ref, computed, watchEffect} from 'vue';
import { getMarket, editMarket, deleteMarket } from '@/services/markets.js'

export default {
  components: { NavBar, Popup },
  name: 'MarketEditView',

  setup() {
    const route = useRoute()
    const prix = ref(null)
    const market = ref(null)

    const popupVisible = ref(false)
    const popupTitle = ref('L\'item sur le marché a bien été édité !') 
    const popupType = ref('success')

    const closePopup = () => {
      popupVisible.value = false
    }

    watchEffect(async () => {
        const response = await getMarket(route.params.id)

        if (response.status === 200) {
            market.value = response.data
            prix.value = market.value.prix
        }
        else if (response.status === 404){
            window.location.href = '/garden'
        }
        else if (response.status === 403){
            window.location.href = '/garden'
        }

    })

    const handleEdit = async () => {

        try {
            const response = await editMarket(market.value.id, {
                prix: parseInt(prix.value)
            })

            if (response.status === 200){
                popupVisible.value = true
            }else{
                popupTitle.value = 'Une erreur est survenue'
                popupType.value = 'danger'
                popupVisible.value = true
            }             
        }
        catch (error) {
            alert('Une erreur est survenue')
        }
    }

    const handleDelete = async () => {

        try {
            const response = await deleteMarket(market.value.id)

            if (response.status === 204){
                window.location.href = '/garden'
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

    const showValue = (newValue) => {
        document.getElementById("valBox").innerHTML=newValue;
    }

    return {
        market,
        prix,
        popupTitle,
        popupType,
        popupVisible,
        closePopup,
        handleEdit,
        handleDelete,
        showValue
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

            <h1 class="title">Gérer la vente de l'item n° {{ market ? market.item_id.id : '' }}</h1>

            <div class="market-item col-md-6 col-xs-12">
                <a class="img-planted" :style="{ 'border-color': market ? market.item_id.niveau.color : 'grey' }">
                    <img :src="market ? market.item_id.plante.image_url : '' " alt="plante Image" />
                </a>

                <form class="form" @submit.prevent="handleEdit">

                    <div class="form__group">
                        <label for="prix" class="form__label">Prix</label>
                        
                        <div class="info-coins">
                            <input v-model="prix" type="range" id="prix" min="1" max="100" class="form__input" @change="showValue(prix)" />
                            <div class="coins">
                                <span id="valBox">{{prix}}</span>
                                <img src="@/assets/img/coin.png" alt="coin" />
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <RouterLink to="/garden" class="btn btn-primary">Retour</RouterLink>
                        <button class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Modifier le prix</button>
                    </div>

                </form>
            </div>

            <a id="delete" @click="handleDelete" class="btn btn-danger"><i class="fa-solid fa-square-minus"></i> Retirer du marché</a>

        </div>

    </main>
  
</template>

<style>
.bg-market {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px 0;
    color: white;
}
.bg-market .title {
    margin-bottom: 20px;
    
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

.form__group {
  margin-bottom: 20px;
} 

.form__label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form__input {
  display: block;
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid rgb(86, 145, 81);
}

.buttons{
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.info-coins{
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.coins{
    display: flex;
    align-items: center;
    color: white;
    margin-left: 10px;
}
.coins img{
    width: 20px;
    height: 20px;
}

#delete{
    margin-top: 0;
    margin-right: 0;
    width: 50%;
}

</style>