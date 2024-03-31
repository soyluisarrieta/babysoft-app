import axios from '../utils/axios'

export async function productsService () {
  const { data } = await axios('/productos')
  return data.productos
}

export async function createProductService (product) {
  return await axios.post('/productos', product)
}

export async function updateProductService (product) {
  return await axios.put(`/productos/${product.id}`, product)
}
