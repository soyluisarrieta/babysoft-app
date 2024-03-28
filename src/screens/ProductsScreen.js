import { useContext } from 'react'
import { SafeAreaView, Text } from 'react-native'
import AuthContext from '../contexts/AuthContext'

export default function ProductsScreen () {
  const { profile } = useContext(AuthContext)

  return (
    <SafeAreaView>
      <Text>Bienvenido a Productos, {profile.name}</Text>
    </SafeAreaView>
  )
}
