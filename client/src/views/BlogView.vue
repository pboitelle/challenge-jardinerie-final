<script>
import NavBar from '../components/NavBar.vue';
import {ref, computed} from 'vue';

export default {
  components: { NavBar },

  setup() {
    const searchTerm = ref("");
    const blogs = ref([]);

    for (let i = 1; i <= 9; i++) {
      blogs.value.push({
        title: `Blog ${i}`,
        content: `Contenu du blog ${i}`
      });
    }

    const searchResults = computed(() => {
      // Filtrer les résultats selon le searchTerm
      return blogs.value.filter(blog =>
        blog.title.toLowerCase().includes(searchTerm.value.toLowerCase())
      );
    });

    const displayedBlogs = computed(() => {
      // Découper les résultats en pages
      const startIndex = (currentPage.value - 1) * blogsPerPage.value;
      const endIndex = startIndex + blogsPerPage.value;
      return searchResults.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => {
      // Calculer le nombre total de pages
      return Math.ceil(searchResults.value.length / blogsPerPage.value);
    });

    const currentPage = ref(1);
    const blogsPerPage = ref(3);

    const searchBlogs = () => {
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
      blogs,
      displayedBlogs,
      currentPage,
      blogsPerPage,
      totalPages,
      searchBlogs,
      prevPage,
      nextPage
    }
  }
}
</script>

<template>
    
  <NavBar />

  <main class="main">

    <div class="bg-blog">

      <RouterLink id="devenir-bloger" to="/devenir-blogger" class="btn btn-info">
        <i class="fa-solid fa-newspaper"></i> Devenir Blogger ?
      </RouterLink>

      <div class="search-bar text-center">
          <input type="text" placeholder="Rechercher un blog" v-model="searchTerm" @input="searchBlogs" />
          <button @click="searchBlogs" class="button">Rechercher</button>
      </div>

      <div class="blogs-container">
          <div class="blog-item" v-for="(blog, index) in displayedBlogs" :key="index">
              <img src="../assets/img/logo.png" alt="Blog Image" />
              <h2>Bonjour</h2>
              <p>Bonjour</p>
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

.bg-blog {
    height: 100%;
}
.search-bar {
    margin-top: 20px;
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

.blogs-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.blog-item {
    width: 25%;
    padding: 20px;
    border: 1px solid black;
    box-shadow: 2px 2px 10px 2px rgba(0,0,0,0.75);
    margin: 40px; 
    border-radius: 10px;
    background-color: white;
}
.blog-item img {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
}
.blog-item h2 {
    margin-bottom: 5px;
}
.blog-item p {
    font-size: 12px;
}

#devenir-bloger{
  float: right;
  color: white;
  font-size: 20px;
  margin-right: 20px;
  margin-top: 20px;
}
</style>