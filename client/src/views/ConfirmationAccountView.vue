<script>
export default {
  name: 'ConfirmationAccountView',
  setup () {


    return {
      
    }
  }
}
</script>

<template>

    <div class="main">
        
        <h1 class="alert alert-success">
            Votre compte a bien été confirmé !
        </h1>

        <h2 class="alert alert-success">
            Vous pouvez vous connecter en cliquant sur le bouton ci-dessous : <br/>
            <RouterLink to="/login" class="btn btn-link">Se connecter</RouterLink>
        </h2>
    </div>
 
</template>

<style scoped>
    .main{
        display: flex;
        flex-direction: column;
    }
    h1{
        font-size: 32px;
        text-align: center;
        margin-top: 50px;
    }
    h2{
        font-size: 24px;
        text-align: center;
        margin-top: 50px;
    }

</style>
