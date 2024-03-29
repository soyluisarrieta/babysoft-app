import { SafeAreaView, ScrollView, StyleSheet } from 'react-native'
import { COLORS } from '../../theme'

export default function MasterLayout ({ style, withoutScroll, children, ...rest }) {
  return (
    <SafeAreaView style={[styles.container, style]} {...rest}>
      {withoutScroll
        ? children
        : <ScrollView>{children}</ScrollView>}
    </SafeAreaView>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.white.hex
  }
})
