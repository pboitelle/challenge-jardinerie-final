<script>
import NavBar from '@/components/NavBar.vue'
// import bootstrap
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min'


export default {
  name: 'MarketView',
  components: {
    NavBar
  },
  data () {
    return {
      title: 'Market'
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
  <div >
    <div class="search-bar">
      <input type="text" placeholder="Rechercher un item" />
      <button class="button">Rechercher</button>
    </div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">GRAINES</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">PLANTES</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link c-red" id="pills-sell-tab" data-bs-toggle="pill" data-bs-target="#pills-sell" type="button" role="tab" aria-controls="pills-sell" aria-selected="false">VENDRE</button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <!-- GRAINES -->
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="container">
          <div class="row">
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
              
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
          </div>
          <div class="row">
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              GRAINES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
          </div>
        </div>
      </div>
      <!-- PLANTES -->
      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="container">
          <div class="row">
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              PLANTES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              PLANTES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              PLANTES <button type="button" class="btn btn-primary">Acheter</button>
            </div>
            <div class="col-2 border w-25">
              <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
              PLANTES <button type="button" class="btn btn-primary">Acheter</button>
              </div>
            </div>
            <div class="row">
              <div class="col-2 border w-25">
                <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
                PLANTES <button type="button" class="btn btn-primary">Acheter</button>
              </div>
              <div class="col-2 border w-25">
                <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
                PLANTES <button type="button" class="btn btn-primary">Acheter</button>
              </div>
              <div class="col-2 border w-25">
                <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
                PLANTES <button type="button" class="btn btn-primary">Acheter</button>
              </div>
              <div class="col-2 border w-25">
                <img class="w-100" src="../assets/img/logo.png" alt="Plante" />
                PLANTES <button type="button" class="btn btn-primary">Acheter</button>
              </div>
            </div>
          </div>
      </div>
      <div class="tab-pane fade" id="pills-sell" role="tabpanel" aria-labelledby="pills-sell">
        <div class="container">
          <div class="row">
          </div>
        </div>
        <div>
          <button class="btn btn-danger">VENDRE</button>
        </div>
      </div>
    </div>
    
  </div>
  
  
  
</template>

<style>
  .c-red {
    color: red;
  }
</style>
