import { useContext, useState } from 'react'
import { Image, Platform, StyleSheet, Text, View } from 'react-native'
import { InputField } from '../components/ui/FormComponents'
import { loginService, profileService } from '../services/AuthService'
import AuthContext from '../contexts/AuthContext'
import MasterLayout from '../components/layouts/MasterLayout'
import Button from '../components/ui/Button'
import { FONTS } from '../theme'

export default function LoginScreen () {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const [errors, setErrors] = useState({})

  const { setProfile } = useContext(AuthContext)

  const handleSubmit = async () => {
    setIsLoading(true)
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
      console.warn(e.response.data)
      if (e.response?.status === 422) {
        setErrors(e.response.data.errors)
      }
    } finally {
      setPassword('')
      setTimeout(() => {
        setIsLoading(false)
      }, 300)
    }
  }

  return (
    <MasterLayout>
      <View style={styles.container}>
        <Image
          source={require('../../assets/login.png')}
          style={styles.illustration}
        />
        <Text style={styles.paragraph}>Ingresa tu correo electrónico y contraseña para identificarte.</Text>
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
        <Button
          variants='primary'
          onPress={handleSubmit}
          style={{ marginVertical: 20 }}
          loading={isLoading}
        >
          Iniciar sesión
        </Button>
      </View>
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  container: {
    padding: 20,
    rowGap: 16
  },
  illustration: {
    height: 234,
    opacity: 0.7,
    marginBottom: 20,
    alignSelf: 'center',
    resizeMode: 'contain'
  },
  paragraph: {
    fontFamily: FONTS.primary.regular,
    fontSize: 16
  }
})
