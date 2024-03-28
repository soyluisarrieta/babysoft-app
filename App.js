import { useEffect, useState } from 'react'
import { NavigationContainer } from '@react-navigation/native'
import { createNativeStackNavigator } from '@react-navigation/native-stack'
import LoginScreen from './src/screens/LoginScreen'
import ProductsScreen from './src/screens/ProductsScreen'
import { profileService } from './src/services/AuthService'
import AuthContext from './src/contexts/AuthContext'

const Stack = createNativeStackNavigator()

export default function App () {
  const [profile, setProfile] = useState()

  useEffect(() => {
    async function runEffect () {
      try {
        const profile = await profileService()
        setProfile(profile)
      } catch (e) {
        console.warn('Failed to load user', e)
      }
    }

    runEffect()
  }, [])

  return (
    <AuthContext.Provider value={{ profile, setProfile }}>
      <NavigationContainer>
        <Stack.Navigator>
          {profile
            ? (
              <>
                <Stack.Screen name='Products' component={ProductsScreen} />
              </>
              )
            : (
              <>
                <Stack.Screen name='Login' component={LoginScreen} />
              </>
              )}
        </Stack.Navigator>
      </NavigationContainer>
    </AuthContext.Provider>
  )
}
