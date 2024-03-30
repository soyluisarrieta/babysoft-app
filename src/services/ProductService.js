import axios from '../utils/axios'

export async function productsService () {
  const { data } = await axios('/productos')
  return data.productos
}
