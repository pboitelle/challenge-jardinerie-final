import axios from "axios";
import {createRequest} from '../middleware/api'

const request = createRequest();

const getDemandeBloggers = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await request.get('/demande-bloggers', {
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

const deleteDemandeBloggers = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await request.delete('/demande-bloggers/'+id, {
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

export { getDemandeBloggers, deleteDemandeBloggers }