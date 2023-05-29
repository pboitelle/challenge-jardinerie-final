import axios from "axios";
import {createRequest} from '../middleware/api'

const request = createRequest();

const getPlantes = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/plantes', {
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

const getPlante = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.get('/plantes/'+id, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        return response

    } catch (error) {
        return error.response
    }

}

const editPlante = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.put('/plantes/'+id, 
        data, 
        {
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

const deletePlante = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.delete('/plantes/'+id, {
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

export { getPlantes, getPlante, editPlante, deletePlante }