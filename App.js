import { useEffect, useState } from 'react'
import { NavigationContainer } from '@react-navigation/native'
import { createNativeStackNavigator } from '@react-navigation/native-stack'
import LoginScreen from './src/screens/LoginScreen'
import ProductsScreen from './src/screens/ProductsScreen'
import { profileService } from './src/services/AuthService'
import AuthContext from './src/contexts/AuthContext'
import SplashScreen from './src/screens/SplashScreen'
import RegisterScreen from './src/screens/RegisterScreen'
import HomeScreen from './src/screens/HomeScreen'

const Stack = createNativeStackNavigator()

export default function App () {
  const [profile, setProfile] = useState()
  const [status, setStatus] = useState('loading')

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
            animation: 'ios'
          }}
        >
          {profile
            ? (
              <>
                <Stack.Screen name='products' component={ProductsScreen} options={{ title: 'Productos' }} />
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
