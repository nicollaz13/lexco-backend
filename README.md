# Sistema de Gestión de Usuarios y Productos - API Backend

API REST desarrollada con **Laravel 13** y **PostgreSQL** para la gestión de inventario y usuarios.

## 🛠️ Tecnologías utilizadas
- Laravel 13
- PostgreSQL
- Sanctum (Autenticación)
- Gitflow

## 🚀 Instrucciones de Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/nicollaz13/lexco-backend.git](https://github.com/nicollaz13/lexco-backend.git)
   cd lexco-backend
2. Instalar dependencias:
    composer install
3. Configurar variables de entorno:
    Copia el archivo .env.example a .env y configura tu base de datos PostgreSQL y la URL del frontend:
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=nombre_tu_db
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_password

    FRONTEND_URL=http://localhost:4200
4. Ejecutar Migraciones:
    php artisan migrate
5. Generar clave de la aplicación:
    php artisan key:generate
6. Seguridad y Roles
Rol Automático: El primer usuario registrado es ADMIN, los siguientes son USER .  
Middleware de Sesión: Máximo 2 usuarios autenticados simultáneamente.  
CORS: Configurado para permitir peticiones desde el frontend en el puerto 4200.

7. Cómo probar la API
Inicia el servidor: php artisan serve.
Importa la Colección de Postman incluida en la carpeta /docs (o raíz) del proyecto.  
Usa el flujo de registro para crear el primer Admin y luego prueba el CRUD de productos.

Autor: Nicolas steven hernandez peña