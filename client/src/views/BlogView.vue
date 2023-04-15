<script>
import NavBar from '../components/NavBar.vue';

  export default {
    setup() {
    },
    components: { NavBar },

    data() {
      return {
        searchTerm: "",
        displayedBlogs: [],
        currentPage: 1,
        blogsPerPage: 6
      };
    },
    created() {
      for (let i = 1; i <= 5; i++) {
        this.displayedBlogs.push({
          title: "Blog " + i,
          content: "Bonjour"
        });
      }
    },
    computed: {
      totalPages() {
        return Math.ceil(this.displayedBlogs.length / this.blogsPerPage);
      }
    },
    methods: {
      searchBlogs() {
        this.displayedBlogs = this.displayedBlogs.filter(blog =>
          blog.title.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
        this.currentPage = 1;
      },
      prevPage() {
        this.currentPage--;
      },
      nextPage() {
        this.currentPage++;
      }
    }
  };
</script>

<template>
    <div class="bg-blog">
        <NavBar />
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
</template>

<style>

    .bg-blog {
        background-image: url('../assets/img/grass.jpg');
        background-repeat:repeat;
        background-size: cover;
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
</style>