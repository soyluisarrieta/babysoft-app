import { Image, SafeAreaView, Text, View } from 'react-native'

export default function SplashScreen () {
  return (
    <SafeAreaView style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
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
    </SafeAreaView>
  )
}
