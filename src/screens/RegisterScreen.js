import { useContext, useState } from 'react'
import { Button, Platform, StyleSheet, View } from 'react-native'
import FormField from '../components/ui/FormField'
import { profileService, registerService } from '../services/AuthService'
import AuthContext from '../contexts/AuthContext'
import MasterLayout from '../components/layouts/MasterLayout'

export default function RegisterScreen ({ navigation }) {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [passwordConfirmation, setPasswordConfirmation] = useState('')
  const [errors, setErrors] = useState({})

  const { setProfile } = useContext(AuthContext)

  const onRegister = async () => {
    setErrors({})
    try {
      await registerService({
        name,
        email,
        password,
        password_confirmation: passwordConfirmation,
        device_name: `${Platform.OS} ${Platform.Version}`
      })

      const profile = await profileService()
      setProfile(profile)
      navigation.replace('Products')
    } catch (e) {
      // console.warn(e.response)
      if (e.response?.status === 422) {
        setErrors(e.response.data.errors)
      }
    } finally {
      setPassword('')
      setPasswordConfirmation('')
    }
  }

  return (
    <MasterLayout>
      <View style={styles.container}>
        <FormField
          label='Nombre y apellido'
          value={name}
          onChangeText={(text) => setName(text)}
          errors={errors.name}
        />
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
        <FormField
          label='Confirmar contraseña'
          secureTextEntry
          value={passwordConfirmation}
          onChangeText={(text) => setPasswordConfirmation(text)}
          errors={errors.password_confirmation}
        />
        <Button title='Ingresar' onPress={onRegister} />
      </View>
    </MasterLayout>
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
