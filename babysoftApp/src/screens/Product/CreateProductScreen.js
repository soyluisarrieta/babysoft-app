import { StyleSheet, Text, View } from 'react-native'
import MasterLayout from '../../components/layouts/MasterLayout'
import { COLORS, FONTS } from '../../theme'
import ProductForm from '../../components/ProductForm'
import { createProductService } from '../../services/ProductService'

export default function CreateProductScreen () {
  return (
    <MasterLayout>
      <View style={styles.container}>
        <Text style={styles.paragraph}>Rellena el formulario para agregar un nuevo producto a la lista:</Text>
        <ProductForm apiService={createProductService} />
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
