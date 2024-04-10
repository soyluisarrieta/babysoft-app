export const rgb = (rgbCode) => `rgb(${rgbCode})`
export const rgba = (rgbCode, alpha) => `rgba(${rgbCode}, ${alpha})`

export const onlyNumbers = (text) => text === '' || /^[0-9]+$/.test(text)
export const onlyLetters = (text) => text === '' || /^[A-Za-z]+$/.test(text)
