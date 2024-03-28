import { useContext } from 'react'
import { Button, SafeAreaView, Text } from 'react-native'
import AuthContext from '../contexts/AuthContext'
import { logoutService } from '../services/AuthService'

export default function ProductsScreen () {
  const { profile, setProfile } = useContext(AuthContext)

  const handleLogout = async () => {
    await logoutService()
    setProfile(null)
  }

  return (
    <SafeAreaView>
      <Text>Bienvenido a Productos, {profile.name}</Text>
      <Button title='Cerrar sesión' onPress={handleLogout} />
    </SafeAreaView>
  )
}
