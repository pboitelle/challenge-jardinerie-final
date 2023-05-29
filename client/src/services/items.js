import axios from "axios";
import { deleteVente } from '@/services/ventes.js'
import { updateCoins } from '@/services/users.js'
import { deleteMarket } from '@/services/markets.js'
import {createRequest} from '../middleware/api'

const request = createRequest();

const getItem = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.get('/items/'+id, {
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

const updateIsPlantedItem = async (id, data) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.patch('/items/'+id,
        data,
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/merge-patch+json'
            }
        })
        console.log(response)

        if(response.status === 200) {
            return response
        }else{
            return null
        }
    } catch (error) {
        return null
    }

}

const updateUserItem = async (vente, vendeur_id) => {

    const token = localStorage.getItem('token_jwt')

    const id = vente.item.id
    const acheteur = vente.acheteur.id
    const vente_id = vente.id
    const vente_prix = vente.prix
    const vente_market = vente.item.market.id

    try {
        const response = await request.patch('/items/'+id+'/user',
        {
            userId: acheteur
        },
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/merge-patch+json'
            }
        })

        if (response.status === 200) {
            //debiter le vendeur
            const responseUpdateCoins = await updateCoins(vendeur_id, {nbCoins: vente_prix}, 'debit')
            
            if (responseUpdateCoins.status === 200){
                //supprimer la vente
                const responseDeleteVente = await deleteVente(vente_id)

                if (responseDeleteVente.status === 204) {
                    
                    //supprimer le market
                    const responseDeleteMarket = await deleteMarket(vente_market)

                    if (responseDeleteMarket.status === 204) {

                        return response

                    }else{
                        return responseDeleteMarket
                    }

                }else{
                    return responseDeleteVente
                }
            } else {
                return responseUpdateCoins
            }

        }else{
            return response
        }

    } catch (error) {
        return error.response
    }

}

export { getItem, updateIsPlantedItem, updateUserItem }