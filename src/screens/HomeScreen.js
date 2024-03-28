import { Button, Image, SafeAreaView, StyleSheet, View } from 'react-native'

export default function HomeScreen ({ navigation }) {
  return (
    <SafeAreaView style={styles.wrapper}>
      <View style={styles.container}>
        <Image
          source={require('../../assets/babysoft-logo.jpg')}
          style={{
            width: 200,
            objectFit: 'contain'
          }}
        />

        <Button
          title='Ingresar' onPress={() => {
            navigation.navigate('login')
          }}
        />
        <Button
          title='Registrarse' onPress={() => {
            navigation.navigate('register')
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
