<script>
import NavBar from '../components/NavBar.vue';

  export default {
    components: { NavBar },

    data() {
      return {
        article: {
          title: "Bonjour",
          description: "Bonjour",
          rarity: "Bonjour",
          time: "Bonjour"
        }
      };
    },
    methods: {
      goBack() {
        this.$router.go(-1);
      }
    }
  };
  </script>
  
  <template>
    <div class="bg-block">
      <NavBar />
      <div class="text-center">
        <div class="article-container">
          <div class="article-image">
            <img src="../assets/img/logo.png" alt="Article Image" />
          </div>
          <div class="article-info">
            <button @click="goBack">Retour</button>
            <h2>{{ article.title }}</h2>
            <p>{{ article.description }}</p>
            <p>Rareté : {{ article.rarity }}</p>
            <p>Temps : {{ article.time }}</p>
          </div>
        </div>
      </div>
    </div>
  </template>


  <style>

  .bg-block {
    background-image: url('../assets/img/grass.jpg');
    background-repeat: repeat;
    background-size: cover;
    height: 100%;
    color: white;
  }

  .article-container {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

.article-image {
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.article-image img {
    width: 60%;
    height: auto;
}

.article-info {
    width: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

button {
    margin-bottom: 20px;
}
  </style>