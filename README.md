# Clínica Salud Ágil

Aplicación web académica para la gestión de pacientes, médicos y citas médicas.

## Tecnologías
- Ubuntu GNU/Linux
- PHP 8.4
- Laravel 13
- MariaDB
- Apache HTTP Server
- Git

## Funcionalidades
- Pacientes: registrar, consultar, editar y eliminar.
- Médicos: consultar, registrar y editar fichas.
- Citas: programar, consultar, editar y cancelar.
- Validación de horarios duplicados.
- Conexión con MariaDB y despliegue mediante Apache.

## Instalación
1. Instalar PHP, Composer, MariaDB y Apache.
2. Obtener el código fuente e instalar las dependencias con Composer.
3. Crear .env a partir de .env.example.
4. Configurar la conexión con MariaDB.
5. Crear una base de datos vacía e importar database/schema_clinica_salud_agil.sql.
6. Configurar los permisos de storage y bootstrap/cache.
7. Configurar Apache para utilizar el directorio public del proyecto.

## Desarrollo
Ejecutar php artisan serve desde la carpeta del proyecto.
La dirección habitual es http://127.0.0.1:8000.

## Seguridad
No publicar contraseñas, tokens, archivos .env ni datos personales.
Antes de utilizar datos clínicos reales, verificar la autenticación y los permisos por rol.

## Entrega académica
Proyecto de Desarrollo de Proyectos con Software Libre.
