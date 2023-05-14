<script>
import NavBar from '@/components/NavBar.vue'

export default {
  name: 'AdminView',
  components: {
    NavBar
  },
  setup () {
    return {
    }
  },
  data () {
    return {
      title: 'Admin',
    }
  }
}
</script>

<template>
    <NavBar />

    <main class="main">

        <div class="admin">
          <div class="border-right" id="sidebar-wrapper">
              <div class="sidebar-heading">
                <router-link class="dashboard" to="/admin">Dashboard</router-link>
              </div>
              <div class="list-group list-group-flush">
                  <router-link class="list-group-item list-group-item-action" to="/admin/users">Users</router-link>
                  <router-link class="list-group-item list-group-item-action" to="/admin/plantes">Plantes</router-link>
                  <router-link class="list-group-item list-group-item-action" to="/admin/blog">Blogs</router-link>
                  <router-link class="list-group-item list-group-item-action" to="/admin/demande-bloggers">Demandes pour devenir Blogger</router-link>
                  
              </div>
          </div>

          <!-- Page content -->
            <div id="page-content-wrapper">

                <div class="container mt-5">
                    <router-view />
                </div>
            </div>
        </div>

    </main>
</template>

<style scoped>
.admin {
  display: flex;
  width: 100%;
}

.sidebar-heading{
  border-bottom: 2px solid aliceblue;
}
.sidebar-heading a{
  color: white;
  text-decoration: none;
}

.list-group-item{
  padding-bottom: 20px;
  padding-top: 20px;
  color: white;
  background-color: rgb(60, 63, 60);
  border-color: aliceblue;
}
.list-group-item:hover{
  color: black;
  background-color: rgb(60, 63, 60);
}

#sidebar-wrapper {
  color: white;
  background-color: rgb(60, 63, 60);
  min-height: 100vh;
  margin-left: -15rem;
  -webkit-transition: margin .25s ease-out;
  -moz-transition: margin .25s ease-out;
  -o-transition: margin .25s ease-out;
  transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {
  padding: 0.875rem 1.25rem;
  font-size: 1.2rem;
}

#sidebar-wrapper .list-group {
  width: 15rem;
}

#page-content-wrapper {
  min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
  margin-left: 0;
}

@media (min-width: 768px) {
  #sidebar-wrapper {
      margin-left: 0;
  }

  #page-content-wrapper {
      min-width: 0;
      width: 100%;
  }

  #wrapper.toggled #sidebar-wrapper {
      margin-left: -15rem;
  }
}
</style>