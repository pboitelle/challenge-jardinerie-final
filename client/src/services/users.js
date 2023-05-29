import axios from "axios";
import {createRequest} from '../middleware/api'

const request = createRequest();

const getUsers = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const getUser = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.get('/users/'+id, {
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

const getBlogsUser = async (id) => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users/'+id+'/blogs', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        console.log(response.data['hydra:member'])

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const getItemsUser = async (id) => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users/'+id+'/items', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const getVentesUser = async (id) => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users/'+id+'/ventes', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const getAchatsUser = async (id) => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users/'+id+'/achats', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const getItemsMarketUser = async (id) => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/users/'+id+'/markets', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response.data['hydra:member']
        }else{
            return null
        }
    } catch (error) {
        return null
    }
}

const createUser = async (data) => {

    try {
        const response = await request.post('/users', 
        data, 
        {
            headers: {
                'Content-Type': 'application/json',
                'accept': 'application/json'
            }
        })

        if(response.status === 200) {
            return response.data
        }else{
            return null
        }
    } catch (error) {
        return error.response
    }
    
}

const editUser = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    console.log(data)

    try {
        const response = await request.put('/users/'+id, 
        data, 
        {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        console.log(response)

        if(response.status === 200) {
            return response.data
        }else{
            return null
        }
    } catch (error) {
        return null
    }
    
}

const deleteUser = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.delete('/users/'+id, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        console.log(response)

        if(response.status === 204) {
            return response
        }else{
            return null
        }
    } catch (error) {
        return null
    }

}

const updateRole = async (id, data) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.patch('/users/'+id+'/role',
        data,
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/merge-patch+json'
            }
        })

        if(response.status === 200) {
            return response
        }else{
            return null
        }
    } catch (error) {
        return null
    }

}

const updateCoins = async (id, data, type) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.patch('/users/'+id+'/'+type+'-coins',
        data,
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/merge-patch+json'
            }
        })

        return response
        
    } catch (error) {
        return error.response
    }

}

const confirmUser = async (data) => {

    try {
        const response = await request.post(`/users/confirm-account`, 
        data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        })

        return response

    } catch (error) {
        return error.response
    }
}

export { getUsers, getUser, getBlogsUser, getItemsUser, getVentesUser, getAchatsUser, getItemsMarketUser, editUser, createUser, deleteUser, updateRole, updateCoins, confirmUser }