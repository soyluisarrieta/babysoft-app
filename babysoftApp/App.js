import { useEffect, useState } from 'react'
import { Appearance } from 'react-native'
import { profileService } from './src/services/AuthService'
import SplashScreen from './src/screens/SplashScreen'
import AuthContext from './src/contexts/AuthContext'
import { NavigationContainer } from '@react-navigation/native'
import { createNativeStackNavigator } from '@react-navigation/native-stack'
import { COLORS, FONTS } from './src/theme'
import HomeScreen from './src/screens/HomeScreen'
import LoginScreen from './src/screens/LoginScreen'
import RegisterScreen from './src/screens/RegisterScreen'
import ProductsScreen from './src/screens/Product/ProductsScreen'
import CreateProductScreen from './src/screens/Product/CreateProductScreen'
import EditProductScreen from './src/screens/Product/EditProductScreen'

const Stack = createNativeStackNavigator()

export default function App () {
  const [profile, setProfile] = useState()
  const [status, setStatus] = useState('loading')

  useEffect(() => Appearance.setColorScheme('light'), [])

  useEffect(() => {
    async function runEffect () {
      try {
        const profile = await profileService()
        setProfile(profile)
      } catch (e) {
        // console.warn('Failed to load user', e)
        setProfile(null)
      }

      setStatus('idle')
    }

    runEffect()
  }, [])

  if (status === 'loading') {
    return <SplashScreen />
  }

  return (
    <AuthContext.Provider value={{ profile, setProfile }}>
      <NavigationContainer>
        <Stack.Navigator
          initialRouteName='home'
          screenOptions={{
            headerMode: 'screen',
            headerTitleAlign: 'center',
            headerShadowVisible: false,
            headerStyle: { backgroundColor: COLORS.white.hex },
            headerTitleStyle: { fontFamily: FONTS.primary.bold, fontSize: 24 },
            animation: 'ios'
          }}
        >
          {profile
            ? (
              <>
                <Stack.Screen name='products' component={ProductsScreen} options={{ title: 'Productos' }} />
                <Stack.Screen name='product-create' component={CreateProductScreen} options={{ title: 'Crear producto' }} />
                <Stack.Screen name='product-edit' component={EditProductScreen} options={{ title: 'Editar productos' }} />
              </>
              )
            : (
              <>
                <Stack.Screen name='home' component={HomeScreen} options={{ headerShown: false }} />
                <Stack.Screen name='login' component={LoginScreen} options={{ title: 'Ingresar' }} />
                <Stack.Screen name='register' component={RegisterScreen} options={{ title: 'Crear cuenta' }} />
              </>
              )}
        </Stack.Navigator>
      </NavigationContainer>
    </AuthContext.Provider>
  )
}
