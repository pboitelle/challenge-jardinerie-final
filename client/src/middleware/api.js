import axios from 'axios'

const createRequest = () => {
    return axios.create({
        baseURL: "https://challenge-jardinerie.site"
    });
}

export {createRequest};