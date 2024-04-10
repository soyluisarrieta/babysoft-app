import axiosLib from 'axios'
import { getToken } from '../services/TokenService'

export const API_URL = 'https://soyluisarrieta.com/api'

const axios = axiosLib.create({
  baseURL: API_URL,
  headers: {
    Accept: 'application/json'
  }
})

axios.interceptors.request.use(async (request) => {
  const token = await getToken()

  if (token !== null) {
    request.headers.Authorization = `Bearer ${token}`
  }

  return request
})

export default axios
