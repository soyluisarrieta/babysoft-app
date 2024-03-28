import { Image, ImageBackground, Pressable, StyleSheet, Text, View } from 'react-native'
import MasterLayout from '../components/layouts/MasterLayout'
import Button from '../components/ui/Button'
import { COLORS, FONTS } from '../theme'
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
          <Button onPress={() => navigation.navigate('login')}>Ingresar</Button>
          <View style={styles.rowContainer}>
            <Text style={styles.text}>¿Aún no tienes una cuenta?</Text>
            <Pressable
              onPress={() => navigation.navigate('register')}
            >
              <Text style={styles.boldText}>Regístrate</Text>
            </Pressable>
          </View>
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
    backgroundColor: rgba(COLORS.white.rgb, 0.8),
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingVertical: 50,
    paddingHorizontal: 20
  },
  logo: {
    width: 300,
    flex: 1,
    alignSelf: 'center',
    resizeMode: 'contain'
  },
  rowContainer: {
    flexDirection: 'row',
    justifyContent: 'center',
    opacity: 0.8,
    marginTop: 15
  },
  text: {
    fontSize: 16,
    fontFamily: FONTS.primary.regular
  },
  boldText: {
    marginLeft: 4,
    color: COLORS.primary.hex,
    fontFamily: FONTS.primary.bold
  }
})
