import { Image, ImageBackground, StyleSheet, View } from 'react-native'
import MasterLayout from '../components/layouts/MasterLayout'
import Button from '../components/ui/Button'
import { COLORS } from '../theme'
import { rgba } from '../utils/helpers'

export default function HomeScreen ({ navigation }) {
  return (
    <MasterLayout>
      <ImageBackground
        source={require('../../assets/bg-home.jpg')}
        style={styles.backgroundImage}
      >
        <View style={styles.container}>
          <Image
            source={require('../../assets/babysoft-logo.png')}
            style={styles.logo}
          />
          <Button
            variants='primary'
            onPress={() => navigation.navigate('login')}
          >
            Iniciar sesión
          </Button>
          <Button
            variants='link'
            onPress={() => navigation.navigate('register')}
            style={{ marginTop: 5 }}
          >
            Crea una cuenta
          </Button>
        </View>
      </ImageBackground>
    </MasterLayout>
  )
}

const styles = StyleSheet.create({
  backgroundImage: {
    flex: 1,
    resizeMode: 'cover',
    justifyContent: 'center',
    width: '100%',
    height: '100%'
  },
  container: {
    backgroundColor: rgba(COLORS.white.rgb, 0.88),
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingVertical: 40,
    paddingHorizontal: 20
  },
  logo: {
    width: 321,
    flex: 1,
    alignSelf: 'center',
    resizeMode: 'contain'
  },
  rowContainer: {
    flexDirection: 'row',
    justifyContent: 'center',
    opacity: 0.8,
    marginTop: 15
  }
})
