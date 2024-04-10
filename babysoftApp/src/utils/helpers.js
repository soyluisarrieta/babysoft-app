export const rgb = (rgbCode) => `rgb(${rgbCode})`
export const rgba = (rgbCode, alpha) => `rgba(${rgbCode}, ${alpha})`

export const onlyNumbers = (text) => text.trim() === '' || /^[0-9]+$/.test(text)
export const onlyLetters = (text) => text.trim() === '' || /^[A-Za-z\s]+$/.test(text)
