import { useContext } from 'react'
import { Button, FlatList, StatusBar, StyleSheet, Text, View } from 'react-native'
import AuthContext from '../contexts/AuthContext'
import { logoutService } from '../services/AuthService'
import MasterLayout from '../components/layouts/MasterLayout'
import { MOCK_PRODUCTS } from '../mocks/products'

export default function ProductsScreen () {
  const { profile, setProfile } = useContext(AuthContext)

  const handleLogout = async () => {
    await logoutService()
    setProfile(null)
  }

  return (
    <MasterLayout withoutScroll>
      <Text>Bienvenido a Productos, {profile.name}</Text>
      <FlatList
        data={MOCK_PRODUCTS}
        keyExtractor={item => item.id}
        renderItem={({ item: product }) => (
          <View style={styles.item}>
            <Text style={styles.nombre}>{product.nombre}</Text>
          </View>
        )}
      />
      <Button title='Cerrar sesión' onPress={handleLogout} />
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    marginTop: StatusBar.currentHeight || 0
  },
  item: {
    backgroundColor: '#f9c2ff',
    padding: 20,
    marginVertical: 8,
    marginHorizontal: 16
  },
  title: {
    fontSize: 32
  }
})
