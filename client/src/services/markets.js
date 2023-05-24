import axios from "axios";
import {createRequest} from '../middleware/api'

const request = createRequest();

const getMarkets = async () => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.get('/markets', {
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

const getMarket = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.get('/markets/'+id, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        if(response.status === 200) {
            return response
        }else{
            return response
        }
    } catch (error) {
        return error.response
    }

}

const createMarket = async (data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.post('/markets', 
        data, 
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/json',
                'accept': 'application/json'
            }
        })

        if(response.status === 201) {
            return response
        }else{
            return response
        }
    } catch (error) {
        return error.response
    }
    
}

const editMarket = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.patch('/markets/'+id, 
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

const deleteMarket = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.delete('/markets/'+id, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        return response
        
    } catch (error) {
        return error.response
    }

}

export { getMarkets, getMarket, createMarket, editMarket, deleteMarket }