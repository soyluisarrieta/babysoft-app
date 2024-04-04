import React from 'react'
import { TouchableOpacity, Text, StyleSheet, ActivityIndicator, Keyboard } from 'react-native'
import { COLORS, FONTS } from '../../theme'
import { rgba } from '../../utils/helpers'

const textColors = {
  default: { color: '#fff' },
  outline: { color: COLORS.primary.hex },
  link: { color: COLORS.primary.hex },
  primary: { color: '#fff' },
  secundary: { color: '#fff' }
}

const buttonVariants = {
  default: {
    backgroundColor: COLORS.black.hex
  },
  outline: {
    backgroundColor: 'transparent',
    borderColor: rgba(COLORS.primary.rgb, 0.7),
    borderWidth: 1.5
  },
  link: {
    backgroundColor: 'transparent'
  },
  primary: {
    backgroundColor: COLORS.primary.hex
  },
  secundary: {
    backgroundColor: COLORS.secundary.hex
  }
}

const Button = ({
  variants = 'default',
  onPress,
  onLongPress,
  iconLeft,
  iconRight,
  style,
  textStyle,
  disabled,
  activeOpacity,
  loading,
  children,
  ...rest
}) => {
  return (
    <TouchableOpacity
      onPress={() => { onPress(); Keyboard.dismiss() }}
      onLongPress={onLongPress}
      disabled={disabled}
      activeOpacity={activeOpacity}
      style={[disabled ? styles.disabledButton : styles.button, buttonVariants[variants] ?? buttonVariants.default, style]}
      {...rest}
    >
      {iconLeft}
      {loading
        ? (
          <ActivityIndicator color='white' />
          )
        : (
          <Text style={[styles.buttonText, textColors[variants] ?? textColors.default, textStyle]}>
            {children}
          </Text>
          )}
      {iconRight}
    </TouchableOpacity>
  )
}

const styles = StyleSheet.create({
  button: {
    paddingVertical: 12,
    paddingHorizontal: 20,
    borderRadius: 10,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    width: '100%'
  },
  disabledButton: {
    opacity: 0.4,
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 5,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    width: '100%'
  },
  buttonText: {
    fontSize: 18,
    fontFamily: FONTS.primary.bold
  }
})

export default Button
