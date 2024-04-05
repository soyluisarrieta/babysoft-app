import AsyncStorage from '@react-native-async-storage/async-storage'

let token = null

export async function setToken (newToken) {
  token = newToken

  if (token !== null) {
    await AsyncStorage.setItem('token', token)
  } else {
    await AsyncStorage.removeItem('token')
  }
}

export async function getToken () {
  if (token !== null) {
    return token
  }

  token = await AsyncStorage.getItem('token')
  return token
}
