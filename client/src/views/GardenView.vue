<script>
import NavBar from '@/components/NavBar.vue'

export default {
  name: 'GardenView',
  components: {
    NavBar
  },
  data () {
    return {
      title: 'Garden'
    }
  },
  methods: {
    searchPlants () {
      this.displayedPlants = this.displayedPlants.filter(plant =>
        plant.title.toLowerCase().includes(this.searchTerm.toLowerCase())
      )
    }
  }
}
</script>

<template>
  
  <NavBar />
    
  <div class="garden">

    <div class="plantations">
      <div class="list-plants">
        <div class="item-plant">
          <img src="../assets/img/logo.png" alt="Plante" />
          <div>
            <p>Plante 1</p>
            <p>Timer 5h25s</p>
          </div>
        </div>
        <div class="item-plant">
          <img src="../assets/img/logo.png" alt="Plante" />
          <div>
            <p>Plante 2</p>
            <p>Timer 5h42s</p>
          </div>
        </div>
        <div class="item-plant">
          <img src="../assets/img/logo.png" alt="Plante" />
          <div>
            <p>Plante 3</p>
            <p>Timer 8h45s</p>
          </div>
        </div>
        <div class="item-plant">
          <img src="../assets/img/logo.png" alt="Plante" />
          <div>
            <p>Plante 4</p>
            <p>Timer 10h45s</p>
          </div>
        </div>
      </div>
    </div>

    <div class="inventory">

      <h1>Inventaire</h1>

      <div class="search-bar">
        <input type="text" placeholder="Rechercher une plante" />
        <button class="button">Rechercher</button>
      </div>

      <div class="list-items">
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
        <div class="item">
          <img src="../assets/img/logo.png" alt="Plante" />
        </div>
      </div>

    </div>

  </div>

  <div id="actions">
    <button class="button">Arroser</button>
    <button class="button">Planter</button>
    <button class="button">Récolter</button>
    <button class="button">Détails</button>
  </div>

</template>

<style scoped>
.garden{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 80vh;
}

.plantations{
  width: 70%;
  height: 80vh;
  color: white;
}

.list-plants{
  display: grid;
  grid-template-columns: 2fr 2fr;
  width: 100%;
  height: 100%;
}
.item-plant{
  width: 100%;
  height: 100%;
  padding: 10px;
  background-color: rgb(62, 97, 43);
  border: 1px black solid;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}

.item-plant img{
  width: 40%;
  height: auto;
  object-fit: cover;
  cursor: grab;
}

.inventory{
  width: 30%;
  height: 80vh;
  background-color: #3b2804;
  color : white;
}

.search-bar{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 5%;
  margin-bottom: 20px;
}

.search-bar input{
  width: 80%;
  height: 100%;
  border: 1px black solid;
  border-radius: 5px;
}

.search-bar button{
  width: 20%;
  height: 100%;
  border: 1px black solid;
  border-radius: 5px;
  background-color: #28a745;
  color: white;
  cursor: pointer;
}

.search-bar button:hover{
  background-color: white;
  color: #28a745;
}


.list-items{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: auto;
  flex-wrap: wrap;
  overflow-y: scroll;
}

.item{
  width: 100px;
  height: 100px;
  background-color: rgb(56, 54, 54);
  border: 1px black solid;
  cursor: grab;
}
.item:hover{
  background-color: rgb(62, 97, 43);
}

.item img{
  width: 100%;
  height: 100%;
}

#actions{
  background-color: #9b7021;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 12vh;
}

#actions .button{
  width: 100%;
  margin: 20px;
  height: 50%;
  border: 1px black solid;
  border-radius: 5px;
  background-color: #28a745;
  color: white;
  cursor: pointer;
}

#actions .button:hover{
  background-color: white;
  color: #28a745;
}
</style>
