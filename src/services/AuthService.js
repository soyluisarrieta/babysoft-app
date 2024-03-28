import axios from '../utils/axios'
import { getToken, setToken } from './TokenService'

export async function loginService (credentials) {
  const { data } = await axios.post('/login', credentials)
  await setToken(data.token)
}

export async function profileService () {
  const token = await getToken()
  const { data: profile } = await axios.get('/user', {
    headers: { Authorization: `Bearer ${token}` }
  })
  return profile
}

export async function logoutService () {
  const token = await getToken()
  await axios.post('/logout', {}, {
    headers: { Authorization: `Bearer ${token}` }
  })
  await setToken(null)
}
