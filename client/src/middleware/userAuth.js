import axios from 'axios'

const isAuthenticated = async (to, from, next) => {
  const token = localStorage.getItem('token_jwt')
  if (!token) {
    // if token is not present, redirect to login page
    next({ name: 'login' })
  } else {
    try {
        // send a request to /users/me to check if token is valid
        const response = await axios.get('https://localhost/users/me', {
            headers: {
            Authorization: `Bearer ${token}`
            }
        })
        localStorage.setItem('email', response.data.email)
        localStorage.setItem('roles', response.data.roles)

        // if response is successful, user is authenticated
        next()
    } catch (error) {
        // if there's an error, redirect to login page
        next({ name: 'login' })
    }
  }
}

const user = () => {
    if(isAuthenticated) {
        return {
            email: localStorage.getItem('email'),
        }
    }
}


export { isAuthenticated, user }