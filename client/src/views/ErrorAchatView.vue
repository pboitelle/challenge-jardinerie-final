<script>
import NavBar from '@/components/NavBar.vue'


export default {
  name: 'ErrorAchatView',
  components: {
    NavBar
  },
  setup () {

    setTimeout(function(){ 
      window.location.href = "/garden";
    }, 5000);


    return {
      
    }
  }
}
</script>

<template>
  
  <NavBar />

  <div class="main">
 
      <div class="container">

        <div class="row">
          <div class="col-md-12">
            
            <h1 class="alert alert-danger">Votre achat n'a pas été effectué, vous allez être redirigé vers votre jardin.</h1>

          </div>
        </div>

      </div>

  </div>


</template>

<style scoped>
    h1{
        font-size: 32px;
        text-align: center;
        margin-top: 100px;
    }

</style>
