<script>
import NavBar from '@/components/NavBar.vue'
import {ref, watchEffect} from 'vue';
import { useRoute } from 'vue-router'
import moment from 'moment'

import { getBlog } from '@/services/blogs'

  export default {
    components: { NavBar },
    name: "BlogPostView",

    setup() {
      moment.locale('fr_FR')
    
      const route = useRoute()
      const blog = ref(null)

      watchEffect(async () => {
        blog.value = await getBlog(route.params.id)
      })
      
      return {
        blog,
        moment
      }
    }
  };
</script>
  
<template>

  <NavBar />

  <div class="bg-block">
    
    <div class="text-center">

      <div class="article-container">
          <div class="article-image">
            <img :src="blog ? blog.plante.image_url : ''" alt="Article Image" />
          </div>

          <div class="article-info">
            <h1>{{ blog.title }}</h1>
            <div>{{ blog.description }}</div>
            <hr>
            <div class="article-content">
              <h2>Informations sur la plante :</h2>
              <p><strong>Espece :</strong> {{ blog.plante.espece }}</p>
              <p><strong>Genre :</strong> {{ blog.plante.genre }}</p>
              <p class="area"><strong>Explications :</strong><br/> {{ blog.area }}</p>
            </div>
            <hr>
            <div class="metadata">
              <p><strong>Publié par</strong> {{ blog.user_id.lastname + " " + blog.user_id.firstname }}
                Le {{ moment(blog.created_at).format('DD MMM YYYY à HH:mm') }}</p>
            </div>

          </div>
      </div>
      
      <div class="container">
        <div class="btn-group">
          <RouterLink to="/blogs" class="btn btn-light btn-lg">Liste des blogs</RouterLink>

          <RouterLink v-if="blog.user_id.roles.includes('ROLE_BLOGER')" to="/mes-blogs" class="btn btn-outline-light btn-lg">Liste de mes blogs</RouterLink>
        </div>
      </div>
    </div>

  </div>
</template>


<style>

.bg-block {
  background-image: url('@/assets/img/background.jpg');
  background-repeat: repeat;
  background-size: cover;
  height: 100%;
  color: white;
  height: 100vh;
}

h1{
  font-size: 50px;
}
h2{
  font-size: 30px;
  margin-bottom: 20px;
}

.article-container {
  display: flex;
  align-items: center;
  justify-content: space-around;
  flex-grow: 1;
}

.article-image {
  width: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 80px;
}

.article-image img {
  width: 60%;
  height: 600px;
  object-fit: cover;
}

.article-info {
  width: 50%;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5);
  margin-right: 80px;
}

.article-content {
  width: 100%;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.article-content .area{
  white-space: pre-line;
  width:100%;
  text-align: justify;
  text-overflow: ellipsis;
  overflow: hidden;
  padding: 10px;
}

hr {
  width: 80%;
}
button {
  margin-bottom: 20px;
}
</style>