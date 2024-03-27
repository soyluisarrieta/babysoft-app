# BabySoft App  🍼📱

![BabySoft logo](./assets/babysoft-logo.png)

Este proyecto presenta la implementación de un sistema de inicio de sesión (ingreso/registro) con diversas vistas y rutas protegidas. Además, incluye un completo CRUD de productos categorizados, utilizando React Native con [Expo](https://expo.dev/) y [Laravel Breeze API](https://laravel.com/docs/11.x/starter-kits#laravel-breeze).

## 📋 Requisitos previos

1. Para comenzar, asegúrate de tener instalado [NodeJS](https://nodejs.org/en/download) para ejecutar el entorno de desarrollo.

2. Verifica también que tengas instalada o actualizada la línea de comandos de Expo CLI mediante el siguiente comando:

    ```bash
    npm i -g expo-cli
    ```

3. Asegúrate de tener la aplicación Expo instalada en tu dispositivo móvil desde la [Play Store](https://play.google.com/store/apps/details?id=host.exp.exponent&pcampaignid=web_share) o desde la [Apps store](https://apps.apple.com/us/app/expo-go/id982107779) para poder previsualizar el servidor en tu celular.

4. Para Laravel se requiere tener instalado [composer](https://getcomposer.org/download/).

5. Opcionalmente tener instalado [Git](https://git-scm.com/downloads) para clonar el repositorio.

## 🚀 Empezar con el proyecto

### 🔹 Clona o descarga este repositorio

```bash
git clone https://github.com/soyluisarrieta/babysoft-app.git
```

### Pasos para configurar e iniciar la aplicación con Expo

1. #### Abrir una terminal dentro de la carpeta principal del proyecto

2. #### Instalar las dependencias utilizando el gestor de paquetes de Node.js

    ```bash
    npm install
    ```

3. #### Iniciar el servidor local de la aplicación

    Para ejecutar el entorno de desarrollo de React Native con Expo, utiliza:

    ```bash
    npm start
    ```

### 🔸 Pasos para configurar e iniciar la API de Laravel Breeze

1. #### Abrir otra terminal dentro de la carpeta *API_BABYSOFT*

2. #### Instalar las dependencias utilizando el gestor de paquetes de Composer

    ```bash
    composer install
    ```

3. #### Generar las variables de entorno ejecutando

    ```bash
    cp .env.example .env
    ```

4. #### Generar la clave de la aplicación

    ```bash
    php artisan key:generate
    ```

5. #### Crear una base de datos en tu gestor de preferencia
  
    **⚠️ IMPORTANTE:** El nombre de la base de datos debe ser `babysoft_app` con cotejamiento `utf8_bin`. Si prefieres otro nombre, debes modificarlo en las variables de entorno.

6. Ejecutar las migraciones para crear las tablas:

    ```bash
    php artisan migrate
    ```

    O si la base de datos ya existe y necesitas reiniciarla:

    ```bash
    php artisan migrate:refresh
    ```

7. Finalmente, ejecutar el servidor local

    ```bash
    php artisan serve
    ```

## 🧩 Características generales

- [ ] Rutas públicas y privadas
- [ ] Sistema de Login simple (Ingreso/Registro)
- [ ] Autenticación y comunicación mediante CSRF con Token
- [ ] CRUD de productos
- [ ] CRUD de categorías
