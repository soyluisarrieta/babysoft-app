import axiosLib from 'axios'
import { getToken } from '../services/TokenService'

export const API_URL = 'http://192.168.1.105:8000/api'

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
