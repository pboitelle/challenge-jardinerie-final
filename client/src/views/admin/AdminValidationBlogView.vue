<template>
  <div>
    <h1>Liste des salons</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.lastName }}</td>
          <td>{{ user.firstName }}</td>
          <td>{{ user.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Users',
  data() {
    return {
      users: [
        { id: 1, lastName: 'Doe', firstName: 'John', email: 'john.doe@example.com' },
        { id: 2, lastName: 'Smith', firstName: 'Jane', email: 'jane.smith@example.com' },
        { id: 3, lastName: 'Johnson', firstName: 'Bob', email: 'bob.johnson@example.com' }
      ]
    }
  }
}
</script>