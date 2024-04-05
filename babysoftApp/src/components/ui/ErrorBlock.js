import { StyleSheet, Text, View } from 'react-native'
import { FONTS } from '../../theme'
import { rgba } from '../../utils/helpers'

export default function ErrorBlock ({ style, styleText, errors = [], ...rest }) {
  return (
    <View style={[errors.length && styles.errorContainer, style]}>
      {errors.map((err) => {
        return (
          <Text key={err} style={[styles.errorText, styleText]} {...rest}>
            {err}
          </Text>
        )
      })}
    </View>
  )
}

const styles = StyleSheet.create({
  errorContainer: {
    backgroundColor: rgba('255, 0, 0', 0.07),
    borderRadius: 5,
    paddingVertical: 7,
    paddingHorizontal: 15,
    marginTop: 3,
    marginBottom: 7
  },
  errorText: {
    color: 'red',
    fontFamily: FONTS.primary.medium,
    fontSize: 12,
    marginTop: 2
  }
})
