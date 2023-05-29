import axios from 'axios'

const URL_DEV = "https://localhost";
const URL_PROD = "https://challenge-jardinerie.site";

const createRequest = () => {
    return axios.create({
        baseURL: URL_DEV
    });
}

export {createRequest};
