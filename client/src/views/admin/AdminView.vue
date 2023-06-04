<script>
export default {
  name: 'AdminView',
  components: {
  }
}
</script>

<template>
    <h1 class="text-center">Administration</h1>

    <div class="row" style="margin-top: 50px;">

        <router-link to="/admin/users" class="card text-center text-white bg-dark">

          <i class="fa-solid fa-user logo"></i>

          <div class="card-body">
            <h5 class="card-title"><router-link to="/admin/users">Users</router-link></h5>
            <p class="card-text">(Création, Edition, Suppression)</p>
            <router-link to="/admin/users" class="btn btn-primary"><i class="fa-regular fa-share-from-square"></i></router-link>
          </div>
        </router-link>

        <router-link to="/admin/plantes" class="card text-center text-white bg-dark">

          <i class="fa-solid fa-plant-wilt logo"></i>
          
          <div class="card-body">
            <h5 class="card-title"><router-link to="/admin/plantes">Plantes</router-link></h5>
            <p class="card-text">(Création, Edition, Suppression)</p>
            <router-link to="/admin/plantes" class="btn btn-primary"><i class="fa-regular fa-share-from-square"></i></router-link>
          </div>
        </router-link>

        <router-link to="/admin/blog" class="card text-center text-white bg-dark">
          
          <i class="fa-regular fa-newspaper logo"></i>

          <div class="card-body">
            <h5 class="card-title"><router-link to="/admin/blog">Blogs</router-link></h5>
            <p class="card-text">(Validation/Refus des demandes de création de blog, édition des blogs, suppression des blogs)</p>
            <router-link to="/admin/blog" class="btn btn-primary"><i class="fa-regular fa-share-from-square"></i></router-link>
          </div>
        </router-link>

        <router-link to="/admin/demande-bloggers" class="card text-center text-white bg-dark">
          
          <i class="fa-brands fa-blogger logo"></i>

          <div class="card-body">
            <h5 class="card-title"><router-link to="/admin/users">Demandes pour devenir Blogger</router-link></h5>
            <p class="card-text">(Validation/Refus des demandes pour devenir un blogger)</p>
            <router-link to="/admin/demande-bloggers" class="btn btn-primary"><i class="fa-regular fa-share-from-square"></i></router-link>
          </div>
        </router-link>

    </div>

</template>

<style scoped>
.card {
  margin: 20px;
  width: 45%;
  padding: 20px;
}
.card .logo{
  font-size: 100px;
  margin-top: 20px;
}

h1{
  margin-top: 50px;
  font-size: 50px;
}

h2{
  margin-top: 50px;
  font-size: 25px;
}

li{
  margin-top: 20px;
  font-size: 20px;
  list-style-type: none;
}

ul{
  margin-top: 20px;
  font-size: 20px;
  list-style-type: none;
}

a{
  text-decoration: none;
}

@media screen and (max-width: 768px) {
  h1{
    font-size: 35px;
  }
  .card {
    width: 90%;
  }
}
</style>