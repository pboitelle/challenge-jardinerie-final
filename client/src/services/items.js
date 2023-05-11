import axios from "axios";

const updateIsPlantedItem = async (id, data) => {

    const token = localStorage.getItem('token_jwt')

    try {
        const response = await axios.patch('https://localhost/items/'+id,
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



export { updateIsPlantedItem }