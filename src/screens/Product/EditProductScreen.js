import { StyleSheet, Text, View } from 'react-native'
import MasterLayout from '../../components/layouts/MasterLayout'
import { FONTS } from '../../theme'
import Button from '../../components/ui/Button'

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
    <MasterLayout withoutScroll>
      <View style={styles.container}>
        <Text style={styles.paragraph}>Editar: {producto.nombre}</Text>
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
  }
})
