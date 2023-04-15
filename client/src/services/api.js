import axios from "axios";

function createRequest() {
    return axios.create({
        baseURL: "http://localhost:80"
    });
}

export async function getPlantes() {
    const request = createRequest();

    const response = await request.get("/api/plantes");

    return response.data;
}