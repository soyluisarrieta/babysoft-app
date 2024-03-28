import axios from '../utils/axios'
import { setToken } from './TokenService'

export async function loginService (credentials) {
  const { data } = await axios.post('/login', credentials)
  await setToken(data.token)
}

export async function registerService (registerInfo) {
  const { data } = await axios.post('/register', registerInfo)
  await setToken(data.token)
}

export async function profileService () {
  const { data: profile } = await axios.get('/user')
  return profile
}

export async function logoutService () {
  await axios.post('/logout', {})
  await setToken(null)
}
