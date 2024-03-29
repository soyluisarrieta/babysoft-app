import { StyleSheet, Text, TextInput, View } from 'react-native'
import { FONTS } from '../../theme'

export default function FormField ({ label, errors = [], ...rest }) {
  return (
    <View>
      {label && (
        <Text style={styles.label}>
          {label}
        </Text>
      )}
      <TextInput
        style={styles.input}
        autoCapitalize='none'
        {...rest}
      />
      {errors.map((err) => {
        return (
          <Text key={err} style={styles.error}>
            {err}
          </Text>
        )
      })}
    </View>
  )
}

const styles = StyleSheet.create({
  label: {
    color: '#334155',
    fontFamily: FONTS.primary.semibold,
    fontSize: 17
  },
  input: {
    backgroundColor: '#f1f5f9',
    marginTop: 4,
    borderWidth: 1,
    borderRadius: 10,
    borderColor: '#cbd5e1',
    paddingVertical: 10,
    paddingHorizontal: 20
  },
  error: {
    color: 'red',
    marginTop: 2
  }
})
