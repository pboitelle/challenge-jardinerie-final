<script>
import NavBar from '@/components/NavBar.vue'
import Popup from '@/components/Popup.vue'
import Modal from '@/components/Modal.vue'
import {ref, computed, watchEffect} from 'vue';

import { getItemsUser, getItemsMarketUser } from '@/services/users.js'
import { updateIsPlantedItem } from '@/services/items.js'
import { userConnected } from '@/middleware/userAuth.js'

export default {
  name: 'GardenView',
  components: {
    NavBar,
    Modal,
    Popup
  },
  setup() {
    const user = ref(null)
    const showModal = ref(false)
    
    const popupVisible = ref(false)
    const popupTitle = ref('L\'item a été planté !')
    const popupType = ref('success')

    const itemSelected = ref(null)
    const items = ref([])
    const itemsPlanted = ref([])
    const itemsInventory = ref([])
    const itemsMarket = ref([])

    watchEffect(async () => {
      user.value = await userConnected()
      items.value = await getItemsUser(user.value.id)
      itemsMarket.value = await getItemsMarketUser(user.value.id)
      itemsInventory.value = items.value.filter(item => !item.isPlanted)
      itemsPlanted.value = items.value.filter(item => item.isPlanted)
    })

    const openModal = (item) => {
      itemSelected.value = item
      showModal.value = !showModal.value
    }
    const closeModal = () => {
      showModal.value = false
    }
    const closePopup = () => {
      popupVisible.value = false
    }
    const arroser = (arrosoir) => {
      const arrosoir_element = document.querySelector(arrosoir)
      arrosoir_element.style.display = 'block'
      setTimeout(() => {
        arrosoir_element.style.display = 'none'
      }, 3500)
    }

    const plantItem = async (item) => {
      if (itemsPlanted.value.length === 4) {
        closeModal()
        popupType.value = 'danger'
        popupTitle.value = 'Vous avez déjà 4 plantes en cours de croissance !'
        popupVisible.value = true
        return
      }

      try {
        const response = await updateIsPlantedItem(item.id, {
          isPlanted: true
        })
        if (response) {
          itemsInventory.value = itemsInventory.value.filter(i => i.id !== item.id)
          itemsPlanted.value.push(item)
          closeModal()
          popupVisible.value = true
        }
      }
      catch (error) {
        alert('error')
      }
    }
    const deterreItem = async (item) => {

      try {
        const response = await updateIsPlantedItem(item.id, {
          isPlanted: false
        })
        if (response) {
          itemsPlanted.value = itemsPlanted.value.filter(i => i.id !== item.id)
          itemsInventory.value.push(item)
          closeModal()
          popupTitle.value = 'L\'item a été déterré !'
          popupVisible.value = true
        }
      }
      catch (error) {
        alert('error')
      }
    }

    return {
      user,
      itemsMarket,
      itemsInventory,
      itemsPlanted,
      openModal,
      closeModal,
      showModal,
      itemSelected,
      plantItem,
      deterreItem,
      popupVisible,
      closePopup,
      popupTitle,
      popupType,
      arroser
    }
  }
}
</script>

<template>

  <div>
      <popup :title="popupTitle" v-if="popupVisible" @close="closePopup" :autoClose="3000" :type="popupType" />
  </div>

  <NavBar />

  <div class="garden">

    <div class="plantations">
      <div class="list-plants">

          <div class="item-plant" v-if="itemsPlanted[0]">
            <a class="img-planted" @click="openModal(itemsPlanted[0])" data-toggle="modal" data-target="#exampleModalCenter" :style="{ 'border-color': itemsPlanted[0] ? itemsPlanted[0].niveau.color : 'grey' }">
              <img :src="itemsPlanted[0] ? itemsPlanted[0].plante.image_url : 'src/assets/img/truelle.png' " alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir1" id="arrosoir1" />
            <div class="details-plant">
              <p>
                {{ itemsPlanted[0] ? itemsPlanted[0].plante.espece : '' }}
              </p>
              <div class="btn-group">
                  <a class="btn btn-outline-primary" @click="arroser('#arrosoir1')">
                    <i class="fa-solid fa-droplet"></i>
                  </a>
                  <a @click="openModal(itemsPlanted[0])" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-light">
                    <i class="fa-solid fa-info"></i>
                  </a>
              </div>
            </div>
          </div>
          <div class="item-plant" v-else>
            <a class="img-planted" data-toggle="modal" data-target="#exampleModalCenter" style="border-color: grey">
              <img src="@/assets/img/truelle.png" alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir4" id="arrosoir4" />
            <div class="details-plant">
              <p>
                Aucune plante
              </p>
            </div>
          </div>

          <div class="item-plant" v-if="itemsPlanted[1]">
            <a class="img-planted" @click="openModal(itemsPlanted[1])" data-toggle="modal" data-target="#exampleModalCenter" :style="{ 'border-color': itemsPlanted[1] ? itemsPlanted[1].niveau.color : 'grey' }">
              <img :src="itemsPlanted[1] ? itemsPlanted[1].plante.image_url : 'src/assets/img/truelle.png' " alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir2" id="arrosoir2" />
            <div class="details-plant">
              <p>
                {{ itemsPlanted[1] ? itemsPlanted[1].plante.espece : '' }}
              </p>
              <div class="btn-group">
                  <a class="btn btn-outline-primary" @click="arroser('#arrosoir2')">
                    <i class="fa-solid fa-droplet"></i>
                  </a>
                  <a @click="openModal(itemsPlanted[1])" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-light">
                    <i class="fa-solid fa-info"></i>
                  </a>
              </div>
            </div>
          </div>
          <div class="item-plant" v-else>
            <a class="img-planted" data-toggle="modal" data-target="#exampleModalCenter" style="border-color: grey">
              <img src="@/assets/img/truelle.png" alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir4" id="arrosoir4" />
            <div class="details-plant">
              <p>
                Aucune plante
              </p>
            </div>
          </div>

          <div class="item-plant" v-if="itemsPlanted[2]">
            <a class="img-planted" @click="openModal(itemsPlanted[2])" data-toggle="modal" data-target="#exampleModalCenter" :style="{ 'border-color': itemsPlanted[2] ? itemsPlanted[2].niveau.color : 'grey' }">
              <img :src="itemsPlanted[2] ? itemsPlanted[2].plante.image_url : 'src/assets/img/truelle.png' " alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir3" id="arrosoir3" />
            <div class="details-plant">
              <p>
                {{ itemsPlanted[2] ? itemsPlanted[2].plante.espece : '' }}
              </p>
              <div class="btn-group">
                  <a class="btn btn-outline-primary" @click="arroser('#arrosoir3')">
                    <i class="fa-solid fa-droplet"></i>
                  </a>
                  <a @click="openModal(itemsPlanted[2])" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-light">
                    <i class="fa-solid fa-info"></i>
                  </a>
              </div>
            </div>
          </div>
          <div class="item-plant" v-else>
            <a class="img-planted" data-toggle="modal" data-target="#exampleModalCenter" style="border-color: grey">
              <img src="@/assets/img/truelle.png" alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir4" id="arrosoir4" />
            <div class="details-plant">
              <p>
                Aucune plante
              </p>
            </div>
          </div>

          <div class="item-plant" v-if="itemsPlanted[3]">
            <a class="img-planted" @click="openModal(itemsPlanted[3])" data-toggle="modal" data-target="#exampleModalCenter" :style="{ 'border-color': itemsPlanted[3] ? itemsPlanted[3].niveau.color : 'grey' }">
              <img :src="itemsPlanted[3] ? itemsPlanted[3].plante.image_url : 'src/assets/img/truelle.png' " alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir4" id="arrosoir4" />
            <div class="details-plant">
              <p>
                {{ itemsPlanted[3] ? itemsPlanted[3].plante.espece : '' }}
              </p>
              <div class="btn-group">
                  <a class="btn btn-block btn-outline-primary" @click="arroser('#arrosoir4')">
                    <i class="fa-solid fa-droplet"></i>
                  </a>
                  <a @click="openModal(itemsPlanted[3])" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-block btn-light">
                    <i class="fa-solid fa-info"></i>
                  </a>
              </div>
            </div>
          </div>
          <div class="item-plant" v-else>
            <a class="img-planted" data-toggle="modal" data-target="#exampleModalCenter" style="border-color: grey">
              <img src="@/assets/img/truelle.png" alt="Plante" />
            </a>
            <img src="src/assets/img/arrosoir.gif" alt="arrosoir4" id="arrosoir4" />
            <div class="details-plant">
              <p>
                Aucune plante
              </p>
            </div>
          </div>

      </div>
    </div>

    <div class="inventory">

      <h1>Inventaire</h1>

      <div class="list-items">
        <div class="item" v-for="item in itemsInventory" :key="item.id" :style="{ 'border-color': item.niveau.color ? item.niveau.color : 'grey' }">
          <a @click="openModal(item)" data-toggle="modal" data-target="#exampleModalCenter">
            <img :src="item.plante.image_url" alt="Plante" />
          </a>
        </div>
      </div>

      <h1>Items en vente</h1>

      <div class="list-ventes">
        <div class="item" v-for="market in itemsMarket" :key="market.id" :style="{ 'border-color': market.item_id.niveau.color ? market.item_id.niveau.color : 'grey' }">
          <router-link :to="{ name: 'market-edit', params: { id: market ? market.id : '1' } }">
            <img :src="market.item_id.plante.image_url" alt="Plante" />
          </router-link>
        </div>
      </div>

      <Modal :title="itemSelected ? 'Détails item n° '+itemSelected.id : '' " :showModal="showModal" :close="closeModal">

        <div class="details">
          <img :src="itemSelected ? itemSelected.plante.image_url : '' " alt="Plante" :style="{ 'border-color': itemSelected ? itemSelected.niveau.color : 'grey' }" />
          <div>
            <p>
              <strong>Espèce : </strong>
              {{ itemSelected ? itemSelected.plante.espece : '' }}
            </p>
            <p>
              <strong>Genre : </strong>
              {{ itemSelected ? itemSelected.plante.genre : '' }}
            </p>
            <p>
              <strong>Niveau : </strong>
              <span class="badge" :style="{ 'background-color': itemSelected ? itemSelected.niveau.color : 'grey' }">
                {{ itemSelected ? itemSelected.niveau.niveau : '' }}
              </span>
            </p>
            <p v-if="itemSelected && !itemSelected.isPlanted">
              <strong>Vendre : </strong>
              <router-link :to="{ name: 'market-create', params: { id: itemSelected ? itemSelected.id : '1' } }" class="btn btn-dark">
                <i class="fa-regular fa-handshake"></i> Vendre l'item
              </router-link>
            </p>
            <p v-if="itemSelected && itemSelected.plante.blog">
              <strong>Blog : </strong>
              <router-link :to="itemSelected && itemSelected.plante.blog ? itemSelected.plante.blog : '/garden' " class="btn btn-info">
                  <i class="fa-solid fa-newspaper"></i> Lire
              </router-link>
            </p>
            <p v-else>
              <strong>
                Il n'y a pas encore de blog pour cette plante.
              </strong>
            </p>

            <p v-if="itemSelected && !itemSelected.isPlanted">
              <button id="action-plante" @click="plantItem(itemSelected)" class="btn btn-success">
                <i class="fa-solid fa-seedling"></i> Planter l'item
              </button>
            </p>
            <p v-else>
              <button id="action-plante" @click="deterreItem(itemSelected)" class="btn btn-outline-success">
                <i class="fa-solid fa-trowel"></i> Déplanter l'item
              </button>
            </p>

          </div>
        </div>
      </Modal>

    </div>

  </div>

</template>

<style scoped>
.garden{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 93vh;
}

.garden h1{
  text-align: center;
  margin-top: 10px;
  font-size: 36px;
}

.plantations{
  /* width: 40%; */
  height: 93vh;
  color: white;
}

.list-plants{
  display: grid;
  grid-template-columns: 2fr 2fr;
  width: 100%;
  height: 100%;
}
.item-plant{
  width: 380px;
  height: 100%;
  background-color: rgb(62, 97, 43);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}

.item-plant .img-planted{
  width: 100%;
  border: 5px solid;
}
.item-plant img{
  width: 370px;
  height: 370px;
  object-fit: cover;
}
.item-plant img:hover{
  cursor: pointer;
  opacity: 0.9;
}

.details-plant{
  width: 100%;
  height: 52px;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: center;
  background-color: #3b2804;
}

.details-plant p{
  font-size: 20px;
  font-weight: bold;
  margin-right: 20px;
  width: 70%;
}
.details-plant a{
  width: 100%;
}

.btn-group{
  width: 30%;
  margin-top: 0;
  margin-right: 5px;
}

.inventory{
  width: 100%;
  height: 93vh;
  background-color: #3b2804;
  color : white;
}

.list-items{
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: center;
  width: 100%;
  height: 400px;
  flex-wrap: wrap;
  overflow-y: scroll;
}

.item{
  width: 150px;
  height: 150px;
  background-color: rgb(56, 54, 54);
  cursor: grab;
  border: 5px solid;
  margin: 5px;
}
.item:hover{
  background-color: rgb(62, 97, 43);
  transform: scale(0.9);
  transition: all 0.2s ease-in-out;
}

.item img{
  width: 100%;
  height: 100%;
  cursor: grabbing;
}

.details{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 100%;
}
.details img{
  width: 50%;
  height: 100%;
  object-fit: cover;
  border: 5px solid;
}

.details #action-plante{
  width: 100%;
  height: 100%;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

.list-ventes{
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  width: 100%;
  height: 200px;
  flex-wrap: wrap;
  overflow-y: scroll;
}

#arrosoir1, 
#arrosoir2, 
#arrosoir3, 
#arrosoir4{
  width: 350px;
  height: 350px;
  object-fit: cover;
  background-color: transparent;
  border: none;
  cursor: pointer;
  position: absolute;
  z-index: 100000;
  display: none;
}

/* width */
::-webkit-scrollbar {
  width: 30px;
}
/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
/* Handle */
::-webkit-scrollbar-thumb {
  background: rgb(62, 97, 43);
}
/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

@media screen and (max-width: 768px) {
  .garden{
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr;
  }

  .plantations{
    width: 100%;
    height: 100%;
  }

  .inventory{
    width: 100%;
    height: 100%;
    order: -1;
    border-bottom: #3b2804 10px solid;
  }

  .list-plants{
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr;
  }
}
</style>
