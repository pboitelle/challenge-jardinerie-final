<script>
import { ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'

import { getBlog, editBlog, deleteBlog } from '@/services/blogs'

export default {
  name: 'BlogsValidationView',
  setup() {
    
    const route = useRoute()
    const blog = ref(null)
    const title = ref('')
    const description = ref('')
    const area = ref('')
    const isValidate = ref(false)

    watchEffect(async () => {
      blog.value = await getBlog(route.params.id)
      title.value = blog.value.title
      description.value = blog.value.description
      area.value = blog.value.area
      isValidate.value = blog.value.isValidate
    })

    const handleEdit = async () => {

      try {
        const response = await editBlog(route.params.id, {
          title: title.value,
          description: description.value,
          area: area.value,
          isValidate: isValidate.value
        })

        if (response)
          alert('Blog modifiée avec succès')
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }

    const handleDelete = async () => {

      try {
        const response = await deleteBlog(route.params.id)

        if (response.status === 204) {
          window.location.href = '/admin/blog'
        }
          
      }
      catch (error) {
        alert('Une erreur est survenue')
      }
    }
    
    return {
      blog,
      title,
      description,
      area,
      isValidate,
      handleEdit,
      handleDelete
    }
  }
}
</script>

<template>
  <div class="blogs">

    <a id="delete" @click="handleDelete" class="btn btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></a>

    <h1>Blog sur la plante : 
      <strong style="color: black;">{{ blog ? blog.plante.espece : '??' }}</strong> 
      par {{ blog ? blog.user_id.lastname + ' ' + blog.user_id.firstname : '??' }}
    </h1> 

    <div class="card">
      <div class="card-body">

        <form class="form" @submit.prevent="handleEdit">

            <div class="row" style="align-items: center;">
                <div class="col-md-10">
                    <div class="form__group">
                      <label for="title" class="form__label">Title</label>
                      <input v-model="title" type="text" id="title" class="form__input" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form__group form-switch">
                      <label class="form__label" for="isValidate">Publié</label>
                      <input v-model="isValidate" class="form-check-input" type="checkbox" role="switch" id="isValidate">                 
                    </div>
                </div>
            </div>
 
            <div class="form__group">
                <label for="description" class="form__label">Description</label>
                <input v-model="description" type="text" id="description" class="form__input" />
            </div>
            <div class="form__group">
                <label for="area" class="form__label">Area</label>
                <textarea v-model="area" type="text" id="area" class="form__input" rows="10"></textarea>
            </div>

            <div class="buttons">
                <RouterLink to="/admin/blog" class="btn btn-primary">Retour</RouterLink>
                <button class="btn btn-warning"><i class="fas fa-edit"></i> Editer</button>
            </div>

        </form>
        
      </div>
    </div>

  </div>
</template>

<style scoped>
.blogs {
  margin-top: 50px;
  background-color: rgb(86, 145, 81);
  padding: 20px;
  border-radius: 10px;
}

#delete{
  float: right;
  color: white;
  font-size: 20px;
  margin-top: 0;
  margin-right: 0;
  width: auto;
}

h1 {
  font-size: 38px;
  text-align: center;
  color: white;
}

.card {
  margin-top: 50px;
}

.form__group {
  margin-bottom: 20px;
} 

.form__label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form__input {
  display: block;
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid rgb(86, 145, 81);
}

.form-switch .form-check-input{
  width: 100px;
  height: 46px;
  margin-left: 0;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
  background-position: left center;
  border-radius: 2em;
}

.buttons{
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}
</style>