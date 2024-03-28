import { useContext, useState } from 'react'
import { Button, Platform, SafeAreaView, StyleSheet, View } from 'react-native'
import FormField from '../components/ui/FormField'
import { loginService, profileService } from '../services/AuthService'
import AuthContext from '../contexts/AuthContext'

export default function LoginScreen ({ navigation }) {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [errors, setErrors] = useState({})

  const { setProfile } = useContext(AuthContext)

  const handleSubmit = async () => {
    setErrors({})
    try {
      await loginService({
        email,
        password,
        device_name: `${Platform.OS} ${Platform.Version}`
      })

      const profile = await profileService()
      setProfile(profile)
    } catch (e) {
      // console.warn(e.response)
      if (e.response?.status === 422) {
        setErrors(e.response.data.errors)
      }
    } finally {
      setPassword('')
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
