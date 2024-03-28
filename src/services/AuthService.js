import axios from '../utils/axios'

export async function loginService (credentials) {
  const { data } = await axios.post('/login', credentials)
  return data.token
}

export async function profileService (token) {
  const { data: profile } = await axios.get('/user', {
    headers: { Authorization: `Bearer ${token}` }
  })
  return profile
}
