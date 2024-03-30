import { StyleSheet, Text, View } from 'react-native'
import MasterLayout from '../../components/layouts/MasterLayout'
import { FONTS } from '../../theme'

export default function CreateProductScreen () {
  return (
    <MasterLayout withoutScroll>
      <View style={styles.container}>
        <Text>Crear</Text>
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
