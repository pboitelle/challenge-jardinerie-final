import axios from "axios";

const getUsers = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await axios.get('https://localhost/users', {
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
        const response = await axios.get('https://localhost/users/'+id, {
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
        const response = await axios.get('https://localhost/users/'+id+'/blogs', {
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
        const response = await axios.get('https://localhost/users/'+id+'/items', {
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
        const response = await axios.get('https://localhost/users/'+id+'/markets', {
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

const editUser = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    console.log(data)

    try {
        const response = await axios.put('https://localhost/users/'+id, 
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
        const response = await axios.delete('https://localhost/users/'+id, {
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
        const response = await axios.patch('https://localhost/users/'+id+'/role',
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

export { getUsers, getUser, getBlogsUser, getItemsUser, getItemsMarketUser, editUser, deleteUser, updateRole }