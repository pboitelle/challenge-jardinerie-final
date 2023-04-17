<script>
import { RouterLink } from 'vue-router'
import { ref, computed  } from 'vue'

import { user } from '../middleware/userAuth'

export default {
    setup() {
        
        const currentUser = computed(() => user())

        const logout = () => {
            localStorage.removeItem('token_jwt')
            localStorage.removeItem('email')
            localStorage.removeItem('roles')
            localStorage.removeItem('firstname')
            localStorage.removeItem('lastname')

            window.location.href = '/'
        }

        return {
            currentUser,
            logout
        }
    }
}

</script>

<template>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <div><RouterLink to="/" class="navbar-brand"><img src="../assets/img/logo.png" ></RouterLink></div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink to="/market" class="nav-link">Marché des plantes</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/blog" class="nav-link">Blog</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/coins" class="nav-link" style="color: yellow;">Acheter des coins</RouterLink>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ currentUser.email }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <RouterLink to="/garden" class="dropdown-item">Mon Jardin</RouterLink>
                            <li><hr class="dropdown-divider"></li>
                            <RouterLink to="/reset-password" class="dropdown-item">Modifier mon mot de passe</RouterLink>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" @click="logout">Me déconnecter</a></li>
                        </ul>
                    </li>
                 
                </ul>

                <!-- afficher le bouton se connecter ou le bouton deconnexion -->
                

            </div>
        </div>
    </nav>
</template>

<style scoped>
    .navbar{
        height: 8vh;
    }
    .navbar-brand img{
        width: 50px;
    }

    .navbar{
        padding: 0 10%;
        background-color: #28a745;  
    }

    .navbar-nav{
        margin-left: auto;
    }

    .nav-link{
        color: white;
    }

    .nav-link:hover{
        color: rgba(255, 255, 255, 0.61);
    }

    .dropdown-menu{
        background-color: #28a745;
    }

    .dropdown-item{
        color: white;
        cursor: pointer;
    }

    .dropdown-item:hover{
        color: rgba(255, 255, 255, 0.61);
        background-color: #28a745;
    }

    .btn{
        margin-left: 10px;
    }

    .btn-outline-light{
        color: white;
        border-color: white;    
    }

    .btn-outline-light:hover{
        color: black;
        background-color: white;
        border-color: white;
    }

    .btn-light{
        color: #28a745;
        background-color: white;
    }

    .btn-light:hover{
        color: white;
        background-color: #28a745;
    }




</style>