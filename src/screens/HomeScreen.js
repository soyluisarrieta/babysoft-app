import { Button, SafeAreaView, StyleSheet, View } from 'react-native'

export default function HomeScreen ({ navigation }) {
  return (
    <SafeAreaView style={styles.wrapper}>
      <View style={styles.container}>
        <Button
          title='Ingresar' onPress={() => {
            navigation.navigate('Iniciar sesión')
          }}
        />
        <Button
          title='Registrarse' onPress={() => {
            navigation.navigate('Crear cuenta')
          }}
        />
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
