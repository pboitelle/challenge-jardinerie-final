<script>
export default {
  name: 'AdminView',
  components: {
  }
}
</script>

<template>
    <h1 class="text-center">Administration</h1>
    
    <h2>Vous pouvez gérer :</h2>
    <li>
      <ul>
        <router-link to="/admin/users">Users</router-link>
        (Création, Edition, Suppression)
      </ul>
      <ul>
        <router-link to="/admin/plantes">Plantes</router-link>
        (Création, Edition, Suppression)
      </ul>
      <ul>
        <router-link to="/admin/validation-blog">Validation des Blogs</router-link>
        (Validation/Refus des demandes de création de blog)
      </ul>
      <ul>
        <router-link to="/admin/demande-bloggers">Demandes pour devenir Blogger</router-link>
        (Validation/Refus des demandes pour devenir un blogger)
      </ul>
    </li>

</template>

<style scoped>
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
</style>