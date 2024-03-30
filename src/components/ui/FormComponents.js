import { StyleSheet, Text, TextInput, View } from 'react-native'
import { Picker } from '@react-native-picker/picker'
import ErrorBlock from './ErrorBlock'
import { COLORS, FONTS } from '../../theme'
import { rgba } from '../../utils/helpers'

export function Label ({ children }) {
  return (
    <Text style={styles.label}>
      {children}
    </Text>
  )
}

export function InputField ({ label, errors = [], ...rest }) {
  return (
    <View>
      {label && <Label>{label}</Label>}
      <TextInput
        style={[styles.input, errors.length && { borderWidth: 1.3, borderColor: rgba('255,0,0', 0.5) }]}
        autoCapitalize='none'
        {...rest}
      />
      <ErrorBlock errors={errors} />
    </View>
  )
}

export function SelectField ({ label, errors = [], arrayItems, selectedValue, onValueChange, placeholder, children, ...rest }) {
  return (
    <View>
      {label && <Label>{label}</Label>}
      <View
        style={[
          styles.input,
          { paddingHorizontal: 4, paddingVertical: 0 },
          errors.length && { borderWidth: 1.3, borderColor: rgba('255,0,0', 0.5) }
        ]}
      >
        <Picker
          selectedValue={selectedValue}
          onValueChange={onValueChange}
          {...rest}
        >
          <Picker.Item label={placeholder || 'Selecciona una opción'} value={null} color='#a4a4a4' />
          {arrayItems
            ? (arrayItems.map((item) => (
              <Picker.Item
                key={item}
                label={item}
                value={item}
                color={COLORS.black.hex}
              />)))
            : { children }}
        </Picker>
      </View>
      <ErrorBlock errors={errors} />
    </View>
  )
}

export function SelectOption ({ label, value, ...rest }) {
  return (<Picker.Item label={label} value={value} {...rest} />)
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
