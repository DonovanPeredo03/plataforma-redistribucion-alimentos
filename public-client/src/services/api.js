import axios from 'axios';

export const BASE_URL = 'http://127.0.0.1:8000';

const api = axios.create({
    baseURL: `${BASE_URL}/api/v1/client/`,
    timeout: 10000,
    headers: {
        Accept: 'application/json',
    },
    withCredentials: false,
});

export default api;
