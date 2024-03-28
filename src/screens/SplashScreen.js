import { Image, Text, View } from 'react-native'
import MasterLayout from '../components/layouts/MasterLayout'

export default function SplashScreen () {
  return (
    <MasterLayout style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <View>
        <Image
          source={require('../../assets/babysoft-logo-circle.jpg')}
          style={{
            width: '100%',
            objectFit: 'contain'
          }}
        />

        <Text>Cargando...</Text>
      </View>
    </MasterLayout>
  )
}
