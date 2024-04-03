import axios from '../utils/axios'

export async function productsService () {
  const { data } = await axios('/productos')
  return data.productos
}

export async function createProductService (product) {
  return await axios.post('/productos', product, {
    headers: { 'Content-Type': 'multipart/form-data' }
  })
}

export async function updateProductService (product) {
  const id = product.getParts().find(item => item.fieldName === 'id').string
  return await axios.post(`/productos/${id}?_method=PUT`, product, {
    headers: { 'Content-Type': 'multipart/form-data' }
  })
}

export async function deleteProductService (id) {
  return await axios.delete(`/productos/${id}`)
}
