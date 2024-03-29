import { SafeAreaView, ScrollView, StyleSheet } from 'react-native'
import { COLORS } from '../../theme'

export default function MasterLayout ({ style, onScroll, children, ...rest }) {
  return (
    <SafeAreaView style={[styles.container, style]} {...rest}>
      {onScroll
        ? <ScrollView> {children} </ScrollView>
        : children}
    </SafeAreaView>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.white.hex
  }
})
