import axios from "axios";

const getBlogsValidate = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await axios.get('https://localhost/blogs-validate', {
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

const getBlogs = async () => {

    const token = localStorage.getItem('token_jwt')
    
    try {
        const response = await axios.get('https://localhost/blogs', {
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

const getBlog = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.get('https://localhost/blogs/'+id, {
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

const createBlog = async (data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.post('https://localhost/blogs', 
        data, 
        {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'application/json',
                'accept': 'application/json'
            }
        })

        console.log(response)

        if(response.status === 201) {
            return response.data
        }else{
            return null
        }
    } catch (error) {
        return null
    }
    
}

const editBlog = async (id, data) => {
    
    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.put('https://localhost/blogs/'+id, 
        data, 
        {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        console.log(response.data)

        if(response.status === 200) {
            return response.data
        }else{
            return null
        }
    } catch (error) {
        return null
    }
    
}

const deleteBlog = async (id) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.delete('https://localhost/blogs/'+id, {
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

export { getBlogs, getBlogsValidate, getBlog, createBlog, editBlog, deleteBlog }