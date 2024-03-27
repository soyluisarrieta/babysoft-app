import { useState } from 'react'
import { Button, SafeAreaView, StyleSheet, View } from 'react-native'
import FormField from '../components/ui/FormField'

export default function LoginScreen () {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')

  const handleSubmit = () => {
    console.log(email, password)
  }

  return (
    <SafeAreaView style={styles.wrapper}>
      <View style={styles.container}>
        <FormField
          label='Correo electrónico'
          value={email}
          onChangeText={(text) => setEmail(text)}
        />
        <FormField
          label='Contraseña'
          secureTextEntry
          value={password}
          onChangeText={(text) => setPassword(text)}
        />
        <Button title='Ingresar' onPress={handleSubmit} />
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
