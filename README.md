# Actividad 9: Sistema de Gestión de Notas con Laravel

Este proyecto implementa un sistema básico de gestión de notas (CRUD: Crear, Leer, Actualizar, Eliminar) utilizando el framework Laravel. Los usuarios pueden registrarse, iniciar sesión y gestionar sus propias notas personales.

## Características Principales

* **Autenticación de Usuarios (Login y Registro):** Implementado con Laravel Breeze, permite a los usuarios crear cuentas, iniciar sesión y acceder a un panel de control personalizado.
* **Gestión de Notas (CRUD Completo):**
    * **Crear:** Los usuarios autenticados pueden añadir nuevas notas con un título y contenido.
    * **Leer (Listado):** Se muestra un listado de todas las notas del usuario actualmente autenticado, con opciones para ver detalles, editar o eliminar.
    * **Leer (Detalles):** Vista individual para ver el contenido completo de una nota específica.
    * **Actualizar:** Formulario para modificar el título y contenido de una nota existente.
    * **Eliminar:** Funcionalidad para borrar notas del sistema.
* **Relación de Notas con Usuarios:** Cada nota está correctamente asociada al usuario que la creó, asegurando que cada usuario solo vea y gestione sus propias notas.

## Tecnologías Utilizadas

* **PHP:** Lenguaje de programación principal.
* **Laravel:** Framework PHP para el desarrollo de la aplicación web.
* **MySQL/MariaDB:** Base de datos relacional para almacenar información de usuarios y notas.
* **Blade:** Motor de plantillas de Laravel para las vistas.
* **Bootstrap (a través de Blade y Vite):** Framework CSS para el diseño responsivo.
* **Composer:** Gestor de dependencias de PHP.
* **Node.js y npm/Yarn:** Para la gestión de dependencias de frontend y compilación de assets (Vite).
* **Git & GitHub:** Control de versiones y alojamiento del código.

## Requisitos del Sistema

Para ejecutar este proyecto localmente, asegúrate de tener instalado:

* **PHP** (versión 8.1 o superior)
* **Composer**
* **Node.js** y **npm** (o Yarn)
* **Servidor de Base de Datos** (MySQL/MariaDB recomendado, XAMPP/MAMP/Laragon incluyen esto)

## Pasos para la Instalación y Configuración Local

Sigue estos pasos para poner el proyecto en marcha en tu entorno de desarrollo:

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/JorgeGAR22/actividad9.git](https://github.com/JorgeGAR22/actividad9.git)
    cd actividad9
    ```

2.  **Instalar dependencias de Composer (PHP):**
    ```bash
    composer install
    ```

3.  **Configurar el archivo de entorno:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configurar la base de datos en `.env`:**
    Abre el archivo `.env` en la raíz del proyecto y actualiza la sección de la base de datos con tus credenciales. Asegúrate de que la base de datos exista en tu gestor (ej. phpMyAdmin).

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=[tu_nombre_de_base_de_datos, ej: activity9_db]
    DB_USERNAME=[tu_usuario_de_mysql, ej: root]
    DB_PASSWORD=[tu_contraseña_de_mysql]
    ```

5.  **Ejecutar las migraciones de la base de datos y sembrar (seeds):**
    Este comando creará y poblará las tablas necesarias, incluyendo usuarios de prueba si tienes seeders. **¡Advertencia: esto borrará todos los datos existentes en la base de datos configurada!**
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Instalar dependencias de NPM (Frontend) y compilar los assets:**
    ```bash
    npm install
    npm run dev
    ```

7.  **Iniciar el servidor de desarrollo de Laravel:**
    ```bash
    php artisan serve
    ```

8.  **Acceder a la aplicación:**
    Abre tu navegador web y visita `http://127.0.0.1:8000`.

## Demostración y Capturas de Pantalla

A continuación, se presentan las capturas de pantalla que demuestran la funcionalidad completa del CRUD de notas y el sistema de autenticación:

* **Vista de Login/Registro:**
    _(Aquí puedes insertar la captura de la pantalla de login o registro, o omitirla si solo quieres centrarte en las notas.)_

* **Dashboard del Usuario Autenticado:**
    _(Aquí puedes insertar una captura del dashboard después de iniciar sesión, donde se ve la opción para "Gestionar Mis Notas".)_

* **Listado de Notas (Index):**
    ![Listado de Notas](https://i.imgur.com/tu_imagen_listado.png)
    _(Reemplaza `https://i.imgur.com/tu_imagen_listado.png` con el enlace directo a tu imagen de la captura del listado de notas. Si subiste tus imágenes a una carpeta `screenshots` en tu mismo repositorio, el enlace sería algo como: `screenshots/listado_de_notas.png`)_

* **Formulario para Crear Nueva Nota (Create):**
    ![Formulario de Creación de Nota](https://i.imgur.com/tu_imagen_crear.png)
    _(Reemplaza con el enlace directo a tu imagen del formulario de creación de notas.)_

* **Detalles de una Nota Específica (Show):**
    ![Detalles de la Nota](https://i.imgur.com/tu_imagen_detalles.png)
    _(Reemplaza con el enlace directo a tu imagen de la vista de detalles de una nota.)_

* **Formulario para Editar Nota (Edit):**
    ![Formulario de Edición de Nota](https://i.imgur.com/tu_imagen_editar.png)
    _(Reemplaza con el enlace directo a tu imagen del formulario de edición de notas.)_

## Contacto

Si tienes alguna pregunta o sugerencia, no dudes en contactarme:

* **Nombre:** [Tu Nombre Completo, ej: Jorge Arcibar González]
* **Email:** [Tu Correo Electrónico]
* **GitHub:** [Tu Usuario de GitHub, ej: JorgeGAR22]

---
