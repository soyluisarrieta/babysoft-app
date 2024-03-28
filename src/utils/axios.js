import axiosLib from 'axios'
import { getToken } from '../services/TokenService'

const axios = axiosLib.create({
  baseURL: 'http://192.168.1.105:8000/api',
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
