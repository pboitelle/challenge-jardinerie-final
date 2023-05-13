<script>
import NavBar from '@/components/NavBar.vue'
import { useRoute } from 'vue-router'
import {ref, computed, watchEffect} from 'vue';
import { getItem } from '@/services/items.js'
import { createMarket } from '@/services/markets.js'

export default {
  components: { NavBar },
  name: 'MarketAddView',

  setup() {
    const route = useRoute()
    const prix = ref(50)
    const item = ref(null)

    watchEffect(async () => {
        const response = await getItem(route.params.id)

        if (response.status === 200) {
            item.value = response.data
        }
        else if (response.status === 403){
            window.location.href = '/garden'
        }

    })

    const handleCreate = async () => {

        try {
            const response = await createMarket({
                item_id: item.value.id,
                prix: parseInt(prix.value)
            })

            if (response.status === 201){
                window.location.href = '/garden'
            }else{
                window.location.href = '/garden'
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
        item,
        prix,
        handleCreate,
        showValue
    }
  }
}
</script>

<template>

    <NavBar />

    <main class="main-dark">

        <div class="container bg-market bg-dark">

            <h1 class="title">Mettre en vente</h1>

            <div class="market-item col-md-6 col-xs-12">
                <a class="img-planted" :style="{ 'border-color': item ? item.niveau.color : 'grey' }">
                    <img :src="item ? item.plante.image_url : '' " alt="plante Image" />
                </a>

                <form class="form" @submit.prevent="handleCreate">

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
                        <button class="btn btn-light"><i class="fa-regular fa-circle-check"></i> Mettre en vente</button>
                    </div>

                </form>
            </div>

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

</style>