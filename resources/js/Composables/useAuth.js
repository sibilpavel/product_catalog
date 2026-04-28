import { ref } from 'vue'
import api from '@/lib/api'

const token = ref(localStorage.getItem('token') || null)

export function useAuth() {
    const login = async (email, password) => {
        const response = await api.post('/api/login', {
            email,
            password,
        })

        token.value = response.data.token

        localStorage.setItem('token', token.value)

        api.defaults.headers.common[
            'Authorization'
            ] = `Bearer ${token.value}`
    }

    const logout = async () => {
        await api.post('/api/logout')

        token.value = null

        localStorage.removeItem('token')

        delete api.defaults.headers.common[
            'Authorization'
            ]
    }

    const isAuthenticated = () => !!token.value

    return {
        token,
        login,
        logout,
        isAuthenticated,
    }
}
