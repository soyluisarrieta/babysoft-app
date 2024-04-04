import { useContext, useState } from 'react'
import { Image, Platform, StyleSheet, Text, View } from 'react-native'
import { InputField } from '../components/ui/FormComponents'
import { profileService, registerService } from '../services/AuthService'
import AuthContext from '../contexts/AuthContext'
import MasterLayout from '../components/layouts/MasterLayout'
import Button from '../components/ui/Button'
import { FONTS } from '../theme'

export default function RegisterScreen ({ navigation }) {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [passwordConfirmation, setPasswordConfirmation] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const [errors, setErrors] = useState({})

  const { setProfile } = useContext(AuthContext)

  const onRegister = async () => {
    setIsLoading(true)
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
      navigation.replace('products')
    } catch (e) {
      console.warn(e.response)
      if (e.response?.status === 422) {
        setErrors(e.response.data.errors)
      }
    } finally {
      setPassword('')
      setPasswordConfirmation('')
      setTimeout(() => {
        setIsLoading(false)
      }, 300)
    }
  }

  return (
    <MasterLayout>
      <View style={styles.container}>
        <Image
          source={require('../../assets/register.png')}
          style={styles.illustration}
        />
        <Text style={styles.paragraph}>Rellena el formulario para crear una cuenta.</Text>
        <InputField
          label='Nombre y apellido'
          value={name}
          onChangeText={(text) => setName(text)}
          errors={errors.name}
        />
        <InputField
          label='Correo electrónico'
          value={email}
          onChangeText={(text) => setEmail(text)}
          errors={errors.email}
        />
        <InputField
          label='Contraseña'
          secureTextEntry
          value={password}
          onChangeText={(text) => setPassword(text)}
          errors={errors.password}
        />
        <InputField
          label='Confirmar contraseña'
          secureTextEntry
          value={passwordConfirmation}
          onChangeText={(text) => setPasswordConfirmation(text)}
          errors={errors.password_confirmation}
        />
        <Button
          variants='primary'
          onPress={onRegister}
          style={{ marginVertical: 20 }}
          loading={isLoading}
        >
          Registrarse
        </Button>
      </View>
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  wrapper: {
    backgroundColor: '#fff',
    flex: 1
  },
  illustration: {
    height: 234,
    opacity: 0.7,
    marginBottom: 20,
    alignSelf: 'center',
    resizeMode: 'contain'
  },
  container: {
    padding: 20,
    rowGap: 16
  },
  paragraph: {
    fontFamily: FONTS.primary.regular,
    fontSize: 16
  }
})
