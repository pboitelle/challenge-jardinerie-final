<script>
import { ref, watchEffect } from 'vue'
import { getBlogs, deleteBlog } from '@/services/blogs'
import moment from 'moment'

export default {
  name: 'BlogsView',
  setup() {
    moment.locale('fr')
    
    const blogs = ref([])

    watchEffect(async () => {
      blogs.value = await getBlogs()
    })

    const handleDelete = async (id) => {

      try {
        const response = await deleteBlog(id)

        if (response.status === 204) {
          window.location.href = '/admin/blog'
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }
    
    return {
      blogs,
      moment,
      handleDelete
    }
  }
}
</script>

<template>
  <div class="blogs">

    <h1>Liste des blogs</h1>

    <div class="table-responsive">
      <table class="table table-success table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">N°</th>
            <th scope="col">Auteur</th>
            <th scope="col">Plante</th>
            <th scope="col">Title</th>
            <th scope="col">Créé le</th>
            <th scope="col">Publié</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <tr v-for="blog in blogs" :key="blog.id">
            <td>{{ blog.id }}</td>
            <td>{{ blog.user_id.lastname + ' ' + blog.user_id.firstname }}</td>
            <td>{{ blog.plante.espece }}</td>
            <td>{{ blog.title }}</td>
            <td>{{ moment(blog.created_at).format('DD MMM YYYY à HH:mm') }}</td>
            <td>
              <span v-if="blog.isValidate" class="badge bg-info">Publié</span>
              <span v-else class="badge bg-warning">En attente</span>
            </td>
            <td>
              <a v-if="blog.isValidate" @click="handleDelete(blog.id)" class="btn btn-danger btn-sm">
                <i class="fa-regular fa-trash-can"></i> Retirer
              </a>
              <router-link :to="{ name: 'admin-validation-blog', params: { id: blog.id } }" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editer
              </router-link>
              
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <RouterLink to="/admin" class="btn btn-primary">Retour</RouterLink>
  </div>
</template>

<style scoped>
.blogs {
  margin-top: 50px;
  background-color: rgb(86, 145, 81);
  padding: 20px;
  border-radius: 10px;
  color: white;
}


h1 {
  text-align: center;
}
</style>