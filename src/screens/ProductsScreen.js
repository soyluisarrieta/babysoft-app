import { useContext } from 'react'
import { Alert, FlatList, Image, ImageBackground, StyleSheet, Text, TouchableOpacity, View } from 'react-native'
import Button from '../components/ui/Button'
import AuthContext from '../contexts/AuthContext'
import { logoutService } from '../services/AuthService'
import MasterLayout from '../components/layouts/MasterLayout'
import { MOCK_PRODUCTS } from '../mocks/products'
import { API_URL } from '../utils/axios'
import { COLORS, FONTS } from '../theme'

export default function ProductsScreen () {
  const { profile, setProfile } = useContext(AuthContext)

  const handleLogout = async () => {
    await logoutService()
    setProfile(null)
  }

  const clickEventListener = (item) => {
    Alert.alert('Message', 'Item clicked. ' + item.nombre)
  }

  return (
    <MasterLayout withoutScroll>
      <View style={styles.container}>
        <Text style={styles.paragraph}>Bienvenido, <Text style={{ fontFamily: FONTS.primary.bold }}>{profile.name}</Text></Text>
        <FlatList
          data={MOCK_PRODUCTS}
          keyExtractor={item => item.id}
          renderItem={({ item: producto }) => {
            return (
              <TouchableOpacity style={styles.card} onPress={() => clickEventListener(producto)}>
                <ImageBackground
                  style={[{ overflow: 'hidden' }, styles.image]}
                  source={require('../../assets/product-placeholder.png')}
                  imageStyle={{ opacity: 0.5 }}
                >
                  <Image
                    style={styles.image}
                    source={{ uri: `${API_URL}/producto/foto/${producto.foto}` }}
                  />
                </ImageBackground>

                <View style={styles.cardContent}>
                  <Text style={styles.name}>{producto.nombre}</Text>
                  <Text style={styles.pricing}>${producto.precio} / {producto.cantidad} disponibles.</Text>
                </View>
              </TouchableOpacity>
            )
          }}
        />
      </View>
      <View style={{ width: '100%', flexDirection: 'row', justifyContent: 'space-between', paddingHorizontal: 20, position: 'absolute', bottom: 20 }}>
        <Button variants='secundary' onPress={handleLogout} style={{ width: 'auto' }}>Cerrar sesión</Button>
        <Button variants='primary' style={{ width: 'auto' }}>
          <Text style={{ fontFamily: FONTS.primary.bold }}>Agregar producto</Text>
        </Button>
      </View>
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: 20,
    backgroundColor: '#ebf0f7'
  },
  paragraph: {
    fontFamily: FONTS.primary.regular,
    fontSize: 20
  },
  contentList: {
    flex: 1
  },
  cardContent: {
    marginLeft: 20,
    marginTop: 10
  },
  image: {
    width: 90,
    height: 90,
    borderRadius: 45,
    borderWidth: 2,
    borderColor: '#ebf0f7'
  },

  card: {
    shadowColor: '#00000021',
    shadowOffset: {
      width: 0,
      height: 6
    },
    shadowOpacity: 0.37,
    shadowRadius: 7.49,
    elevation: 12,

    marginTop: 15,
    backgroundColor: 'white',
    padding: 10,
    flexDirection: 'row',
    borderRadius: 10
  },

  name: {
    fontSize: 20,
    color: COLORS.primary.hex,
    fontFamily: FONTS.primary.bold
  },
  pricing: {
    fontSize: 16,
    flex: 1,
    color: COLORS.black.hex,
    opacity: 0.8,
    fontFamily: FONTS.primary.medium
  },
  followButton: {
    marginTop: 10,
    height: 35,
    width: 100,
    padding: 10,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    borderRadius: 30,
    backgroundColor: 'white',
    borderWidth: 1,
    borderColor: '#dcdcdc'
  },
  followButtonText: {
    color: '#dcdcdc',
    fontSize: 12
  }
})
