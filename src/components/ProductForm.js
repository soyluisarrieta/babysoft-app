import React, { useState } from 'react'
import { View, StyleSheet, Image, TouchableOpacity, ImageBackground, Text } from 'react-native'
import { InputField, Label, SelectField } from './ui/FormComponents'
import Button from './ui/Button'
import { useNavigation } from '@react-navigation/native'
import * as ImagePicker from 'expo-image-picker'
import ErrorBlock from './ui/ErrorBlock'
import { rgba } from '../utils/helpers'
import { COLORS } from '../theme'
import { API_URL } from '../utils/axios'

export default function ProductForm ({ product = {}, apiService }) {
  const [name, setName] = useState(product.nombreProducto || '')
  const [talla, setTalla] = useState(product.Talla || '')
  const [cantidad, setCantidad] = useState(product.Cantidad || '0')
  const [categoria, setCategoria] = useState(product.Categoria || '')
  const [precio, setPrecio] = useState(product.Precio || null)
  const [foto, setFoto] = useState(`${API_URL}/../images/products/${product.Foto}` || null)
  const [idReferencia, setIdReferencia] = useState(product.idReferencia || null)

  const navigation = useNavigation()

  const [isLoading, setIsLoading] = useState(false)
  const [errors, setErrors] = useState({})

  const handleSubmit = async () => {
    setIsLoading(true)
    setErrors({})
    try {
      await apiService({
        id: product?.id,
        idReferencia,
        nombreProducto: name,
        Talla: talla,
        Cantidad: cantidad,
        Categoria: categoria,
        Precio: precio,
        Foto: foto // Agregar la foto al objeto enviado
      })
      navigation.navigate('products')
    } catch (e) {
      console.warn(e.response)
      if (e.response?.status === 422) {
        console.log(e.response.data.errors)
        setErrors(e.response.data.errors)
      }
    } finally {
      setTimeout(() => {
        setIsLoading(false)
      }, 300)
    }
  }

  const handlePickImage = async () => {
    const result = await ImagePicker.launchImageLibraryAsync({
      mediaTypes: ImagePicker.MediaTypeOptions.All,
      allowsEditing: true,
      aspect: [4, 3],
      quality: 1
    })

    if (!result.canceled) {
      setFoto(result.assets[0].uri)
    }
  }

  return (
    <View style={styles.formContainer}>
      <InputField
        label='Id de Referencia'
        value={idReferencia}
        onChangeText={(text) => setIdReferencia(text)}
        errors={errors.idReferencia}
      />
      <InputField
        label='Nombre del producto'
        value={name}
        onChangeText={(text) => setName(text)}
        errors={errors.nombreProducto}
      />
      <SelectField
        label='Categorías'
        arrayItems={['Camisa', 'Pantalón', 'Conjunto', 'Pijamas']}
        selectedValue={categoria}
        onValueChange={(itemValue) => setCategoria(itemValue)}
        placeholder='Selecciona una categoría'
        errors={errors.Categoria}
      />
      <SelectField
        label='Tallas'
        arrayItems={['0-3 meses', '3-6 meses', '6-9 meses']}
        selectedValue={talla}
        onValueChange={(itemValue) => setTalla(itemValue)}
        placeholder='Selecciona una talla'
        errors={errors.Talla}
      />
      <InputField
        label='Cantidad'
        value={cantidad}
        numeric
        onChangeText={(text) => setCantidad(text)}
        errors={errors.Cantidad}
      />
      <View>
        <InputField
          label='Precio'
          value={precio}
          numeric
          onChangeText={(text) => setPrecio(text)}
          errors={errors.Precio}
          style={{ paddingLeft: 25 }}
        />
        <Text style={{ position: 'absolute', bottom: 15, left: 15, opacity: 0.4 }}>$</Text>
      </View>
      <View>
        <Label>Foto</Label>
        <TouchableOpacity
          style={styles.imagePicker}
          onPress={handlePickImage}
        >
          <ImageBackground
            style={[styles.imagePicker, { overflow: 'hidden', justifyContent: 'center', alignItems: 'center' }]}
            source={require('../../assets/product-placeholder.png')}
            imageStyle={{ opacity: 0.5 }}
          >
            {foto && (
              <Image
                style={styles.imagePreview}
                source={{ uri: foto }}
              />
            )}
          </ImageBackground>
        </TouchableOpacity>
        <ErrorBlock errors={errors.foto} />
      </View>

      <View style={styles.buttonsContainer}>
        <Button
          style={{ width: 'auto' }}
          variants='primary'
          onPress={handleSubmit}
          loading={isLoading}
        >
          Guardar
        </Button>
        <Button
          style={{ width: 'auto' }}
          variants='link'
          onPress={() => { navigation.goBack() }}
        >
          cancelar
        </Button>
      </View>
    </View>
  )
}

const styles = StyleSheet.create({
  formContainer: {
    rowGap: 16,
    paddingVertical: 20
  },
  buttonsContainer: {
    paddingTop: 30
  },
  imagePicker: {
    width: '100%',
    height: 300,
    borderRadius: 10,
    borderWidth: 1,
    borderColor: rgba(COLORS.black.rgb, 0.1)
  },
  imagePreview: {
    width: '100%',
    height: '100%',
    objectFit: 'cover'
  }
})
