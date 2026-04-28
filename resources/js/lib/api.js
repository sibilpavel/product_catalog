import axios from 'axios'

const api = axios.create({
    baseURL: '/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
    },
})

const token = localStorage.getItem('token')

if (token) {
    api.defaults.headers.common[
        'Authorization'
        ] = `Bearer ${token}`
}

export default api
