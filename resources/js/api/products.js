import api from '@/lib/api'

export const ProductApi = {
    getAll(page = 1, categoryId = null) {
        return api.get('/api/products', {
            params: {
                page,
                category_id: categoryId,
            },
        })
    },

    create(data) {
        return api.post('/api/products', data)
    },

    update(id, data) {
        return api.put(`/api/products/${id}`, data)
    },

    delete(id) {
        return api.delete(`/api/products/${id}`)
    },

    getOne(id) {
        return api.get(`/api/products/${id}`)
    },
}
