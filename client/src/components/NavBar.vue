<script>
import { RouterLink } from 'vue-router'
import { userConnected } from '@/middleware/userAuth.js'
import { watchEffect, ref } from 'vue'

export default {
  setup() {

    const user = ref(null)

    watchEffect(async () => {
      user.value = await userConnected()
    })

    const user_email = localStorage.getItem('email')
    const user_coins = localStorage.getItem('nb_coins')
    const user_roles = localStorage.getItem('roles')

    let user_role = user_roles.split(',')[0]

    if (user_role == 'ROLE_ADMIN') {
      user_role = 'Noble'
    } else if (user_role == 'ROLE_USER') {
      user_role = 'Gueux'
    } else if (user_role == 'ROLE_BLOGER') {
      user_role = 'Paysan'
    } else {
      user_role = 'Gueux'
    }

    const formatNumber = (number) => {
      if (number >= 1000000) {
        return (number/1000000).toFixed(Number.isInteger(number/1000000) ? 0 : 1) + 'M';
      } else if (number >= 1000) {
        return (number/1000).toFixed(Number.isInteger(number/1000) ? 0 : 1) + 'K';
      } else {
        return number.toString();
      }
    }

    const logout = () => {
      localStorage.removeItem('token_jwt')
      localStorage.removeItem('email')
      localStorage.removeItem('firstname')
      localStorage.removeItem('lastname')
      localStorage.removeItem('nb_coins')
      localStorage.removeItem('roles')

      window.location.href = '/'
    }

    return {
      user_email,
      user_coins,
      user_role,
      logout,
      user,
      formatNumber
    }
  }
}

</script>

<template>
    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">
            <div><RouterLink to="/garden" class="navbar-brand"><img src="@/assets/img/logo.png" ></RouterLink></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink to="/market" class="nav-link">Marché des plantes</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/blogs" class="nav-link">Blog</RouterLink>
                    </li>
                    <li v-if="user && (user.roles.includes('ROLE_BLOGER') || user.roles.includes('ROLE_ADMIN'))" class="nav-item">
                        <RouterLink to="/plantes" class="nav-link">Plantes</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/coins" class="nav-link" style="color: yellow;">Acheter des coins</RouterLink>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ user_email }} ({{ user_role }})
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <RouterLink v-if="user && user.roles.includes('ROLE_ADMIN')" to="/admin" class="dropdown-item">Administration<li><hr class="dropdown-divider"></li></RouterLink>
                            <RouterLink v-if="user && !user.roles.includes('ROLE_ADMIN')" to="/garden" class="dropdown-item">Mon jardin<li><hr class="dropdown-divider"></li></RouterLink>
                            
                            <RouterLink v-if="user && user.roles.includes('ROLE_BLOGER')" to="/mes-blogs" class="dropdown-item">Mes blogs<li><hr class="dropdown-divider"></li></RouterLink>
                            
                            <li><a class="dropdown-item" @click="logout">Me déconnecter</a></li>
                        </ul>
                    </li>

                    <li id="nb_coins" class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="@/assets/img/coin.png">
                            <span id="number_coins">
                                {{ formatNumber(user_coins) }}
                            </span>
                        </a>
                    </li>
                </ul>

                <!-- afficher le bouton se connecter ou le bouton deconnexion -->
                

            </div>
        </div>
    </nav>
</template>

<style scoped>
  /* Add styles here for large screens */
  .navbar {
    height: 10vh;
  }

  #navbarDropdown {
    color: black;
    font-weight: bold;
  }
  #navbarDropdown:hover {
    color: rgba(0, 0, 0, 0.61);
  }

  .navbar-brand img {
    width: 40px;
  }

  .navbar {
    padding: 0 10%;
    background-color: #4caf50;
  }

  .navbar-nav {
    margin-left: auto;
  }

  .nav-link {
    color: white;
  }

  .nav-link:hover {
    color: rgba(255, 255, 255, 0.61);
  }

  .dropdown-menu {
    background-color: #4caf50;
  }

  .dropdown-item {
    color: white;
    cursor: pointer;
  }

  .dropdown-item:hover {
    color: rgba(255, 255, 255, 0.61);
    background-color: #4caf50;
  }

  .btn {
    margin-left: 10px;
  }

  .btn-outline-light {
    color: white;
    border-color: white;
  }

  .btn-outline-light:hover {
    color: black;
    background-color: white;
    border-color: white;
  }

  .btn-light {
    color: #4caf50;
    background-color: white;
  }

  .btn-light:hover {
    color: white;
    background-color: #4caf50;
  }

  #nb_coins {
    margin-left: 10px;
    display: flex;
    align-items: center;
  }

  #nb_coins img {
    width: 30px;
  }

  #number_coins {
    font-weight: bold;
    color: white;
    text-decoration: none;
  }

/* Add styles here for small screens */
@media screen and (max-width: 768px)
{
  .navbar {
    padding: 0 5%;
  }

  .navbar-brand img {
    width: 40px;
  }
  .show {
    background-color: #4caf50;
    width: 100%;
    z-index: 100000;
    top: 7vh;
    left: 0;
  }

  .dropdown-menu {
    background-color: #4caf50;
    width: 100%;
    position: absolute;
    z-index: 1000000;
    top: 15vh;
    left: 0;

  }  

}
</style>