<script>
import NavBar from '@/components/NavBar.vue'
import {ref, computed, watchEffect} from 'vue';
import { getBlogsValidate } from '@/services/blogs.js'


export default {
  components: { NavBar },
  name: 'BlogsView',

  setup() {
    const searchTerm = ref("");

    const blogs = ref([])

    watchEffect(async () => {
      blogs.value = await getBlogsValidate()
    })


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
      </div>

      <div class="blogs-container row">
          <div class="blog-item col-md-6" v-for="blog in displayedBlogs" :key="blog.id">
              <img :src="blog.plante.image_url" alt="Blog Image" />
              <h2>{{ blog.title }}</h2>
              <p>{{ blog.description }}</p>
              <div class="buttons">
                <div><strong>Auteur :</strong> {{ blog.user_id.lastname + ' ' + blog.user_id.firstname }}</div>
                <RouterLink :to="{ name: 'blogs-post', params: { id: blog.id } }" class="btn btn-info">
                  <i class="fa-solid fa-newspaper"></i> Lire
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

.bg-blog {
  width: 100%;
  min-height: 100vh;
  height: 100%;
}
.search-bar {
  margin-top: 20px;
}

.search-bar input {
  width: 60%;
  padding: 10px;
  border: 1px solid black;
  border-radius: 5px;
  margin-right: 10px;
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

.blogs-container {
  margin-top: 20px;
}

.blog-item {
  padding: 20px;
  border: 1px solid black;
  box-shadow: 2px 2px 10px 2px rgba(0,0,0,0.75);
  border-radius: 10px;
  background-color: white;
}
.blog-item img {
  width: 100%;
  height: 400px;
  margin-bottom: 10px;;
  object-fit: cover;
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