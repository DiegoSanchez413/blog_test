# Prueba de selección - GLR

## Diego Sánchez

## Prueba 1 y 2

Primero clonar el repositorio y copiar el archivo .env.example

Descargar dependencias de composer

```sh
composer install
```

Ejecutar las migraciones:

```sh
php artisan migrate
```

Descargar las dependencias y compilar los archivos js y css:

```sh
npm install && npm run dev
```

Opcional si no se usa algún servidor de php:

```sh
php artisan serve
```

### Prueba 3

¿Qué ventajas nos ofrece el uso de migraciones en una aplicación Laravel en producción?

El uso de migraciones independientemente al entorno en donde se encuentre el proyecto sirve para administrar las tablas de la base de datos, en resumen es como un control de versiones orientado a BD para que durante su desarrollo varios integrantes del equipo del proyecto puedan manejar la misma versión e ir incrementando más entidades. En el entorno de producción facilita la modificación e integración de nuevas columnas para las tablas.
