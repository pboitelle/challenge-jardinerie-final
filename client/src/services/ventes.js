import axios from "axios";
import { updateCoins } from "./users";

const getMarkets = async () => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.get('https://localhost/markets', {
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

const getMarket = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.get('https://localhost/markets/'+id, {
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

const createVente = async (user_id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.post('https://localhost/ventes', 
        data, 
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/json',
                'accept': 'application/json'
            }
        })

        if (response.status === 200){
            //crediter l'acheteur
            const response2 = await updateCoins(user_id, {
                nbCoins: data.prix
            }, 'credit')
            
            if (response2.status === 200){
                return response
            } else {
                return response2
            }
        }

    } catch (error) {
        return error.response
    }
    
}

const deleteVente = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.delete('https://localhost/ventes/'+id, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        return response
        
    } catch (error) {
        return error.response
    }

}

export { getMarkets, getMarket, createVente, deleteVente }