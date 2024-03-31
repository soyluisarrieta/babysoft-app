import React, { useState } from 'react'
import { View, StyleSheet } from 'react-native'
import { InputField, SelectField } from './ui/FormComponents'
import Button from './ui/Button'
import { useNavigation } from '@react-navigation/native'

export default function ProductForm ({ product = {}, apiService }) {
  console.log({ product })
  const [name, setName] = useState(product.nombreProducto || '')
  const [talla, setTalla] = useState(product.Talla || '')
  const [cantidad, setCantidad] = useState(product.Cantidad || 0)
  const [categoria, setCategoria] = useState(product.Categoria || '')
  const [precio, setPrecio] = useState(product.Precio || null)
  const [foto, setFoto] = useState(product.Foto || null)
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
        Precio: precio
        // Foto: foto
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

  return (
    <View style={styles.formContainer}>
      <InputField
        label='Nombre del producto'
        value={name}
        onChangeText={(text) => setName(text)}
        errors={errors.nombreProducto}
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
      <SelectField
        label='Categorías'
        arrayItems={['Camisa', 'Pantalón', 'Conjunto', 'Pijamas']}
        selectedValue={categoria}
        onValueChange={(itemValue) => setCategoria(itemValue)}
        placeholder='Selecciona una categoría'
        errors={errors.Categoria}
      />
      <InputField
        label='Precio'
        value={precio}
        numeric
        onChangeText={(text) => setPrecio(text)}
        errors={errors.Precio}
      />
      <InputField
        label='Foto'
        value={foto}
        onChangeText={(text) => setFoto(text)}
        errors={errors.Foto}
      />

      <InputField
        label='Id de Referencia'
        value={idReferencia}
        onChangeText={(text) => setIdReferencia(text)}
        errors={errors.idReferencia}
      />

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
  }
})
