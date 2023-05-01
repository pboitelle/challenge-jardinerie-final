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
        localStorage.setItem('firstname', response.data.firstname)
        localStorage.setItem('lastname', response.data.lastname)
        localStorage.setItem('nb_coins', response.data.nb_coins ? response.data.nb_coins : 0)
        localStorage.setItem('roles', response.data.roles)

        // if response is successful, user is authenticated
        next()
    } catch (error) {
        // if there's an error, redirect to login page
        next({ name: 'login' })
    }
  }
}

const isAuthenticatedAdmin = async (to, from, next) => {
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
        localStorage.setItem('firstname', response.data.firstname)
        localStorage.setItem('lastname', response.data.lastname)
        localStorage.setItem('nb_coins', response.data.nb_coins ? response.data.nb_coins : 0)
        localStorage.setItem('roles', response.data.roles)

        // if response is successful, user is authenticated
        if (response.data.roles.includes('ROLE_ADMIN')) {
          next()
        } else {
            next({ name: 'login' })
        }   
    } catch (error) {
        // if there's an error, redirect to login page
        next({ name: 'login' })
    }
  }
}

const userConnected = async () => {
    const token = localStorage.getItem('token_jwt')
    try {
        const response = await axios.get('https://localhost/users/me', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
        if(response.status === 200) {
            return response.data
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

export { isAuthenticated, isAuthenticatedAdmin, userConnected }