import { SafeAreaView, StyleSheet } from 'react-native'
import { COLORS } from '../../theme'

export default function MasterLayout ({ style, children, ...rest }) {
  return (
    <SafeAreaView style={[styles.container, style]} {...rest}>
      {children}
    </SafeAreaView>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.white.hex
  }
})
