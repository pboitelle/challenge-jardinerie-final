import axios from "axios";

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

const getPlante = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.get('https://localhost/plantes/'+id, {
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

const editPlante = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.put('https://localhost/plantes/'+id, 
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
        const response = await axios.delete('https://localhost/plantes/'+id, {
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

export { getMarkets }