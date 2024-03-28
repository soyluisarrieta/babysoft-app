import { StyleSheet, Text, TextInput, View } from 'react-native'

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
    fontWeight: '500'
  },
  input: {
    backgroundColor: '#f1f5f9',
    height: 40,
    marginTop: 4,
    borderWidth: 1,
    borderRadius: 4,
    borderColor: '#cbd5e1',
    padding: 10
  },
  error: {
    color: 'red',
    marginTop: 2
  }
})
