import { useState } from 'react'
import { Button, Platform, SafeAreaView, StyleSheet, View } from 'react-native'
import FormField from '../components/ui/FormField'
import axios from 'axios'

export default function LoginScreen () {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [errors, setErrors] = useState({})

  const handleSubmit = async () => {
    setErrors({})
    try {
      const { data } = await axios.post('http://192.168.1.105:8000/api/login', {
        email,
        password,
        device_name: `${Platform.OS} ${Platform.Version}`
      }, {
        headers: { Accept: 'application/json' }
      })

      const { data: profile } = await axios.get('http://192.168.1.105:8000/api/user', {
        headers: { Accept: 'application/json', Authorization: `Bearer ${data.token}` }
      })

      console.log(profile)
    } catch (e) {
      console.warn(e.response)
      if (e.response?.status === 422) {
        setErrors(e.response.data.errors)
      }
    }
  }

  return (
    <SafeAreaView style={styles.wrapper}>
      <View style={styles.container}>
        <FormField
          label='Correo electrónico'
          value={email}
          onChangeText={(text) => setEmail(text)}
          errors={errors.email}
        />
        <FormField
          label='Contraseña'
          secureTextEntry
          value={password}
          onChangeText={(text) => setPassword(text)}
          errors={errors.password}
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
