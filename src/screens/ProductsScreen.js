import { useContext } from 'react'
import { Button, Text } from 'react-native'
import AuthContext from '../contexts/AuthContext'
import { logoutService } from '../services/AuthService'
import MasterLayout from '../components/layouts/MasterLayout'

export default function ProductsScreen () {
  const { profile, setProfile } = useContext(AuthContext)

  const handleLogout = async () => {
    await logoutService()
    setProfile(null)
  }

  return (
    <MasterLayout>
      <Text>Bienvenido a Productos, {profile.name}</Text>
      <Button title='Cerrar sesión' onPress={handleLogout} />
    </MasterLayout>
  )
}
