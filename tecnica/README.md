<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```


# Proyecto Yii2 - Gestión de Inventario

Este proyecto es una aplicación web construida con Yii2 para gestionar el inventario de productos. 

## Requisitos Previos

- IDE: Visual Studio Code Editor
- PHP = 8.0.30
- DBMS = DBeaver
- Composer
- Servidor Apache
- Base de datos MySQL o MariaDB

## Instrucciones de Instalación

### 1. Clonar el Repositorio
Antes de iniciar asegúrese de estar en la carpeta del proyecto `tec-castor`
### 2. Instalar Dependencias
Asegúrate de tener Composer instalado. Ejecuta el siguiente comando para instalar las dependencias de PHP: 
```bash
   composer install
   ```
```bash
   composer update
```
### 3. Configuración de la Base de Datos
Crea una base de datos en tu servidor MySQL. Luego, configura la conexión a la base de datos en el archivo ``common/config/main-local.php`:

```html
'components' => [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nombre_base_datos',
        'username' => 'tu_usuario',
        'password' => 'tu_contraseña',
        'charset' => 'utf8',
    ],
],
```

### 4. Ejecutar Migraciones
Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
```bash
    php yii migrate
```
### 5. Inicializa el servidor web local
```bash
     php yii serve --docroot="frontend/web"
```

    Utilice los siguientes usuarios: 
    ```html
        admin1 -> admin123
        almacenista -> almacenista123
    ```
