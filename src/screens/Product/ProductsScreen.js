import { useContext, useEffect, useState } from 'react'
import { FlatList, Image, ImageBackground, Modal, RefreshControl, ScrollView, StyleSheet, Text, TouchableOpacity, View } from 'react-native'
import { productsService } from '../../services/ProductService'
import Button from '../../components/ui/Button'
import AuthContext from '../../contexts/AuthContext'
import { logoutService } from '../../services/AuthService'
import MasterLayout from '../../components/layouts/MasterLayout'
import { API_URL } from '../../utils/axios'
import { COLORS, FONTS } from '../../theme'

export default function ProductsScreen ({ navigation }) {
  const [modalVisible, setModalVisible] = useState(false)
  const [productSelected, setProductSelected] = useState({})
  const [productsList, setProductsList] = useState([])
  const [refreshing, setRefreshing] = useState(false)
  const { profile, setProfile } = useContext(AuthContext)

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const products = await productsService()
        setProductsList(products)
      } catch (error) {
        console.error('Error fetching products:', error)
      }
    }

    fetchProducts()
  }, [])

  const handleLogout = async () => {
    await logoutService()
    setProfile(null)
  }

  const clickEventListener = (item) => {
    setProductSelected(item)
    setModalVisible(true)
  }

  const onRefresh = async () => {
    setRefreshing(true)
    try {
      const products = await productsService()
      setProductsList(products)
    } catch (error) {
      console.error('Error fetching products:', error)
    } finally {
      setRefreshing(false)
    }
  }

  return (
    <MasterLayout withoutScroll>
      <View style={styles.container}>
        <Text style={styles.paragraph}>Bienvenido, <Text style={{ fontFamily: FONTS.primary.bold }}>{profile.name}</Text></Text>
        <View style={{ width: '100%', flexDirection: 'row', justifyContent: 'space-between', marginVertical: 10 }}>
          <Button variants='secundary' onPress={handleLogout} style={{ width: 'auto' }}>Cerrar sesión</Button>
          <Button
            variants='primary'
            style={{ width: 'auto' }}
            onPress={() => navigation.navigate('product-create')}
          >
            <Text style={{ fontFamily: FONTS.primary.bold }}>Agregar producto</Text>
          </Button>
        </View>
        <FlatList
          data={productsList}
          keyExtractor={item => item.id}
          refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />}
          renderItem={({ item: producto }) => {
            return (
              <>
                <TouchableOpacity style={styles.card} onPress={() => clickEventListener(producto)}>
                  <ImageBackground
                    style={[styles.image, { overflow: 'hidden', justifyContent: 'center', alignItems: 'center' }]}
                    source={require('../../../assets/product-placeholder.png')}
                    imageStyle={{ opacity: 0.5 }}
                  >
                    <Image
                      style={styles.image}
                      source={{ uri: `${API_URL}/../images/products/${producto.Foto}` }}
                    />
                  </ImageBackground>

                  <View style={styles.cardContent}>
                    <Text style={styles.name}>{producto.nombreProducto}</Text>
                    <Text style={styles.pricing}>{producto.Talla}  |  ${producto.Precio}</Text>
                  </View>
                </TouchableOpacity>
              </>
            )
          }}
        />
      </View>

      <Modal
        animationType='fade'
        transparent
        onRequestClose={() => setModalVisible(false)}
        visible={modalVisible}
      >
        <View style={styles.popupOverlay}>
          <View style={styles.popup}>
            <View style={styles.popupContent}>
              <ScrollView contentContainerStyle={styles.modalInfo} persistentScrollbar>
                <ImageBackground
                  style={[{ overflow: 'hidden', marginTop: 20 }, styles.image]}
                  source={require('../../../assets/product-placeholder.png')}
                  imageStyle={{ opacity: 0.5 }}
                >
                  <Image
                    style={styles.image}
                    source={{ uri: `${API_URL}/../images/products/${productSelected.Foto}` }}
                  />
                </ImageBackground>
                <Text style={[styles.name, { fontSize: 40 }]}>{productSelected.nombreProducto}</Text>
                <Text style={[styles.paragraph, { fontFamily: FONTS.primary.semibold, fontSize: 26, marginBottom: 20 }]}>
                  $ {productSelected.Precio}
                </Text>
                <Text style={styles.paragraph}>{productSelected.Cantidad} disponibles</Text>
                <Text style={styles.paragraph}>Talla: {productSelected.Talla}</Text>
                <View style={{ flexDirection: 'row' }}>
                  <Text style={styles.paragraph}>Categoría:</Text>
                  <Text
                    onPress={() => { setModalVisible(false) }}
                    style={[styles.paragraph, { color: COLORS.secundary.hex, fontFamily: FONTS.primary.semibold, textDecorationLine: 'underline', marginLeft: 7 }]}
                  >
                    {productSelected.Categoria}
                  </Text>
                </View>
                <Text style={styles.paragraph}>Id Referencia: {productSelected.idReferencia}</Text>
              </ScrollView>
            </View>
            <View style={styles.popupButtons}>
              <TouchableOpacity
                onPress={() => {
                  setModalVisible(false)
                  navigation.navigate('product-edit', { producto: productSelected })
                }}
                style={[styles.btnClose, { backgroundColor: COLORS.primary.hex }]}
              >
                <Text style={styles.txtClose}>Editar producto</Text>
              </TouchableOpacity>
              <TouchableOpacity
                onPress={() => { setModalVisible(false) }}
                style={styles.btnClose}
              >
                <Text style={styles.txtClose}>Cerrar</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </Modal>
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
    marginVertical: 10
  },
  image: {
    width: 80,
    height: 80,
    borderRadius: 50,
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
  },

  /** ********** modals ************/
  popup: {
    backgroundColor: 'white',
    marginHorizontal: 20,
    borderRadius: 7
  },
  popupOverlay: {
    backgroundColor: '#00000057',
    flex: 1,
    justifyContent: 'center',
    paddingBottom: 30
  },
  popupContent: {
    margin: 5,
    maxHeight: 450
  },
  popupHeader: {
    marginBottom: 45
  },
  popupButtons: {
    marginTop: 15,
    flexDirection: 'row',
    justifyContent: 'space-evenly'
  },
  popupButton: {
    flex: 1,
    marginVertical: 16
  },
  btnClose: {
    backgroundColor: COLORS.black.hex,
    paddingVertical: 15,
    paddingHorizontal: 30,
    margin: 10,
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: 7
  },
  modalInfo: {
    alignItems: 'center',
    justifyContent: 'center'
  },
  txtClose: {
    color: 'white',
    fontFamily: FONTS.primary.semibold,
    fontSize: 16
  }
})
