# Proyecto Final: Sistema de Gestión de Materiales "Halcon" (Evidencia 2 & 3)

**Autor:** Jorge Arcibar

## Descripción General del Proyecto

Este repositorio contiene el desarrollo del sistema de gestión de materiales "Halcon", una aplicación web construida con Laravel y AdminLTE para automatizar procesos internos de un distribuidor de materiales de construcción. El proyecto ha evolucionado a través de varias etapas (Evidencia 1, 2 y 3), enfocándose en la funcionalidad del backend y, en esta última fase, en la mejora visual y la experiencia de usuario del panel administrativo.

## Funcionalidades Implementadas

### Módulo Público (Seguimiento de Órdenes)

* **Página de Inicio Pública:** Permite a los clientes consultar el estado de sus órdenes ingresando un número de cliente y número de factura.
* **Visualización de Estado y Evidencia:** Muestra el estado actual de la orden y, si el estado es "Delivered", la foto de evidencia de entrega.

### Módulo Administrativo (Dashboard)

* **Integración de AdminLTE:** Panel de administración con un diseño moderno y responsivo.
* **Autenticación:** Sistema de login y registro de usuarios.
* **Dashboard Personalizado:** Vista principal para usuarios autenticados.
* **Gestión de Usuarios:**
    * **Listado de Usuarios:** Tabla con diseño atractivo, paginación, y opciones para ver, editar, activar/desactivar usuarios.
    * **Creación de Usuarios:** Formulario para registrar nuevos usuarios con asignación de roles/departamentos.
    * **Edición de Usuarios:** Formulario para modificar datos de usuarios existentes y cambiar su rol/departamento.
    * **Control de Estado:** Opción para activar o desactivar usuarios.
* **Gestión de Órdenes:**
    * **Listado de Órdenes:** Tabla con diseño atractivo, búsqueda por número de factura, nombre de cliente y estado. Permite ver detalles, editar y archivar órdenes.
    * **Creación de Órdenes:** Formulario completo para que los vendedores registren nuevas órdenes con todos los datos requeridos (número de factura, cliente, dirección, monto, etc.). El estado inicial es "Ordered".
    * **Visualización de Órdenes:** Pantalla de detalles para cada orden, mostrando toda la información, historial de proceso y fotos de evidencia.
    * **Edición de Órdenes:** Formulario para actualizar la información de una orden.
    * **Gestión de Fotos de Evidencia:** Los usuarios del departamento "Ruta" pueden cargar fotos de la unidad "en ruta" y del material "entregado".
    * **Archivado Lógico:** Las órdenes pueden ser "archivadas" (eliminadas lógicamente) y no se muestran en el listado principal.

## Ciclo de Vida de una Orden (Implementado)

1.  **Ordered:** Un vendedor registra una nueva orden en la plataforma.
2.  **In process:** Un miembro del almacén cambia el estado de la orden.
3.  **In route:** El personal de almacén cambia el estado y carga la unidad. El personal de Ruta puede subir una foto de la unidad cargada.
4.  **Delivered:** El operador de Ruta sube una foto del material descargado como evidencia.

## Problemas Conocidos

* **Página de Órdenes Archivadas (404 Not Found):** A pesar de que la ruta y el controlador para listar órdenes archivadas están definidos, la página `http://127.0.0.1:8000/orders/archived` actualmente devuelve un error "404 Not Found". Se han realizado múltiples intentos de depuración y limpieza de caché sin éxito aparente en el entorno de desarrollo actual.

## Cómo Ejecutar el Proyecto

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/JorgeGAR22/Evidencia2.git](https://github.com/JorgeGAR22/Evidencia2.git)
    ```
2.  **Navegar al directorio del proyecto:**
    ```bash
    cd Evidencia2 # O el nombre de tu carpeta local, ej. activity-9
    ```
3.  **Instalar dependencias de Composer:**
    ```bash
    composer install
    ```
4.  **Generar la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```
5.  **Configurar la base de datos** en tu archivo `.env` (ej. MySQL, SQLite).
6.  **Ejecutar migraciones y seeders (si tienes):**
    ```bash
    php artisan migrate --seed # Si tienes seeders para usuarios, roles, órdenes
    ```
7.  **Instalar dependencias de NPM y compilar assets:**
    ```bash
    npm install
    npm run dev # Dejar esta terminal abierta y ejecutándose
    ```
8.  **Iniciar el servidor de desarrollo de Laravel (en una nueva terminal):**
    ```bash
    php artisan serve
    ```
9.  **Acceder a la aplicación:**
    * **Página Pública:** `http://127.0.0.1:8000/`
    * **Panel de Administración (Login):** `http://127.0.0.1:8000/login` (usa un usuario existente o crea uno si ejecutaste los seeders).
    * **Dashboard:** `http://127.0.0.1:8000/dashboard`

## URL del Proyecto en GitHub

[https://github.com/JorgeGAR22/Evidencia2](https://github.com/JorgeGAR22/Evidencia2)

