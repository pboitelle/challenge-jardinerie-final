<script>
import NavBar from '@/components/NavBar.vue'
import {ref, computed, watchEffect} from 'vue';
import { getPlantes } from '@/services/plantes.js'


export default {
  components: { NavBar },
  name: 'PlantesView',

  setup() {
    const searchTerm = ref("");

    const plantes = ref([])

    watchEffect(async () => {
      plantes.value = await getPlantes()
    })


    const searchResults = computed(() => {
      // Filtrer les résultats selon le searchTerm
      return plantes.value.filter(plante =>
        plante.espece.toLowerCase().includes(searchTerm.value.toLowerCase())
      );
    });

    const displayedPlantes = computed(() => {
      // Découper les résultats en pages
      const startIndex = (currentPage.value - 1) * plantesPerPage.value;
      const endIndex = startIndex + plantesPerPage.value;
      return searchResults.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => {
      // Calculer le nombre total de pages
      return Math.ceil(searchResults.value.length / plantesPerPage.value);
    });

    const currentPage = ref(1);
    const plantesPerPage = ref(10);

    const searchPlantes = () => {
      // Mettre à jour la page courante pour afficher le premier page de résultats
      currentPage.value = 1;
    }

    const prevPage = () => {
      currentPage.value--;
    }

    const nextPage = () => {
      currentPage.value++;
    }

    return {
      searchTerm,
      plantes,
      displayedPlantes,
      currentPage,
      plantesPerPage,
      totalPages,
      searchPlantes,
      prevPage,
      nextPage
    }
  }
}
</script>

<template>
    
  <NavBar />

  <main class="main">

    <div class="bg-plante">

      <div class="search-bar text-center">
          <input type="text" placeholder="Rechercher une plante" v-model="searchTerm" @input="searchPlantes" />
      </div>

      <div class="plantes-container">
          <div class="plante-item" v-for="plante in displayedPlantes" :key="plante.id">
                <img :src="plante.image_url" alt="plante Image" />
                <div class="footer-item">
                    <p>
                        <span class="espece">{{ plante.espece }}</span><br/>
                        <span class="genre">{{ plante.genre }}</span>
                    </p>
                    <router-link class="btn btn-info" v-if="plante.blog && plante.blog.isValidate" :to="'blogs/'+plante.blog.id">
                        <i class="fa-solid fa-newspaper"></i>
                    </router-link>
                    <button v-else-if="plante.blog && !plante.blog.isValidate" class="btn btn-warning"><i class="fa-solid fa-rotate"></i></button>
                    <RouterLink v-else :to="{ name: 'plantes-create-blog', params: { id: plante.id } }" class="btn btn-primary">
                        <i class="fa-solid fa-pen-clip"></i>
                    </RouterLink>
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

<style scoped>
.bg-plante {
    width: 100%;
    height: 100%;
    min-height: 100vh;
}
.search-bar {
    margin-top: 20px;
}

.search-bar input {
    padding: 10px;
    border: 1px solid black;
    border-radius: 5px;
    margin-right: 10px;
    width: 80%;
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

.plantes-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    width: 100%;
}

.plante-item {
    width: 300px;
    height: 200px;
    padding: 20px;
    border: 1px solid black;
    box-shadow: 2px 2px 10px 2px rgba(0,0,0,0.75);
    margin: 40px; 
    border-radius: 10px;
    background-color: white;
}
.plante-item img {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
    object-fit: cover;
}
.plante-item .espece {
    font-size: 18px;
    margin-bottom: 5px;
}
.plante-item .genre {
    font-size: 12px;
}

.footer-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>