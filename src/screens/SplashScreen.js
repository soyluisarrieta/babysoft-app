import { Image } from 'react-native'
import MasterLayout from '../components/layouts/MasterLayout'
import { COLORS } from '../theme'

export default function SplashScreen () {
  return (
    <MasterLayout style={{ flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: COLORS.primary.hex }}>
      <Image
        source={require('../../assets/babysoft-logo-white.png')}
        style={{
          width: 300,
          alignSelf: 'center',
          resizeMode: 'contain',
          marginBottom: 100,
          flex: 1
        }}
      />
    </MasterLayout>
  )
}
