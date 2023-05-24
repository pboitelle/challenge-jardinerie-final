<script>
import NavBar from '@/components/NavBar.vue'
import {ref, computed, watchEffect} from 'vue';
import { getBlogsUser } from '@/services/users.js'
import { userConnected } from '@/middleware/userAuth.js'


export default {
  components: { NavBar },
  name: 'BlogsView',

  setup() {
    const searchTerm = ref("");
    const user = ref(null)

    const blogs = ref([])

    watchEffect(async () => {
        user.value = await userConnected()
        blogs.value = await getBlogsUser(user.value.id)
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
      user,
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

        <RouterLink id="devenir-bloger" to="/plantes" class="btn btn-info">
            <i class="fa-solid fa-newspaper"></i> Soumettre un blog
        </RouterLink>

        <div class="search-bar text-center">
            <input type="text" placeholder="Rechercher un de mes blogs" v-model="searchTerm" @input="searchBlogs" />
            <button @click="searchBlogs" class="button">Rechercher</button>
        </div>

        <div class="blogs-container">
            <div class="blog-item" v-for="blog in displayedBlogs" :key="blog.id">
              <div class="image-container" :style="{ '--ma-couleur': blog.isValidate ? '#17a2b8' : '#ffc107' }">
                <img :src="blog.plante.image_url" alt="Blog Image" />
                <div>
                  <div class="btn-publish" v-if="blog.isValidate">Publié</div>
                  <div class="btn-notpublish" v-else>En <br/> attente</div>
                </div>
              </div>

                <h2>{{ blog.title }}</h2>
                <p>{{ blog.description }}</p>
                <RouterLink :to="{ name: 'blogs-post', params: { id: blog.id } }" class="btn btn-info">
                    <i class="fa-solid fa-newspaper"></i> Lire
                </RouterLink>
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
    width: 100%;
    height: 100%;
    min-height: 100vh;
}
.search-bar {
    margin-top: 20px;
}

.search-bar input {
    width: 30%;
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

.btn-group {
    display: flex;
    justify-content: space-between;
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
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  width: 100%;
}

.blog-item {
  width: 25%;
  padding: 0;
  border: 1px solid black;
  box-shadow: 2px 2px 10px 2px rgba(0,0,0,0.75);
  margin: 40px; 
  border-radius: 10px;
  background-color: white;
}
.blog-item img {
  width: 100%;
  height: 400px;
  margin-bottom: 10px;
  object-fit: cover;
  position: relative;
  border-radius: 10px 10px 0 0;
}
.image-container {
  position: relative;
}
.image-container::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  width: 0;
  height: 0;
  border-top: 70px solid var(--ma-couleur);
  border-left: 70px solid transparent;
  border-right: 70px solid var(--ma-couleur);
  border-bottom: 70px solid transparent;
  border-radius: 0 10px 0 0;
  font-weight: bold;
  font-size: 16px;
  color: white;
  text-align: left;
}
.image-container .btn-publish{
  position: absolute;
  top: 28px;
  right: 12px;
  padding: 5px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  background-color: transparent;
  z-index: 10;
}
.image-container .btn-notpublish{
  position: absolute;
  top: 12px;
  right: 7px;
  padding: 5px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  background-color: transparent;
  z-index: 10;
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