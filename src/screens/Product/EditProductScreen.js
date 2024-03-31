import { StyleSheet, Text, View } from 'react-native'
import MasterLayout from '../../components/layouts/MasterLayout'
import { COLORS, FONTS } from '../../theme'
import Button from '../../components/ui/Button'
import ProductForm from '../../components/ProductForm'
import { updateProductService } from '../../services/ProductService'

export default function EditProductScreen ({ route }) {
  const { producto } = route.params
  if (!producto) {
    return (
      <MasterLayout withoutScroll>
        <View style={styles.container}>
          <Text style={styles.paragraph}>No se ha proporcionado información del producto.</Text>
          <Button variants='primary'>Ir a productos</Button>
        </View>
      </MasterLayout>
    )
  }

  return (
    <MasterLayout>
      <View style={styles.container}>
        <Text style={styles.paragraph}>Rellena el formulario para agregar un nuevo producto a la lista:</Text>
        <ProductForm apiService={updateProductService} product={producto} />
      </View>
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: 20,
    backgroundColor: COLORS.white.hex
  },
  paragraph: {
    fontFamily: FONTS.primary.regular,
    fontSize: 20,
    marginVertical: 10
  }
})
