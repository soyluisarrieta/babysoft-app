import { SafeAreaView, StyleSheet, View } from 'react-native'
import FormField from '../components/ui/FormField'

export default function LoginScreen () {
  return (
    <SafeAreaView style={styles.wrapper}>
      <View style={styles.container}>
        <FormField label='Correo electrónico' />
        <FormField label='Contraseña' secureTextEntry />
      </View>
    </SafeAreaView>
  )
}

const styles = StyleSheet.create({
  wrapper: {
    backgroundColor: '#fff',
    flex: 1
  },
  container: {
    padding: 20,
    rowGap: 16
  }
})
